<?php

//kéo chuyện theo list
class workerScraper extends fsSessionManager
{	
	protected $_dataHandler;
	protected $_limit;
	protected $_error;
	protected $_job;
	protected $_timeout  = 1;
	protected $_database;
	private $_cli;
	private $_siteUrl;

	public function __construct($siteUrl)
	{
		//echo realpath(__DIR__ . '/../..');
		$this->isCli();
		$this->_database = MysqliDb::getInstance();
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
		$jobs       = $this->_database->where('running', 1)->get('crawl_queue');
		$this->_job = $jobs;
	}


	public function handle()
	{
		$site = $this->_siteUrl;
		if (!$this->_job) {
			sleep(5);
			return;
		}
		$response='';		
		foreach ($this->_job as $key => $job) {
			try {
				$url = trim($job['url']);
				$cmd = "php ".realpath(__DIR__ . '/../..')."/backend/bin/console crawl:data $site --url $url --cron 1";
				$response .= $this->runCommand($cmd) . "\n";
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}
		echo $response;
		//echo $site;
	}

	function runCommand($cmd){
        return shell_exec($cmd);
    }
}
