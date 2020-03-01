<?php
include_once 'vendor/autoload.php';
include_once 'config.php';
include_once 'db.php';
if (isset($_POST)) {
    try {
        $type = $_POST['type'];
        $amount = $_POST['amount'];
        $currency = isset($_POST['currency']) ? $_POST['currency'] : $_POST['currency1'];
        if ($_POST['type'] == 'paypal') {
            $transactionId = $_POST['transaction_id'];
        } else if ($_POST['type'] == 'stripe') {
            \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
            $charge = \Stripe\Charge::create([
                'amount' => $amount * 100,
                'currency' => $currency,
                'source' => $_POST['token']
            ]);
            if ($charge->status == 'succeeded') {
                $transactionId = $charge->balance_transaction;
            }
        } else if ($_POST['type'] == 'coin') {
            $currency2 = $_POST['currency2'];
            $buyer_email = $_POST['email'];       
            $buyer_name = $_POST['name'];     
            $cps_api = new CoinpaymentsAPI(COIN_PRIVATE_KEY, COIN_PUBLIC_KEY, 'json');
            $transaction_response = $cps_api->CreateComplexTransaction($amount, $currency, $currency2, $buyer_email, $address = '', $buyer_name = 'Fake', $item_name = '', $item_number = '', $invoice = 'JB-2019-1', $custom = 'Express Order', $ipn_url = BASE_URL . '/success.php');
            if ($transaction_response['error'] == "ok") {
                $transactionId = $transaction_response['result']['txn_id'];
                $sql = "INSERT INTO transactions (transaction_id, transaction_type, transaction_amount, currency) VALUES ('$transactionId', '$type', $amount, '$currency')";
                $result = $db->query($sql);
                include_once 'coin_success.php';
            } else {
                header("Location: " . BASE_URL . "/index.php");
            }
            exit;
        }
        $sql = "INSERT INTO transactions (transaction_id, transaction_type, transaction_amount, currency) VALUES ('$transactionId', '$type', $amount, '$currency')";
        $result = $db->query($sql);
        header('Content-Type:application/json');
        echo json_encode($result);
    } catch (Exception $e) {
        header('Content-Type:application/json');
        echo json_encode(array("error" => $e->getMessage()));
    }
}