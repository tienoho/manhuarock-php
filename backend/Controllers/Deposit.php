<?php

namespace Controllers;

use Models\Model;
use Services\Blade;

class Deposit
{
  public function deposit($page = 1)
    {
        $search = input()->value('search');
    
        $db = Model::getDB();
    
        $db->join('user', 'deposit.user_membership_id = user.id', 'LEFT');
    
        if ($search) {
            $db->where('deposit.code', "%$search%", "LIKE");
            $db->Orwhere('deposit.user_membership_id', "%$search%", "LIKE");
        }
    
        $db->pageLimit = 10;
    
        $deposits = $db->objectBuilder()->paginate('deposit', $page, 'deposit.id as deposit_id, deposit.code, deposit.user_membership_id, deposit.type, deposit.amount, deposit.status, deposit.created_at, user.name, user.email, user.id as user_id');
    
        return (new Blade)->render('admin.pages.deposit', [
            'page' => $page,
            'total_page' => $db->totalPages,
            'deposits' => $deposits,
        ]);
    }


    //add coin
    function addDeposit()
    {
        $transactionCode = input()->value('transactionCode');
        $userMembershipId = userget()->id;
        $paymentMethod = input()->value('paymentMethod');
        $amount = input()->value('amount');
        $status = 'pending';

        if (!$paymentMethod || !$amount) {
            response()->httpCode(400)->json([
                'status' => false,
                'message' => 'Invalid input data'
            ]);
            return;
        }

        $input = [
            'code' => $transactionCode,              
            'user_membership_id' => $userMembershipId,
            'type' => $paymentMethod,
            'amount' => $amount,
            'status' => $status,
            'created_at' => date('Y-m-d H:i:s')       
        ];

        $result = Model::getDB()->insert('deposit', $input);

        if ($result) {
            response()->json([
                'status' => true
            ]);
        } else {
            response()->json([
                'status' => false,
                'error' => Model::getDB()->getLastError()
            ]);
        }
    }
    //Admin duyệt => thêm coin vào user
    function updateDepositApprove() {
        try {
            $id = request()->post('deposit_id');
    
            if (!$id) {
                return response()->json([
                    'status' => false,
                    'error' => 'Deposit ID not provided.'
                ]);
            }
    
            $input = [
                'status' => 'success',
                'updated_at' => date('Y-m-d H:i:s')
            ];
    
            $result = Model::getDB()->update('deposit', $input, ['id' => $id]);
    
            if ($result) {
                return response()->json(['status' => true]);
            } else {
                return response()->json([
                    'status' => false,
                    'error' => Model::getDB()->getLastError()
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    function updateDepositReject()
    {
        $status = 'reject';  
        $id = input()->value('id');
    
        if (!$id) {
            response()->httpCode(400)->json([
                'status' => false,
                'message' => 'ID is required'
            ]);
            return;
        }
    
        $input = [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s') 
        ];
    
        $result = Model::getDB()->update('deposit', $input, ['id' => $id]);
    
        if ($result) {
            response()->json([
                'status' => true
            ]);
        } else {
            response()->json([
                'status' => false,
                'error' => Model::getDB()->getLastError()
            ]);
        }
    }

    
}
