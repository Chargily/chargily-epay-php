# Chargily ePay Gateway PHP

![Chargily ePay Gateway](https://raw.githubusercontent.com/Chargily/epay-gateway-php/main/assets/banner-1544x500.png "Chargily ePay Gateway")

Integrate ePayment gateway with Chargily easily.
- Currently support payment by **CIB / EDAHABIA** cards and soon by **Visa / Mastercard** 
- This is a **PHP package**, If you are using another programing language [Browse here](https://github.com/Chargily/) or look to [API documentation](https://github.com/Chargily/epay-gateway-php/blob/master/README_API.md)

# Requirements
1. PHP 7.2.5 or later. 
2. Get your API Key/Secret from [ePay by Chargily](https://epay.chargily.com) dashboard for free.

# Installation
1. Via Composer (Recomended)
```bash
composer require chargily-epay-gateway
```
2. Download as ZIP
We do not recommend this option. But be careful to download the updated versions every a while [Download](https://github.com/Chargily/epay-gateway-php/releases/)
# Quick start

1. create config file **epay_config.php**
This is where store your api credentials

```php
//  Configurations file
return [
    'key' => 'your-api-key', // you can you found it on your epay.chargily.com.dz Dashboard
    'secret' => 'your-api-secret', // you can you found it on your epay.chargily.com.dz Dashboard
];
```
2. create payment redirection file **redirect.php**

```php
use Chargily\ePay\Chargily;

require 'path-to-vendor/vendor/autoload.php';

$epay_config = require 'epay_config.php';

$chargily = new Chargily([
    //credentials
    'api_key' => $epay_config['key'],
    'api_secret' => $epay_config['secret'],
    //urls
    'urls' => [
        'back_url' => "valid-url-to-redirect-after-payment", // this is where client redirected after payment processing
        'webhook_url' => "valid-url-to-receive-payment-informations", // this is where you receive payment informations
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
// get redirect url
$redirectUrl = $chargily->getRedirectUrl();
//like : https://epay.chargily.com.dz/checkout/random_token_here
//
if($redirectUrl){
    //redirect
    header('Location: '.$redirectUrl);
}else{
    echo "We cant redirect to your payment now";
}
```
3. create payment processing file **process.php**

```php

use Chargily\ePay\Chargily;

require 'path-to-vendor/vendor/autoload.php';

$epay_config = require 'epay_config.php';

$chargily = new Chargily([
    //credentials
    'api_key' => $epay_config['key'],
    'api_secret' => $epay_config['secret'],
]);

if ($chargily->checkResponse()) {
    $response = $chargily->getResponseDetails();
    //@ToDo: Validate order status by $response['invoice']['invoice_number']. If it is not already approved, approve it.
    //something else
    /*
        $response like the follwing array
            $response = array(
                "invoice" => array(
                            "id" => 5566321,
                            "client" => "Client name",
                            "invoice_number" => "123456789",
                            "due_date" => "2022-01-01 00:00:00",
                            "status" => "paid",
                            "amount" => 75,
                            "fee" => 25,
                            "discount" => 0,
                            "comment" => "Payment description",
                            "tos" => 1,
                            "mode" => "EDAHABIA",
                            "invoice_token" => "randoom_token_here",
                            "due_amount" => 10000,
                            "created_at" => "2022-01-01 06:10:38",
                            "updated_at" => "2022-01-01 06:13:00",
                            "back_url" => "https://www.mydomain.com/success",
                            "new" => 1,
                );
            )
    */
    exit('OK');
}

```
- Guide for testing your webhook (process) url [Click Here](https://github.com/Chargily/epay-gateway-php/blob/main/README_WEBHOOK.md)

# Configurations

- Available Configurations

| key                   |  description                                                                                          | redirect url |  process url |
|-----------------------|-------------------------------------------------------------------------------------------------------|--------------|--------------|
| api_key               | must be string given by organization                                                                  |   required   |   required   |
| api_secret            | must be string given by organization                                                                  |   required   |   required   |
| urls                  | must be array                                                                                         |   required   | not required |
| urls[back_url]        | must be string and valid url                                                                          |   required   | not required |
| urls[process_url]     | must be string and valid url                                                                          |   required   | not required |
| mode                  | must be in **CIB**,**EDAHABIA**                                                                       |   required   | not required |
| payment[number]       | must be string or int                                                                                 |   required   | not required |
| payment[client_name]  | must be string                                                                                        |   required   | not required |
| payment[client_email] | must be string and valid email This is where client receive payment receipt after confirmation        |   required   | not required |
| payment[amount]       | must be numeric and greather or equal than  75                                                        |   required   | not required |
| payment[discount]     | must be numeric and between 0 and 99.99  (discount percentage)                                     |   required   | not required |
| payment[description]  | must be string                                                                                        |   required   | not required |
| options               | must be array                                                                                         |   required   | not required |
| options[headers]      | must be array                                                                                         |   required   | not required |
| options[timeout]      | must be numeric                                                                                       |   required   | not required |

# Notice
- If you faced Issues [Click here to open one](https://github.com/Chargily/epay-gateway-php/issues/new)
