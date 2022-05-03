<?php 
use Chargily\ePay\Core\Configuration;
use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase {

	public function testGetConfigFromDynamicResolver() {
		$config = new Configuration([
			"foo" => "foo", 
			"bar" => "bar", 
			"foobar" => [
				"foo" => "foo",
				"bar" => "bar",
				"barfoo" => [
					"foo" => "bar",
					"barbar" => [
						"bar" => "x",
						"finalDepthValue" => [
							"value" => "Hello world"
						],
						"finalDepthArray" => [
							"array" => [
								"data" => "foo"
							]
						]
					]
				]
			]
		]);
		$this->assertEquals($config->getBar(), "bar");
		$this->assertEquals($config->getFoo(), "foo");
		$this->assertEquals($config->from("foobar")->getFoo(), "foo");
		$this->assertEquals($config->from("foobar.barfoo")->getFoo(), "bar");
		$this->assertEquals($config->from("foobar.barfoo.barbar")->getBar(), "x");
		$this->assertEquals($config->from("foobar.barfoo.barbar.finalDepthValue")->getValue(), "Hello world");
		$this->assertEquals($config->from("foobar.barfoo.barbar.finalDepthArray")->getArray(), ["data" => "foo"]);
	}

	public function testThatNotFoundConfigurationWillThrowException() {
		$config = new Configuration(["foo" => "bar"]);
		$this->expectException(\Exception::class);
		$this->assertEquals($config->getBar(), "bar");
		$this->assertEquals($config->getBar("foo.bar"), "bar");
		$this->assertEquals($config->getBar("bar"), "bar");
	}

}