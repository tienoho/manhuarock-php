<?php

namespace Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Command\LockableTrait;
use Models\Model;
use samdark\sitemap\Sitemap;
use samdark\sitemap\Index;

class AutoSitemap extends Command
{
    use LockableTrait;

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:sitemap';

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $mangaSitemap = new Sitemap(ROOT_PATH . '/public/manga_sitemap.xml');
        $chapterSitemap = new Sitemap(ROOT_PATH . '/public/chapter_sitemap.xml');
        $mangaSitemap->setStylesheet(getConf('site')['site_url']. '/sitemap-stylesheet.xsl');
        $chapterSitemap->setStylesheet(getConf('site')['site_url']. '/sitemap-stylesheet.xsl');

        $mangaSitemap->setMaxUrls(25000);
        $chapterSitemap->setMaxUrls(25000);

        Model::getDB()->where('hidden', 0);
        $mangas = Model::getDB()->objectBuilder()->get('mangas', null, 'id, slug, last_update');

        foreach ($mangas as $manga) {
            $mangaSitemap->addItem(
                url(getConf("slug")['manga'], ['m_slug' => $manga->slug . '-' . $manga->id]),
                strtotime($manga->last_update),
                Sitemap::ALWAYS, 0.8
            );

            Model::getDB()->where('manga_id', $manga->id);
            Model::getDB()->where('hidden', 0);

            $chapters = Model::getDB()->objectBuilder()->get('chapters', null, 'id, slug, last_update');
            foreach ($chapters as $chapter) {
                $chapterSitemap->addItem(
                    url(getConf('slug')['chapter'], ['m_slug' => $manga->slug, 'c_slug' => $chapter->slug, 'c_id' => $chapter->id]),
                    strtotime($chapter->last_update),
                    Sitemap::DAILY, 0.6
                );
            }
        }



        $mangaSitemap->write();
        $chapterSitemap->write();

        $mangaSitemapFileUrls = $mangaSitemap->getSitemapUrls(getConf('site')['site_url']. '/');
        $chapterSitemapFileUrls = $chapterSitemap->getSitemapUrls(getConf('site')['site_url']. '/');

        $index = new Index(ROOT_PATH . '/public/sitemap.xml');
        $index->setStylesheet(getConf('site')['site_url']. '/sitemap-stylesheet.xsl');

        foreach ($mangaSitemapFileUrls as $sitemapUrl) {
            $index->addSitemap($sitemapUrl, time());
        }

        foreach ($chapterSitemapFileUrls as $sitemapUrl) {
            $index->addSitemap($sitemapUrl, time());
        }

        $index->write();

        return Command::SUCCESS;
    }
}