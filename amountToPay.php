<?php
$amount = htmlspecialchars(isset($_GET["amountToPay"]) ? $_GET["amountToPay"] : '(Amout to Pay)');
echo $amount . " USD.";

$payee = htmlspecialchars(isset($_GET["payeeName"]) ? $_GET["payeeName"] : '(Donor)');
echo "Hello ". $payee . " if you are using a computer, please use your phone to scan the QR code on the right to launch Zelle and make your payment.";
