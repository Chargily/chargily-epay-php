# How to test your webhook (localy)

1. Fill api key and secret in your webhook by the following values :
* ```api_key``` = ```sandbox_api_key``` 
* ```api_secret``` = ```sandbox_api_secret```

2. Simulate webhook request :
* Via Curl :
```bash
curl --location --request POST 'WEBHOOK_URL' \
--header 'Signature: c1faf84d8856f234561a630f0b98c19e413082292915416d5fb3017c36e31ee1' \
--header 'Content-Type: text/plain' \
--data-raw '{"invoice":{"id":100000,"client":"Test Client","client_email":"testclient@mail.com","invoice_number":"I-123456789","status":"paid","amount":5000,"fee":75,"discount":0,"due_amount":5075,"comment":"Payment for T-Shirt","mode":"CIB","new":1,"tos":1,"back_url":"https:\/\/www.domain.com\/","invoice_token":"random_token_here","api_key_id":null,"meta_data":null,"due_date":"2022-04-27 00:00:00","created_at":"2022-04-27 20:59:07","updated_at":"2022-04-27 21:01:09"}}'
```
* You can import that to POSTMAN

- Replace ```WEBHOOK_URL``` by your webhook url
