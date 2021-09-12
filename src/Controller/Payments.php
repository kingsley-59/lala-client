<?php

namespace Src\Controller;

use Src\Gateway\OrderGateway;

class Payments
{

    private $db;
    private $secret_key;
    private $public_key;
    private $orderGateway;

    public function __construct($db)
    {
        $url = "https://api.paystack.co/transaction/initialize";
        $secret_key = $_ENV['test_secret_key'];
        $public_key = $_ENV['test_public_key'];

        $this->url = $url;
        $this->secret_key = $secret_key;
        $this->public_key = $public_key;

        $this->orderGateway = new OrderGateway($db, "orders");
        
    }

    public function pay($data)
    {
        //$data = $this->data;
        $name = $data->personal_info->name;
        $email = $data->personal_info->email;
        $total_amt = (int) $data->total_amount;
        $total_amt = $total_amt * 100;
        $callback_url = 'https://www.google.com';
        $txn_ref = $this->getTxnReference();
        $txn_fields = array();

        $txn_fields['name'] = $name ?? null;
        $txn_fields['email'] = $email ?? null;  //required
        $txn_fields['amount'] = $total_amt ?? null;  //required
        $txn_fields['callback_url'] = $callback_url;
        $txn_fields['currency'] = 'NGN';  //optional
        $txn_fields['reference'] = $txn_ref;
        $txn_fields['metadata'] = array('custom_fields' => [
            [
                'display_name' => "Name",
                'variable_name' => "name",
                'value' => $name ?? null
            ],
            [
                'display_name' => "Transaction Id",
                'variable_name' => "txn_id",
                'value' => $txn_ref ?? null
            ]
            // [
            //     'display_name' => "Order",
            //     'variable_name' => "order",
            //     'value' => $_POST['order'] ?? null
            // ]

        ]);  //optional

        $fields_string = http_build_query($txn_fields);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $this->secret_key",
            "Cache-Control: no-cache"
        ));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $err = curl_error($ch);

        if (!$response) {
            echo 'Unable to contact payment provider. Please check your network and try again!';
        }
        $result = json_decode($response);
        header('location: ' . $result->data->authorization_url);
    }

    public function verify_transaction($email,$reference)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . $this->secret_key,
                "Cache-Control: no-cache",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        }

        if(!$response){
            echo "Unable to verify transaction. Please try again later";
            // sendmailtoverify();
            die();
        }

        $result = json_decode($response);
        $status = $result->status;
        $status_msg = $result->data->status;
        if(!$status){
            echo "Error 400 Invalid: Please contact our customer care!";
            die();
        }

        if($status_msg == "success"){
            $param = 'txn_verified';
            $value = true;
            $result = $this->orderGateway->update($email, $param, $value);
            if($result == '1'){
                echo "success";
                // sendconfirmationemail();
            }else{
                echo "Verification successful but not saved in database!";
            }
            
        }else{
            echo "Verification failed!";
            // sendmailtoverify();
        }
    }

    public function save_order($data){
        $input = array();
        if ($data->delivery_info != "Store pickup"){
            $home_delivery = true;
        }else{
            $home_delivery = false;
        }
        $input['email'] = $data->personal_info->email;
        $input['name'] = $data->personal_info->name;
        $input['gender'] = $data->personal_info->gender;
        $input['phone'] = $data->personal_info->phone;
        $input['order_details'] = implode(", ", $data->cart_info);    // text
        $input['total_amount'] = $data->total_amount;
        $input['home_delivery'] = $home_delivery;   // bool
        $input['txn_id'] = $data->reference;
        $input['delivery_details'] = $data->delivery_info;    // text

        $result = $this->orderGateway->insert($input);
        return $result;
    }

    public function getTxnReference()
    {
        mt_srand((float)microtime() * 10000);
        $charid = md5(uniqid(rand(), true));
        $c = unpack("C*", $charid);
        $c = implode("", $c);

        return substr($c, 0, 20);
    }
}
