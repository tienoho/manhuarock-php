<?php

use Symfony\Component\DomCrawler\Crawler;
use Config\Cache as ConfigCache;
use Services\Cache;

class ImageProxy
{

    function intProxy()
    {
        $raw_data = input()->value('url', null);
        $server = input()->value('server', null);
        if (empty($raw_data)) {
            exit('Không tồn tại');
        } else {
            $raw_data = data_crypt($raw_data, 'd');
            $raw_data = explode('|', $raw_data);

            $time = $raw_data[0];
            $raw_url = $raw_data[1];

            if(time() > $time + (60*60*24)){
                exit('Expired Token');
            }
            $url = $raw_url;
        }


        if (strpos($url, 'scramble') !== false) {
            response()->redirect($url, 200);
        }

        $Cache = Cache::load(ConfigCache::CACHE_PATH, 'images');
        $cacheString = $Cache->getItem(md5($url));

        if (!$cacheString->isExpired() && !$cacheString->isEmpty()) {
            $url = $cacheString->get();
        } else {
            $url = $this->getProxy2($url);

            $cacheString->set($url)->expiresAfter(60 * 60 * 24 * 7);
            $Cache->save($cacheString);
        }

        if ($url) {

            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");

            $id = explode('proxy/', $url)[1];

            if(!empty($server)){
                switch ($server){
                    case 'blogspot':
                        $url = 'https://'. random_int(1,4) .'.bp.blogspot.com/proxy/'. $id;
                        $url_raw = $url;
                        $save = true;
                        break;
                    case 'cid':
                        $url = 'https://ci'. random_int(1,4) .'.googleusercontent.com/proxy/'. $id;
                        $url_raw = $url;
                        $save = true;
                        break;
                    case 'proxy':
                        $url = google_proxy_build($url);
                        $save = false;
                        break;
                    case 'weserv':
                        $url = 'https://cdn.statically.io/img/'. str_replace('https://', '', $url);
                        $save = false;
                        break;
                    default:
//                        $tokens = ($this->getToken());
//                        $url_raw = $this->getProxy($tokens, $raw_url);
                        $url_raw = $this->getProxy2($raw_url);

                        $save = true;
                        $url = $url_raw;
                        break;
                }
                if($save){
                    $cacheString->set($url_raw)->expiresAfter(60 * 60);
                    $Cache->save($cacheString);
                }
            }

            if(strpos($url, 'googleusercontent.com/proxy') !== false){
                $size = input()->value('w');
                if($size){
                    $size = 'w'. $size;
                } else {
                    $size = 's0-d';
                }

                $url = $url . "=$size-e1-ft";
            }

            response()->redirect($url, 307);
        }
    }

