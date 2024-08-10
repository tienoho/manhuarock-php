<?php

namespace Services;

use Models\Model;

class Thesieure
{

    public $setting;
    public $domain = 'https://thesieure.com';

    public function __construct()
    {
        $config = getConf('napthe');
        $this->setting = $config['thesieure'];
    }

    public function getPrice()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->domain . '/chargingws/price?partner_id=' . $this->setting['partner_id'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        )
        );

        $response = curl_exec($curl);

        curl_close($curl);

        $data = json_decode($response, true);

        return $data;
    }

    public function charging($code, $serial, $telco, $amount)
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

        $curl = curl_init();

        $data = \http_build_query(array(
                'telco' => $telco,
                'code' => $code,
                'serial' => $serial,
                'amount' => $amount,
                'request_id' => $payment_id,
                'partner_id' => $this->setting['partner_id'],
                'sign' => md5($this->setting['partner_key'] . $code . $serial),
                'command' => 'charging',
        ));

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->domain . '/chargingws/v2',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response = json_decode($response, true);

        if ($response['status'] === 4) {
            $db->where('id', $payment_id)->update('user_payment', [
                'status' => "FAILED",
                'message' => $response['message'],
            ]);

            response()->json([
                'message' => 'Hệ thống đang bảo trì, vui lòng thử lại sau',
                'error' => 1,
            ]);

            return;
        }

        if ($response['status'] === 1 || $response['status'] === 2) {
            if ($response['status'] === 2) {
                $message = 'Thẻ thành công sai mệnh giá';
            }

            $db->where('id', $payment_id)->update('user_payment', [
                'status' => "SUCCESS",
                'message' => $message,
            ]);

            $db->where('id', userget()->id)->update('users', [
                'coin' => 'coin + ' . ($response['declared_value'] * $_ENV['tranfer_rate']),
            ]);

            response()->json([
                'message' => 'Nạp tiền thành công',
                'success' => 1,
            ]);

            return;
        }

        if ($response['status'] === 3) {
            $db->where('id', $payment_id)->update('user_payment', [
                'status' => "FAILED",
                'message' => $response['message'],
            ]);

            response()->json([
                'message' => 'Nạp tiền thất bại, thẻ lỗi',
                'error' => 1,
            ]);

            return;
        }

        response()->json([
            'message' => 'Thẻ của bạn đang được xử lý, vui lòng kiểm tra lại sau ít phút',
            'status' => 1,
        ]);
    }

    public function charge_callback()
    {
        $data = \json_decode(file_get_contents('php://input'), true);

        $db = Model::getDB();
        $user_payment = $db->where('id', $data['request_id'])->getOne('user_payment');

        if (!$user_payment || $user_payment['status'] === 'SUCCESS') {
            return;
        }

        if ($data['status'] == 1) {

            $db->where('id', $user_payment['user_id'])->update('users', [
                'coin' => 'coin + ' . ($data['declared_value'] * $_ENV['tranfer_rate']),
            ]);

            $db->where('id', $data['request_id'])->update('user_payment', [
                'status' => "SUCCESS",
                'message' => $data['message'],
            ]);

        }
    }
}
