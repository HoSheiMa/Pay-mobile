<?php


require __DIR__  . '/vendor/autoload.php';

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        '',     // ClientID
        ''      // ClientSecret
    )
);


$paymentid = $_GET['paymentId'];

$PayerID = $_GET['PayerID'];



$payment = Payment::get($paymentid, $apiContext);


$exs = new PaymentExecution();

$exs->setPayerId($PayerID);


try {
    $r = $payment->execute($exs, $apiContext);
}catch (Exception $e) {
    echo "error";

}


echo "Done =!";