    function getToken()
    {
        $url = "https://docs.google.com/picker?protocol=gadgets&nav=((%22upload%22%2C%22T%E1%BA%A3i%20l%C3%AAn%22%2C%7B%22query%22%3A%22gmailphotos%22%2C%22mimeTypes%22%3A%22image%2Fjpeg%2Cimage%2Fgif%2Cimage%2Fpng%2Cimage%2Fbmp%2Cimage%2Fwebp%22%2C%22sdurl%22%3A%22true%22%7D)%2C(%22url%22%2C%22%C4%90%E1%BB%8Ba%20ch%E1%BB%89%20web%20(URL)%22%2C%7B%22type%22%3A%22image%22%7D))";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.71 Safari/537.36 Edg/94.0.992.38",
            "cookie: OGP=-19009731:-19008535:-748494848:-19010602:-19015969:; SEARCH_SAMESITE=CgQIvZMB; OSID=BwiLz_WXUYIxPvXYB6SB6ENse6g318GWM2RGN-_OAkfHu7DycfB24H23UKARVEel2mmq6A.; __Secure-OSID=BwiLz_WXUYIxPvXYB6SB6ENse6g318GWM2RGN-_OAkfHu7Dy_E5E0qlnQfAK5I9cbWV9kA.; __Host-GMAIL_SCH_GMN=1; __Host-GMAIL_SCH_GMS=1; __Host-GMAIL_SCH_GML=1; OGPC=19010599-15:19011583-10:19009731-10:19010602-7:19008539-15:19008535-4:19024399-1:748494848-7:19011552-2:19025497-8:19015969-1:19022519-1:19025836-2:19008572-1:19022552-1:; SID=CAiLz-98bOvCK4j_PWfbRZtlfm6rgpRHQqotuTAjs4WeFsD4My1ZYuqYPxm3V0qpbGdljQ.; __Secure-1PSID=CAiLz-98bOvCK4j_PWfbRZtlfm6rgpRHQqotuTAjs4WeFsD4A-J6UGStBOppT6AZD2sxjg.; __Secure-3PSID=CAiLz-98bOvCK4j_PWfbRZtlfm6rgpRHQqotuTAjs4WeFsD4LwgTQFBnmhLV-S1nN4SngA.; HSID=AkUk7hNS1ZNy5pJMV; SSID=A0wA3yaXltpbuZpz5; APISID=IbHa23vc4Z9vmu3Y/Arfz7ZIas4XhAa8vB; SAPISID=jqQ2JsDOunVx9cXw/AtpUZzUffYLuzoErm; __Secure-1PAPISID=jqQ2JsDOunVx9cXw/AtpUZzUffYLuzoErm; __Secure-3PAPISID=jqQ2JsDOunVx9cXw/AtpUZzUffYLuzoErm; NID=511=g2KFgHUmYDc4DlKfc5AMpaYzyJ-fbctUszFNRZDR1V66QzU59frdg5XYwJPtR_HgRDFNNEvcfsiTvPCDvYY0K-Cn2PR-8-aA2gO3y6-PMf2TAb41ZXLDy4HPTfa-qU9J_EjMHg1ibEz-wzRnJWyVCi9Yh2f6efsOX6A_RXWRx2XeqAtd0RqKWU1d6iJ61aNab0ksbpNy1p9ZKY6NvlRe7-WuzOFZbXCVyXVMPGtzL5XNpVn-nXLTFLxxsXvMuhO2aYjRQvTvWzptBVgoPZMCObFiHBxkxxvwPIDemZzT7ps_5ah55SCe6G7D5Pg-uSfnxfrgbf8iygMaLa62lI4ixF_KjK-l6vAjlm_sOjhy1RCmpvjg76s8odufE2kdO3PAwfJxQSeJ9cZsBozwEOEsT9tX-IxkyBR5qIIHl6hMWrXEKOsbOq0DrMZSDaziu81_5Vfg0vLD-HkDYo41o98VVUoBuEURTQXl0TT4bTx2mbACSW8bNYsbaScF7WpicHF5YLRtpByEkldRdeiFDEOLlZo3mZAb-Rnl9mU6yTb7uVVGiYQMIpVgn8MT1mUnRILRUclfl2JuXItomtk; __Host-GMAIL_SCH=nsl; 1P_JAR=2021-10-07-06; SIDCC=AJi4QfEdpmqVw2q5f6a4xHoOtb_EIbRBxZpM9rDAC6fub0-uIgDD9ek5lHxY5kc4Xlg2gWtQRzQ; __Secure-3PSIDCC=AJi4QfHtqz_R5LJPF4DiP5kKyysINe-Ub55hQKx5_qbpYu0h8HRokjL86n_imT0qRxWQXCBhwLFs",
            "Content-Type: ",
            "Content-Length: 0"
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);


        $resp = curl_exec($curl);
        curl_close($curl);

        $crawler = new Crawler($resp);
        $data = $crawler->filter('script')->outerHtml();
        $data = json_decode(explode_by('var rawConfig =', '</script>', $data));

        if (empty($data)) {
            exit('Lỗi khi lấy token vui lòng kiểm tra cookies');
        }

