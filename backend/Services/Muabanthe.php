<?php

namespace Services;

use Models\Model;

class Muabanthe
{
    private $config;
    function __construct()
    {
        $this->config = getConf('muabanthe');
    }


    function getPrice()
    {
        $url = 'https://muabanthe.vn/API/BangGia?APIKey=' . $this->config['APIKey'];
        $response = file_get_contents($url);
        $response = json_decode($response, true);

        $data = $response['Data'];

        // Sort by Network

        $result['VTT'] = [];
        $result['VMS'] = [];
        $result['VNP'] = [];
        $result['VNM'] = [];

        foreach ($data as $item) {
            if ($item['Status'] === 'on') {
                $result[$item['Network']][] = [
                    'telco' => $item['Network'],
                    'value' => $item['CardValue'],
                    'price' => $item['Price'],
                ];
            }

        }

        $result = array_filter($result);

        return $result;
    }

    function charging($code, $serial, $telco, $amount)
    {
        $db = Model::getDB();
        $payment_id = $db->insert('user_payment', [
            'user_id' => userget()->id,
            'status' => 'PENDING',
            'payment_date' => date('Y-m-d H:i:s'),
            'card_data' => json_encode([
                'code' => $code,
                'serial' => $serial,
                'telco' => $telco,
                'amount' => $amount,
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
        ]);

        $query = \http_build_query([
            'APIKey' => $this->config['APIKey'],
            'Network' => $telco,
            'TrxID' => $payment_id,
            'CardCode' => $code,
            'CardSeri' => $serial,
            'CardValue' => $amount,
            'URLCallback' => \getConf('site')['site_url'] . '/callback.php?TrxID=' . $payment_id . '&APIKey=' . $this->config['APIKey'],
        ]);


        $url = 'https://muabanthe.vn/API/NapThe?' . $query;
        $response = file_get_contents($url);
        $response = json_decode($response, true);

        if ($response['Code'] === 0) {
            $db->where('id', $payment_id)->update('user_payment', [
                'status' => 'FAILED',
                'message' => $response['Message'],
            ]);

            response()->json([
                'message' => $response['Message'],
                'error' => 1,
            ]);

            return;
        }


        if ($response['Code'] === 1) {
            response()->json([
                'message' => 'Hệ thống đang xử lí thẻ này, vui lòng đợi ít phút',
                'success' => 1,
            ]);

            return;
        }


        \response()->json([
            'error' => 1,
            'message' => 'Lỗi không xác định',
        ]);
    }

    public function charge_callback()
    {
        $db = Model::getDB();

        foreach($_GET as $key => $value) {
            $key = \str_replace('amp;', '', $key);
            $_GET[$key] = $value;
        }

        $log = ROOT_PATH . '/log.json'; 
        if (!file_exists($log)) {
             $locontent = [];
        } else {
            $locontent = file_get_contents($log);
            $locontent = json_decode($locontent, true);
        }

        $locontent[] = $_GET;
        file_put_contents($log, json_encode($locontent, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));


        $payment_id = $_GET['TrxID'];

        $code = $_GET['Code'];
        $message = $_GET['Mess'];
        $CardValue = $_GET['CardValue'];

        $user_payment = $db->where('id', $payment_id)->getOne('user_payment');

        if (!$user_payment || $user_payment['status'] !== 'PENDING') {
            die("Not valid!");
        }

        if ($code == 1 || $code == 2 || $code == 3) {
            $status = 'SUCCESS';

            $db->where('id', $payment_id)->update('user_payment', [
                'status' => $status,
                'message' => $message,
            ]);

            $user = $db->where('id', $user_payment['user_id'])->getOne('user');

            $db->where('id', $user_payment['user_id'])->update('user', [
                'coin' => $user['coin'] + ($CardValue ?? json_decode($user_payment['card_data'], true)['amount']),
            ]);
        } else {
            $status = 'FAILED';

            $db->where('id', $payment_id)->update('user_payment', [
                'status' => $status,
                'message' => $message,
            ]);

            die($status);
        }
    }
}