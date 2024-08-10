<?php

use Ausi\SlugGenerator\SlugGenerator;


function slugGenerator($string){
    $generator = new SlugGenerator;

    return $generator->generate($string, ['locale' => 'en_US']);
}