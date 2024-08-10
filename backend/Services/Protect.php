<?php

namespace Services;
use voku\helper\AntiXSS;

class Protect {
    public function clean_xss($data){
        $AntiXSS = new AntiXSS;
        if(is_array($data)){
            return array_map(array($this, __FUNCTION__) ,$data);
        } else {
            return $AntiXSS->xss_clean($data);
        }
    }
}