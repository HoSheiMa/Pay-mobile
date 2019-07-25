<?php


require __DIR__  . '/vendor/autoload.php';

if (isset($_GET['cost'])) {

    $cost = $_GET['cost'];

} else {
    $cost = '1.0';
}

$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        '',     // ClientID
        ''      // ClientSecret
    )
);



// After Step 2
$payer = new \PayPal\Api\Payer();
$payer->setPaymentMethod('paypal');

$amount = new \PayPal\Api\Amount();
$amount->setTotal($cost);
$amount->setCurrency('USD');

$transaction = new \PayPal\Api\Transaction();
$transaction->setAmount($amount);

$redirectUrls = new \PayPal\Api\RedirectUrls();
$redirectUrls->setReturnUrl("http://localhost/Pay-mobile/success.html")
    ->setCancelUrl("http://localhost/Pay-mobile/cancel.html");

$payment = new \PayPal\Api\Payment();
$payment->setIntent('sale')
    ->setPayer($payer)
    ->setTransactions(array($transaction))
    ->setRedirectUrls($redirectUrls);


    try {
        $payment->create($apiContext);
        // echo $payment;
    
        echo  "<script> window.location.assign('" . $payment->getApprovalLink() . "');</script>\n";
    }
    catch (\PayPal\Exception\PayPalConnectionException $ex) {
        // This will print the detailed information on the exception.
        //REALLY HELPFUL FOR DEBUGGING
        echo $ex->getData();
    }