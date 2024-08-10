<?php

namespace Controllers;

use Models\Model;
use Services\Blade;

class Payment
{
    public $payment_service;

    function __construct()
    {
        if (app_theme() !== 'mangareader') {
            die('You must use mangareader theme to use this feature');
        }

        if(!\is_login()) {
            die('You must login to use this feature');
        }

        $config = getConf('napthe');

        $this->payment_service = new $config['driver'];
    }

    function index()
    {
        $price = $this->payment_service->getPrice();
        
        return (new Blade())->render('themes.mangareader.pages.payment', [
            'price' => $price
        ]);
    }

    function charging()
    {
        if(empty($_POST['code']) || empty($_POST['serial']) || empty($_POST['telco']) || empty($_POST['amount'])) {
            die('Invalid request');
        }

        $code  = $_POST['code'];
        $serial = $_POST['serial'];
        $telco  = $_POST['telco'];
        $amount = $_POST['amount'];


        $this->payment_service->charging(
            $code, $serial, $telco, $amount,
        );
        

        unset($_SESSION['user_data']);
    }

    function callback()
    {
        $this->payment_service->charge_callback();
    }
}