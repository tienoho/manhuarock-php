<?php
class workerDownload extends fsSessionManager
{
	protected $_status;
	protected $_dataHandler;
	protected $_limit;
	protected $_error;
	protected $_job;
	protected $_savePath = '../publish/uploads/manga';
	protected $_timeout  = 1;
	protected $_database;
	private $_cli;
	private $_siteUrl;

	public function __construct($limit, $siteUrl)
	{
		$this->isCli();
		$this->_database = MysqliDb::getInstance();
		$this->_limit    = $limit;
		$this->_siteUrl = $siteUrl;
		$this->getJob();
		$this->_dataHandler = new listSite();
	}

	private function isCli()
	{
		if (PHP_SAPI === 'cli') {
			$this->_cli = true;
		}
	}

	protected function getJob()
	{
		$jobs       = $this->_database->where('status', 1)->orderBy('id', 'ASC')->get('crawl_chapters', $this->_limit);
		foreach ($jobs as $job) {
			$this->updateItemAsProcessing($job['id']);
		}
		$this->_job = $jobs;
	}

	private function updateStatus($itemId, $status, $message = 'null')
	{
		$this->_status = $status;
		$this->_error = $message;
		$inputInfo     = [
			'status'  => $status,
			'message' => $message,
		];
		$this->_database->where('id', $itemId)->update('crawl_chapters', $inputInfo);
	}

	protected function updateItemAsProcessing($itemId)
	{
		$this->updateStatus($itemId, 2, null);
	}

	protected function updateItemAsFail($itemId, $message)
	{
		$this->updateStatus($itemId, 3, $message);
	}

	protected function deleteItem($itemId)
	{
		$this->_database->where('id', $itemId)->delete('crawl_chapters');
	}

