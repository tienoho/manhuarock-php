<?php
include __DIR__ . '/controllers/cont.main.php';


$db->mysqli()->query('CREATE TABLE `crawl_chapters` (
    `id` int(11) NOT NULL,
    `manga_id` int(11) NOT NULL,
    `chapter_id` int(11) NOT NULL,
    `url` text NOT NULL,
    `status` int(1) NOT NULL DEFAULT 1,
    `message` text DEFAULT NULL,
    `created_at` datetime DEFAULT current_timestamp()
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;');
$db->mysqli()->query('ALTER TABLE `crawl_chapters`
ADD PRIMARY KEY (`id`);');
$db->mysqli()->query('ALTER TABLE `crawl_chapters`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;');

$db->mysqli()->query("CREATE TABLE `crawl_sync_cdn` (
    `id` int(11) NOT NULL,
    `chapter_data_id` int(11) NOT NULL,
    `status` int(1) NOT NULL DEFAULT 1,
    `message` text DEFAULT NULL,
    `created_at` datetime DEFAULT current_timestamp()
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
$db->mysqli()->query('ALTER TABLE `crawl_sync_cdn`
  ADD PRIMARY KEY (`id`);');
$db->mysqli()->query('ALTER TABLE `crawl_sync_cdn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;');


echo 'Done';
