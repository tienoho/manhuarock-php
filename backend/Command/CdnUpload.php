<?php

namespace Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

class CdnUpload extends Command {
    protected static $defaultName = 'cdn:upload';

    protected function configure(): void {
        $this->setDescription('Upload covers to CDN');
        $this->setHelp('Upload covers to CDN');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        do {
            $continue = true;

            // get content where type = image & storage_name = null
            $contents = \Models\Model::getDB()->objectBuilder()->where('type', 'image')
            ->where('storage_name', null, 'IS')
            // content not like cdn.
            ->where('content', '%cdn%', 'NOT LIKE')
            ->where('content', '%tmp%', 'NOT LIKE')
            ->getOne('chapter_data');

            if(empty($contents) || !is_object($contents)){
                $continue = false;
                break;
            }

            $images = json_decode($contents->content, true);

            if(empty($images) || !is_array($images)){
                break;
            }

            $storage = new \Services\Wasabi();

            $urls = [];
            $total_die = 0;
            foreach ($images as $url) {
                // get path only
                $path = parse_url($url, PHP_URL_PATH);
                $full_path = ROOT_PATH . '/public' . $path;

                if($total_die > 5){
                    break;
                }


                if(!file_exists($full_path)){
                    $output->writeln('File not found: ' . $full_path);

                    $total_die++;
                    continue;
                }
                

                $url = $storage->upload(file_get_contents($full_path), trim($path, '/'));
                $urls[] = $url;
                

                $output->writeln($url);
            }

            if(empty($urls)){
                break;
            }

            // update chapter_data
            \Models\Model::getDB()->where('id', $contents->id)->update('chapter_data', [
                'content' => json_encode($urls),
                'storage_name' => 'Wasabi'
            ]);
            
            $output->writeln($contents->id);
            
        } while ($continue);
        

        return Command::SUCCESS;
    }
}