	protected function generateRandomString($length = 30)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$randomString = '';

		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}

		return $randomString;
	}

	protected function downloadAllImages($args = array())
	{
		$started = time();
		$defaults = array(
			'urls'             => array(),
			'batch'            => 3,
			'max_time'         => (60 * 6 * 3),
			'max_request_time' => 0,
			'max_connect_time' => 0,
			'max_redirs'       => 10,
			'user_agent'       => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
			'headers'          => array('Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9', 'Referer: ' . $args['site']),
			'savedir'          => '',
			'chapter_id'     => '',
			'manga_id'       => '',
		);
		$args = array_merge($defaults, $args);

		$urls     = $batch     = $user_agent     = $headers     = $savedir     = $manga_id     = $chapter_id     = null;
		$max_time = $max_request_time = $max_connect_time = $max_redirs = null;
		
		extract($args, EXTR_IF_EXISTS);
        
        $user_agent = $args['user_agent'];
        $headers = $args['headers'];
         
		$newArray = [];
		if (strlen(ini_get('open_basedir')) > 0) {
			$max_redirs = 0;
		}
		
		$total_urls = count($urls);

		print_r($total_urls);

		foreach (array_chunk($urls, $batch, true) as $the_urls) {
			$con = $fps = array();
			$mh  = curl_multi_init();
			curl_multi_setopt($mh, CURLMOPT_MAXCONNECTS, 20);
			curl_multi_setopt($mh, CURLMOPT_PIPELINING, 2);

			foreach ($the_urls as $i => $url) {
				$url = trim($url);

				$con[$i] = curl_init($url);
				curl_setopt($con[$i], CURLOPT_RETURNTRANSFER, 0);
				curl_setopt($con[$i], CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($con[$i], CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($con[$i], CURLOPT_VERBOSE, 0);

				preg_match('#\.(png|jpg|gif|jpeg)#is', strtolower($url), $ext);
				$fileExtension = $ext[1] ? $ext[1] : 'jpg';

				$fileName = $savedir . '/' . $manga_id . '/' . $chapter_id . '/' . $this->generateRandomString() . '.' . $fileExtension;
				if (!is_dir($savedir . '/' . $manga_id . '/' . $chapter_id)) {
					chdir($savedir);
					mkdir($manga_id . '/' . $chapter_id, 0777, true);
					chmod($manga_id, 0777);
					chmod($manga_id . '/' . $chapter_id, 0777);
				}
				$newArray[] = str_replace(ROOT_DIR . '/' . '../publish', $this->_siteUrl, $fileName);

				$fps[$i] = fopen($fileName, 'wb');


				curl_setopt($con[$i], CURLOPT_FILE, $fps[$i]);
				curl_setopt($con[$i], CURLOPT_CONNECTTIMEOUT, $max_connect_time);
				curl_setopt($con[$i], CURLOPT_TIMEOUT, $max_request_time);

				if ($max_redirs > 0) {
					curl_setopt($con[$i], CURLOPT_FOLLOWLOCATION, 1);
				}
				curl_setopt($con[$i], CURLOPT_MAXREDIRS, $max_redirs);
				curl_setopt($con[$i], CURLOPT_FAILONERROR, 0);
				curl_setopt($con[$i], CURLOPT_HEADER, 0);
				if (!empty($user_agent)) {
					curl_setopt($con[$i], CURLOPT_USERAGENT, $user_agent);
				}
				if (count($headers) > 0) {
					curl_setopt($con[$i], CURLOPT_HTTPHEADER, $headers);
				}
				curl_multi_add_handle($mh, $con[$i]);
			}

			$still_running = null;
			do {
				$status = curl_multi_exec($mh, $still_running);
			} while ($still_running > 0);

			foreach ($the_urls as $i => $url) {
				$code   = curl_getinfo($con[$i], CURLINFO_HTTP_CODE);
				$rcount = curl_getinfo($con[$i], CURLINFO_REDIRECT_COUNT);
				$size   = curl_getinfo($con[$i], CURLINFO_SIZE_DOWNLOAD);

				if ($rcount > $max_redirs || curl_errno($con[$i]) || $size <= 0) {
					if (is_resource($fps[$i])) {
						fclose($fps[$i]);
					}
				}

				curl_multi_remove_handle($mh, $con[$i]);
				curl_close($con[$i]);
			}

			curl_multi_close($mh);

			foreach ($fps as $fp) {
				if (is_resource($fp)) {
					fclose($fp);
				}
			}
			//sleep($this->_timeout);
		}
		return $newArray;
	}

	protected function updateData($mangaId, $chapterId, $url, $imageList)
	{
		if (!$imageList) {
			throw new Exception('Image is empty');
		}
		$chapterDataId = $this->_database->insert('chapter_data', [
			'type' => 'image',
			'content' => json_encode($imageList),
			'source' => $url,
			'storage' => 'Truyenqq',
			'chapter_id' => $chapterId,
			'storage_name' => 'Local'
		]);
		if ($chapterDataId) {
			$this->_database->where('id', $mangaId)->update('mangas', [
				'last_update' => $this->_database->now()
			]);
			$this->_database->where('id', $chapterId)->update('chapters', ['last_update' => $this->_database->now(), 'hidden' => 0]);
			return $chapterDataId;
		}
		return false;
	}

	private function addQueue($chapterDataId)
	{
		$this->_database->insert('crawl_sync_cdn', ['chapter_data_id' => $chapterDataId, 'created_at' => $this->_database->now()]);
		return true;
	}

	public function handle()
	{
		if (!$this->_job) {
			sleep(5);
			return;
		}

		$started = time();
		foreach ($this->_job as $key => $job) {

			try {

				$value = $this->_dataHandler->getValue($job['url']);

				if (!$value) {
					$this->deleteItem($job['id']);
					sleep(5);
					return false;
				}

				$dataProcess = [
					'savedir' => ROOT_DIR . '/' . $this->_savePath,
					'manga_id'   => $job['manga_id'],
					'chapter_id' => $job['chapter_id'],
					'urls'    => $value,
					'site'    => $job['url'],
				];

				$finalList = $this->downloadAllImages($dataProcess);

				if ($finalList) {
					$this->deleteItem($job['id']);
					$chapterDataId = $this->updateData($job['manga_id'], $job['chapter_id'], $job['url'], $finalList);
					if ($chapterDataId) {
						$this->addQueue($chapterDataId);
						$this->deleteItem($job['id']);
					}
				}
			} catch (Exception $e) {
				$this->updateItemAsFail($job['id'], $e->getMessage());
				throw new Exception($e->getMessage());
			}
		}
		$total = time() - $started . ',';
		echo $total;
	}
}
