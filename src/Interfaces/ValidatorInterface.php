<?php 

namespace Chargily\ePay\Interfaces;

interface ValidatorInterface {
	public function validate() : array;
}