        return ["xtoken" => $data->xtoken, "token" => $data->token, "params" => $data->uriParams,];
    }

    function getProxy($tokens, $image_url)
    {
        $url = sprintf("https://docs.google.com/picker/getcu?hl=vi&xtoken=%s&origin=https%%3A%%2F%%2Fmail.google.com&hostId=gm-i", $tokens['xtoken']);

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array("User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.71 Safari/537.36 Edg/94.0.992.38", "cookie: OGP=-19009731:-19008535:-748494848:-19010602:-19015969:; SEARCH_SAMESITE=CgQIvZMB; OSID=BwiLz_WXUYIxPvXYB6SB6ENse6g318GWM2RGN-_OAkfHu7DycfB24H23UKARVEel2mmq6A.; __Secure-OSID=BwiLz_WXUYIxPvXYB6SB6ENse6g318GWM2RGN-_OAkfHu7Dy_E5E0qlnQfAK5I9cbWV9kA.; __Host-GMAIL_SCH_GMN=1; __Host-GMAIL_SCH_GMS=1; __Host-GMAIL_SCH_GML=1; OGPC=19010599-15:19011583-10:19009731-10:19010602-7:19008539-15:19008535-4:19024399-1:748494848-7:19011552-2:19025497-8:19015969-1:19022519-1:19025836-2:19008572-1:19022552-1:; SID=CAiLz-98bOvCK4j_PWfbRZtlfm6rgpRHQqotuTAjs4WeFsD4My1ZYuqYPxm3V0qpbGdljQ.; __Secure-1PSID=CAiLz-98bOvCK4j_PWfbRZtlfm6rgpRHQqotuTAjs4WeFsD4A-J6UGStBOppT6AZD2sxjg.; __Secure-3PSID=CAiLz-98bOvCK4j_PWfbRZtlfm6rgpRHQqotuTAjs4WeFsD4LwgTQFBnmhLV-S1nN4SngA.; HSID=AkUk7hNS1ZNy5pJMV; SSID=A0wA3yaXltpbuZpz5; APISID=IbHa23vc4Z9vmu3Y/Arfz7ZIas4XhAa8vB; SAPISID=jqQ2JsDOunVx9cXw/AtpUZzUffYLuzoErm; __Secure-1PAPISID=jqQ2JsDOunVx9cXw/AtpUZzUffYLuzoErm; __Secure-3PAPISID=jqQ2JsDOunVx9cXw/AtpUZzUffYLuzoErm; NID=511=g2KFgHUmYDc4DlKfc5AMpaYzyJ-fbctUszFNRZDR1V66QzU59frdg5XYwJPtR_HgRDFNNEvcfsiTvPCDvYY0K-Cn2PR-8-aA2gO3y6-PMf2TAb41ZXLDy4HPTfa-qU9J_EjMHg1ibEz-wzRnJWyVCi9Yh2f6efsOX6A_RXWRx2XeqAtd0RqKWU1d6iJ61aNab0ksbpNy1p9ZKY6NvlRe7-WuzOFZbXCVyXVMPGtzL5XNpVn-nXLTFLxxsXvMuhO2aYjRQvTvWzptBVgoPZMCObFiHBxkxxvwPIDemZzT7ps_5ah55SCe6G7D5Pg-uSfnxfrgbf8iygMaLa62lI4ixF_KjK-l6vAjlm_sOjhy1RCmpvjg76s8odufE2kdO3PAwfJxQSeJ9cZsBozwEOEsT9tX-IxkyBR5qIIHl6hMWrXEKOsbOq0DrMZSDaziu81_5Vfg0vLD-HkDYo41o98VVUoBuEURTQXl0TT4bTx2mbACSW8bNYsbaScF7WpicHF5YLRtpByEkldRdeiFDEOLlZo3mZAb-Rnl9mU6yTb7uVVGiYQMIpVgn8MT1mUnRILRUclfl2JuXItomtk; __Host-GMAIL_SCH=nsl; 1P_JAR=2021-10-07-06; SIDCC=AJi4QfEdpmqVw2q5f6a4xHoOtb_EIbRBxZpM9rDAC6fub0-uIgDD9ek5lHxY5kc4Xlg2gWtQRzQ; __Secure-3PSIDCC=AJi4QfHtqz_R5LJPF4DiP5kKyysINe-Ub55hQKx5_qbpYu0h8HRokjL86n_imT0qRxWQXCBhwLFs", "Content-Type: application/x-www-form-urlencoded",);

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $fields = array('url' => $image_url, 'token' => $tokens['token'], 'version' => 4, 'app' => $tokens['params']->app, 'clientUser' => $tokens['params']->clientUser, 'subapp' => $tokens['params']->subapp, 'authuser' => $tokens['params']->authuser,);
        $fields_string = http_build_query($fields);

        curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);

        $resp = curl_exec($curl);
        curl_close($curl);

        $url = explode_by('"contentUrl":"', '"', $resp);

        if (strpos($url, 'proxy') === false) {
            exit('Lỗi khi get proxy');
        }

        return $url;
    }

    function getProxy2($image_url){
        $url = "https://mail.google.com/mail/u/1/piu?ui=2&ik=3ca2f50f39&jsver=AhPa8K7tm5w.vi..es5&cbl=gmail.pinto-server_20211004.06_p0&url=$image_url&_reqid=877962&pcd=1&cfact=7057&cfinact=7083,7056,7082,7058,7117,7086,7085,7084&mb=0&rt=j";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Content-Type: application/json",
            "cookie: COMPASS=gmail=CooBAAlriVfXkL7Fqk1wCo_ynGKAHxLoImQflKrO-lhDP_U5G4fk58wK-jsmme7Jh0EehFwIRJYKRXDaa14rkqpDuS1ouypQir0wVotx5wNIiC3nyEK_SVscImLeRespYAkherTjn4AXVOhbKeKfLNIO3L3lPCHJlsH98lumRQIFbAfjSxkP1puTJRZzELSHsYsGGpwBAAlriVeTK0DpeT9jK9sXwPA5o8m8mtz2qN_LgmZkddEcgzBIT-udEJb1SWEjRhUSbLj5osgSMxHzVJh-PMzJe9oD3pob_ExFiZXjC_I_S7zaYrGapiXoTz7Th_c5IbwRIXhJxN7UGITSAxHYKumsYXhkMdu4-e0w0j3rbpvhTvEgMKboZjc7az8Rq9x8wEVmcbSUzvAk5Qt4p7w1:gmail_ps=CogBAAlriVcBFg0fv8O_DcBq9J7_jAAsE6cnPL9fO_zOYuTK7DrxqbjBPQ4HxFsYF6VGIbYSg1twPaUphVLRFgddVlmX12XP5Ism4Wbm_9ipXy-J48eDAG_Wnd7DlTc33wcArcD_aSiWAXXf9JkaHZjEcduI6ADRBUaoWAlQC8oErZgxmVChLLEN3xDah7GLBhqaAQAJa4lXmcRnaJ6seJifgW_YdmDms96wPaBU3Drwn_hABrux_vNKqKo_wElTExF7BHDW_maCv21Kt2g0g1L8cg5vYf83r61e9l9Wy8lzDGb2Fdf5bUMJZODu5gvOONeZCWXToel9ACUiE-MWmQgYqzRrnOjglMi9uCJrBoni7E1g2bOTkAjT_oEL_nFQ9kTf39MwaozpC5DKfPU; GMAIL_AT=AF6bupNiNG9sqY388si9_NipOeYO34y75g; GMAIL_STAT_a071=/S:v=2&a=ob&sv=ti&ev=ti&t=221&i=6&id=6&hc=6&sp=1&mn=cs%3A0&ai=mail%3Aob.a071.1.0&fua=1; GMAIL_IMP=v*2%2Fhc*6%2Fsw-as-rs%2Ftadis*28%2Fuap-as-l*1!ob%2Faw-ss-cw-cwit%2Faw-ss-cw-cwit-t%2Faw-ss-i-cwit%2Faw-ss-i-cwit-t%2Flma*221*500!ob%2Ffua*221*51927*3469*6!ti!ob!ti%2Fcm-sbw-bg*452%2Fcm-tb-im-so%2Foig-i%2Faw-ss-cw-dst%2Faw-ss-cw-dst-t%2Faw-ss-i-dst%2Faw-ss-i-dst-t%2Flkr-kwp-kwmnf%2Ftadis*46%2Ftadis*21%2Ftl-ard-s*398%2Ftadis*0%2Ftl-ar-sdd*10014%2Ftl-ard-s*384%2Ftl-tbsfd*12983%2Ftadis*0%2Ftl-ar-sdd*10147%2Ftl-ard-s*368%2Ftl-tbsfd*55982%2Ftl-ar-sdd*10001%2Ftl-ard-s*316%2Ftl-tbsfd*43947%2Ftadis*19%2Ftadis*3%2Ftl-ar-sdd*10005%2Ftl-ard-s*315%2Ftl-tbsfd*42610%2Ftadis*30%2Ftadis*1%2Ftl-ar-sdd*10463%2Ftl-ard-s*315%2Ftl-tbsfd*91396%2Ftadis*5%2Ftl-ar-sdd*10666%2Ftl-ard-s*325%2Ftl-tbsfd*47018%2Ftl-ar-s*7%2Ftl-ar-f*7; COMPASS=gmail=CooBAAlriVfXkL7Fqk1wCo_ynGKAHxLoImQflKrO-lhDP_U5G4fk58wK-jsmme7Jh0EehFwIRJYKRXDaa14rkqpDuS1ouypQir0wVotx5wNIiC3nyEK_SVscImLeRespYAkherTjn4AXVOhbKeKfLNIO3L3lPCHJlsH98lumRQIFbAfjSxkP1puTJRZzEN6HsYsGGpwBAAlriVeTK0DpeT9jK9sXwPA5o8m8mtz2qN_LgmZkddEcgzBIT-udEJb1SWEjRhUSbLj5osgSMxHzVJh-PMzJe9oD3pob_ExFiZXjC_I_S7zaYrGapiXoTz7Th_c5IbwRIXhJxN7UGITSAxHYKumsYXhkMdu4-e0w0j3rbpvhTvEgMKboZjc7az8Rq9x8wEVmcbSUzvAk5Qt4p7w1; __Host-GMAIL_SCH_GMN=1; __Host-GMAIL_SCH_GMS=1; __Host-GMAIL_SCH_GML=1; 1P_JAR=2021-10-17-14; SID=DAhcMshwXSYf0DQ8wUETgnaxaT1OfGXFSjj5b-5MezhQeFrXnBSmzzm92t6JbLyz4DAD0w.; __Secure-1PSID=DAhcMshwXSYf0DQ8wUETgnaxaT1OfGXFSjj5b-5MezhQeFrXQg9Rns4tnUTVJfXlP5RyXg.; __Secure-3PSID=DAhcMshwXSYf0DQ8wUETgnaxaT1OfGXFSjj5b-5MezhQeFrXh5oxlmaWgyboIe3eD_hcHA.; HSID=Ab75rWxz-I73A2c4Z; SSID=A2xfyfhfx_cvrhPJ9; APISID=tk6CcmugGuu7DONj/AN4e9u9-nYv0Y_8TE; SAPISID=SBe0XfUO9yDbxLFA/ARbSMmWKpCy8bPfIT; __Secure-1PAPISID=SBe0XfUO9yDbxLFA/ARbSMmWKpCy8bPfIT; __Secure-3PAPISID=SBe0XfUO9yDbxLFA/ARbSMmWKpCy8bPfIT; NID=511=ewHX1s9frsgVZE_DjiEkqqZsWumcdCYDwyZHug_DEtb6yg0VoHIbiJLcXWucRXJpVcY6sof0nD7bdVdx4WKzw6G5g8js87oqqyvnt9oySjdghUWSS_LJ5dNDnEglM9fp2I5HEfeTJiST2BdAG6zBMiox3QymrR0fHHbOzbGyUh4loCirFVb-anHb5Obk0uuyD2im2Vvhx_kg005uEzBH3LHCWewTVQkPrYsGiySvVItezGvt3EvlVhmJ3lDkGam7EfTtCo0RYJ9ulXQU_Rvx; OGPC=19009731-1:; OSID=DAhcMrKK4xb45e3DUrcoufY8STq3QHfRTS6xGYHX8FaK87uDerCmMmrywZOE6kmN1v-Mkw.; __Secure-OSID=DAhcMrKK4xb45e3DUrcoufY8STq3QHfRTS6xGYHX8FaK87uD93RrmUvSWppc8OC8vkOxog.; __Host-GMAIL_SCH=nl; SIDCC=AJi4QfF_ZE4lXbQbGi54rtsDtcg2gbmcVlSy5lOYDAS-oAUGt4N7JISuYbLyFY4vrtUO0uXcMw; __Secure-3PSIDCC=AJi4QfEXkbSxMoyzw0kGczn7mcXm-TRM7gn05Kk7UgSOoJ_76RV7ail5zk0ydkLzdvPlBWZKUg",
            "origin: https://mail.google.com",
            "referer: https://mail.google.com/mail/u/1/",
            "user-agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.81 Mobile Safari/537.36 Edg/94.0.992.50",
            "Content-Length: 0",
        );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $resp = curl_exec($curl);
        curl_close($curl);

        $url = explode_by('","', "\\", $resp);

        if (strpos($url, 'proxy') === false) {
            exit('Lỗi khi get proxy');
        }
        return $url;
    }
}