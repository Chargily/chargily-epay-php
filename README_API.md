# Chargily ePay Gateway

Chargily ePay Gateway API

# Documentation

### 1. Make payment

- Request method ```POST``` url ```http://epay.chargily.com.dz/api/invoice```

- Request Headers :
        ```X-Authorization : API_KEY``` , ```Accept : application/json```

- Request Parameters :

| name                          |  description                                                                                          | Validation                                |
|-------------------------------|-------------------------------------------------------------------------------------------------------|-------------------------------------------|
|  ```client ```                | Your client name                                                                                      |   required ; string ; min:3               |
|  ```client_email ```          | Your client email                                                                                     |   required ; email                        |
|  ```invoice_number ```        | Order number will be used to check payment response                                                   |   required ;                              |
|  ```amount ```                | Order total amount must be greater than or equal 75                                                   |   required ; numeric ; min:75             |
|  ```discount ```              | Discount percentage                                                                                   |   required ; numeric ; min:0 ; max:99.99  |
|  ```back_url ```              | This url you will be redirected to after the payment is done, and must be active URL                  |   required ; string  ; url                |
|  ```webhook_url```            | This is the source url wich you will get information of payment responce                              |   required ; string  ; url                |
|  ```mode ```                  | This is the payment method "EDAHABIA" or "CIB"                                                        |   required ; in:EDAHABIA / CIB            |
|  ```comment ```               | Description for the payment raison                                                                    |   required ; string                       |

- Responses :

    -   201 : payment created successffully

            Response as 'json' : 'checkout_url'

            Example: {"checkout_url"=>"https://epay.chargily.com.dz/checkout/random_token_here"}

    -   401 : Unauthorized

            Invalid API_KEY

    -   422 : invalid parametters

            The request was well-formed but was unable to be followed due to semantic errors

> if the creation of invoice successed make redirection to checkout_url

### 2. Payment confirmation

We will send you operation responce via already sent "webhook_url".

- Method ```POST```

- Headers :

        Signature

- Body :

        invoice with payment status

- Signature Validation :

        Incoming webhook request has a header that can be used to verify the payload
        The name of the header containing the signature can be configured in the 'Signature' header key to validate signatures

- This is an example how you will compute the signature in PHP

```php
    //Secret key can be found in your profile information
    $secret = "API_SECRET";
    //get incoming webhook request body content
    $body_content = file_get_contents("php://input");
    //
    $computed_signature = hash_hmac('sha256', $body_content,$secret);
    //get signature from header
    $signature = getallheaders()["Signature"];
    //check computed signature
    $validated =  hash_equals($computed_signature, $signature);// : bool

    if($validated){
        $payment = json_decode($body_content,true);
        //@Todo: check invoice status first ($payment["invoice"]["status"] === 'paid')
        if($payment["invoice"]["status"] === 'paid'){
            //@Todo: confirm order
        }elseif($payment["invoice"]["status"] === 'paid'){
            //@Todo: do anything when payment failed
        }
    }
    exit;
```

