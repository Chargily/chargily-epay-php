<?php 

use Chargily\ePay\Chargily;
use Chargily\ePay\ChargilyPayer;

require "vendor/autoload.php";

$chargily = new ChargilyPayer([
    "options" => [
       "headers"   =>  [],
        "timeout"   =>  30,
        "debug"     =>  true
    ],
    //credentials
    'api_key' => "api_Ln7h4rvo09PAxal9JUl7OBRfQpplJDPQzefMoSQCR7EbkXXys54txCjOxfWK2haWxxx",
    'api_secret' => "secret_457a757dafaee4c9bab53f56bec5d63ebadfaeab46359cb42e1336b7e86ca825xxx",
    //urls
    'urls' => [
        'back_url' => "https://github.com/", // this is where client redirected after payment processing
        'webhook_url' => "https://github.com/", // this is where you receive payment informations
    ],
    //mode
    'mode' => 'EDAHABIA', //OR CIB
    //payment details
    'payment' => [
        'number' => 'payment-number-from-your-side', // Payment or order number
        'client_name' => 'client name', // Client name
        'client_email' => 'client_email@mail.com', // This is where client receive payment receipt after confirmation
        'amount' => 75, //this the amount must be greater than or equal 75 
        'discount' => 0, //this is discount percentage between 0 and 99
        'description' => 'payment-description', // this is the payment description
    ]
]);
$redirectUrl = $chargily->getRedirectUrl();
var_dump($redirectUrl);