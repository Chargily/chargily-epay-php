<?php

namespace Chargily\ePay\Validators;

use Chargily\ePay\Exceptions\InvalidConfigurationsException;
use Chargily\ePay\Exceptions\ValidationException;
use Chargily\ePay\Interfaces\ValidatorInterface;
use Rakit\Validation\Validator;

class RedirectUrlConfigurationsValidator implements ValidatorInterface
{
    /**
     * configurations
     *
     * @var mixed
     */
    protected mixed $configurations;
    /**
     * availlable_modes
     *
     * @var array
     */
    protected array $availlable_modes = ["CIB", "EDAHABIA"];
    protected array $availlable_urls = ["back_url", "webhook_url"];
    /**
     * __construct
     *
     * @param  array $configurations
     * @return void
     */
    public function __construct(array $configurations)
    {
        $this->configurations = $configurations;
    }
    /**
     * validate
     *
     * @param  array $configurations
     * @return true
     */
    public function validate() : array
    {
        $configurations = $this->configurations;
        $validator = new Validator;
        $validation = $validator->make($configurations, [
            "api_key"               =>      "required",
            "api_secret"            =>      "required",
            "urls.*"                =>      "required|url",
            "mode"                  =>      "required|in:".implode(",", $this->availlable_modes),
            "payment"               =>      "required|array",
            "payment.number"        =>      "required",
            "payment.client_name"   =>      "required",
            "payment.client_email"  =>      "required|email",
            "payment.amount"        =>      "required|numeric|min:75",
            "payment.discount"      =>      "numeric|max:99.99",
            "payment.description"   =>      "required"
        ]);
        $validation->validate();
        if ($validation->fails()) {
            throw new ValidationException($validation->errors());
        }
        return $configurations;
    }
}
