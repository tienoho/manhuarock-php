<?php
namespace Middleware;

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

class reCAPTCHAv2 implements IMiddleware {
    public $capcha_enable = false;
    public function validate(Request $request){
        if($request->isAjax()){
            $captcha = input()->value('g-recaptcha-response');

            $secretKey = "6Lcig7scAAAAAKz6UOq09xrdFUGMF--k3z1Pn7fq";
            // post request to server
            $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
            $response = file_get_contents($url);
            $responseKeys = json_decode($response,true);
            if($responseKeys["success"]){
                return true;
            }
        }

        return false;
    }

    public function handle(Request $request)  : void {
        if($this->capcha_enable && !$this->validate($request)){
            response()->httpCode(403)->json(['status' => false, 'mes' => 'Vui lòng xác nhận bạn không phải robot']);
        }
    }

}