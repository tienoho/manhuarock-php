<?php
use Aws\S3\S3Client;

class workerUploadWasabiCdn {
	private $_limit;
	private $_dataHandler = [];
	private $_config;
	protected $_database;
    private $_job;
    private $_s3;


	public function __construct($limit, $config) {
		$this->_database = MysqliDb::getInstance();
		$this->_limit = $limit;
        $this->_config = $config;
		$this->getJob();
	}

	public function config(array $config) {
		$this->_config = $config;
		return $this;
	}

	protected function getJob()
	{
		$jobs       = $this->_database->where('status', 1)->orderBy('id', 'ASC')->get('crawl_sync_cdn', $this->_limit);
		foreach ($jobs as $job) {
			$this->updateItemAsProcessing($job['id']);
		}
		$this->_job = $jobs;
	}

	private function updateStatus($itemId, $status, $message = 'null')
	{
		$inputInfo     = [
			'status'  => $status,
			'message' => $message,
		];
		$this->_database->where('id', $itemId)->update('crawl_sync_cdn', $inputInfo);
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
		$this->_database->where('id', $itemId)->delete('crawl_sync_cdn');
	}

    protected function updateData($itemId, $data) {
		$this->_database->where('id', $itemId)->update('chapter_data', $data);
	}

	private function getDataHandler($itemId) {
		$data = $this->_database->where('id', $itemId)->getOne('chapter_data', 'id, content');
		return is_array($data) ? $data : [];
	}

	private function deleteImg($imageList) {
		if (!count($imageList)) {
			return;
		}

		foreach ($imageList as $key => $img) {
			$link =  trim(str_replace($this->_config['site_url'] . '/uploads/', '', $img));
            $url = '../../publish/uploads/' . $link;
			unlink(trim($url));
		}
	}

	public function handle() {
		if (!$this->_job) {
			sleep(5);
			return;
		}

		$started = time();
		$this->_s3 = new S3Client([
            'region' => 'ap-southeast-1',
            'version' => 'latest',
            'endpoint' => $this->_config['wasabi']['endpoint'],
            'use_path_style_endpoint' => true,
            'use_aws_shared_config_files' => false,
            'credentials' => [
                'key' => $this->_config['wasabi']['access_key'],
                'secret' => $this->_config['wasabi']['secret_key']
            ]
        ]);

		foreach ($this->_job as $job) {
			$finalUrl = [];
			try {
				$this->_dataHandler = $this->getDataHandler($job['chapter_data_id']);
				if (!is_array($this->_dataHandler)) {
					$this->deleteItem($job['id']);
					sleep(5);
					return 'Chapter null,';
				}
				$imageList = json_decode($this->_dataHandler['content'], true);
				foreach ($imageList as $img) {
					$directoryCdn = trim(str_replace($this->_config['site_url'] . '/uploads/', '', $img));
					$upload = $this->_s3->putObject([
                        'Bucket' => $this->_config['wasabi']['bucket_name'],
                        'Key' => $directoryCdn,
                        'ACL' => 'public-read',
                        'SourceFile' => '../../publish/uploads/' . $directoryCdn
                    ]);
                    $url = $upload['ObjectURL'];
					if ($url) {
						$finalUrl[] = str_replace(sprintf("%s/%s", $this->_config['wasabi']['endpoint'], $this->_config['wasabi']['bucket_name']), $this->_config['wasabi']['site_url_cdn'], $url);
					}
				}
				$this->updateData($job['chapter_data_id'], [
                    'content' => json_encode($finalUrl),
                    'storage_name' => 'Wasabi'
                ]);
				$this->deleteImg($imageList);
				$this->deleteItem($job['id']);
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}
		echo time() - $started.',';
		$this->reset();
	}

	private function reset() {
		$this->_dataHandler = null;
		$this->_job = [];
	}
}