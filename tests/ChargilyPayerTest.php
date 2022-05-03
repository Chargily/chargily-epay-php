<?php 

use Chargily\ePay\ChargilyPayer;
use Chargily\ePay\Core\Configuration;
use Chargily\ePay\Core\RedirectUrl;
use Chargily\ePay\Exceptions\InvalidResponseException;
use Chargily\ePay\Exceptions\ValidationException;
use Chargily\ePay\Validators\RedirectUrlConfigurationsValidator;
use PHPUnit\Framework\TestCase;

class ChargilyPayerTest extends TestCase {

	public function testExcpetionThrownWhenNotValidConfigurations() {
		$this->expectException(ValidationException::class);
		$configurations = new Configuration([]);
		$configurations->validateConfiguration(RedirectUrlConfigurationsValidator::class);
	}

	public function testInvalidTokenWillThrowException() {
		$this->expectException(InvalidResponseException::class);
		$redirectUrl = new RedirectUrl(new Configuration([
			"options" => [
				"headers"   =>  [],
				"timeout"   =>  30,
				"debug"     =>  true
			],
			'api_key' => "123",
			'api_secret' => "123",
			'urls' => [
		        'back_url' => "https://github.com/",
		        'webhook_url' => "https://github.com/",
		    ],
		    'mode' => 'EDAHABIA',
		    'payment' => [
		        'number' => 'payment-number-from-your-side', // Payment or order number
		        'client_name' => 'client name', // Client name
		        'client_email' => 'client_email@mail.com', // This is where client receive payment receipt after confirmation
		        'amount' => 75, //this the amount must be greater than or equal 75 
		        'discount' => 0, //this is discount percentage between 0 and 99
		        'description' => 'payment-description', // this is the payment description
		    ]
			])
		);
		$redirectUrl->getRedirectUrl();
	}

}