<?php 
namespace Chargily\ePay\Exceptions;

use Rakit\Validation\ErrorBag;

class ValidationException extends \Exception {
	 public function __construct(ErrorBag $errors, $code = 0, Throwable $previous = null) {
	 	$this->message = implode(", ", $errors->all());
	}
}