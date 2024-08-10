<?php

use Config\Config;

function app_theme(): string
{
    return getConf('site')['theme'];
}
