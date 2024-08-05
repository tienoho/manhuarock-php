<?php 

class fsSessionManager
{
	//const FSURL = 'http://localhost:8191/v1';
	//const FSURL = 'http://20.205.20.33:8191/v1';
	//const FSURL = 'http://103.160.89.23:8191/v1';
	const FSURL = 'http://103.160.89.199:8191/v1';
    private $site;

	public function __construct()
	{

	}

	public function createSession() {
        $postBody = array("cmd" => "sessions.create");
        return $this->request($postBody);
    }

    public function sessionsList() {
        $postBody = array("cmd" => "sessions.list");
        return $this->request($postBody);
    }

    public function destroySession($sessionId) {
        $postBody = array("cmd" => "sessions.destroy", "session" => $sessionId);
        return $this->request($postBody);
    }
    
	private function request($postBody) {
        $ch = curl_init(self::FSURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postBody));
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public function getContent($url, $sessionId = false, $returnOnlyCookies = false)
    {
        $postBody = array(
            "cmd" => "request.get",
            "url" => $url,
            "maxTimeout" => 60000,
            "session" => $sessionId ? $sessionId : false,
            "returnOnlyCookies" => $returnOnlyCookies
        );
        return $this->request($postBody);
    }
    public function getProxys()
    {
        return array (
            '103.160.89.23:3128',
            '103.160.89.199:3128',
        );
    }
}