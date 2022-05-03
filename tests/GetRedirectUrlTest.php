<?php 
use Chargily\ePay\Chargily;
use Chargily\ePay\Core\Configuration;
use Chargily\ePay\Core\RedirectUrl;
use Chargily\ePay\Exceptions\ValidationException;
use PHPUnit\Framework\TestCase;

class GetRedirectUrlTest extends TestCase {

	public function testWrongConfigWillThrowError() {
		$this->expectException(ValidationException::class);
		new Chargily($this->getFakeWrongConfiguration());
	}

	public function testGetUrl() {
		$mockedRedirectUrl = $this->getMockBuilder(RedirectUrl::class)->setMethods(["getRedirectUrl"])->setConstructorArgs([new Configuration($this->getFakeConfiguration())])->getMock();

		$mockedRedirectUrl->expects($this->any())->method("getRedirectUrl")->willReturn("https://epay.chargily.com.dz/checkout/9e679d420a94fdaaf5b8fa322d4996f3a511a36d194b3cf295beff337a23f4bc");

		$mockedChargily = $this->getMockBuilder(Chargily::class)->setMethods(["getRedirectUrl"])->setConstructorArgs([$this->getFakeConfiguration()])->getMock();
		$mockedChargily->expects($this->any())->method("getRedirectUrl")->will($this->returnValue($mockedRedirectUrl->getRedirectUrl("https://epay.chargily.com.dz/checkout/9e679d420a94fdaaf5b8fa322d4996f3a511a36d194b3cf295beff337a23f4bc")));

		$this->assertEquals($mockedChargily->getRedirectUrl(), "https://epay.chargily.com.dz/checkout/9e679d420a94fdaaf5b8fa322d4996f3a511a36d194b3cf295beff337a23f4bc");
	}

	public function getFakeConfiguration() {
		return [
			'api_key' => "fake-key",
		    'api_secret' => "fake-secret",
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
		];
	}

	public function getFakeWrongConfiguration() {
		return [
			// without config
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
		];
	}

}