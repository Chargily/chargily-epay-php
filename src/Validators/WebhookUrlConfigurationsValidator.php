<?php

namespace Chargily\ePay\Validators;

use Chargily\ePay\Exceptions\InvalidConfigurationsException;
use Chargily\ePay\Exceptions\ValidationException;
use Rakit\Validation\Validator;

class WebhookUrlConfigurationsValidator
{
    /**
     * configurations
     *
     * @var mixed
     */
    protected $configurations;
    /**
     * debug
     *
     * @var bool
     */
    protected $debug;
    /**
     * __construct
     *
     * @param  array $configurations
     * @return void
     */
    public function __construct(array $configurations, bool $debug = true)
    {
        $this->configurations = $configurations;
        $this->debug = $debug;
    }
    /**
     * validate
     *
     * @param  array $array
     * @return true
     */
    public function validate() : array
    {
        $configurations = $this->configurations;
        $validator = new Validator;
        $validation = $validator->make($configurations, [
            "api_key"               =>      "required",
            "api_secret"            =>      "required"
        ]);
        $validation->validate();
        if ($validation->fails()) {
            throw new ValidationException($validation->errors());
        }
        return $configurations;
    }
    /**
     * throwException
     *
     * @param  string $message
     * @param  int $code
     * @return void
     */
    protected function throwException(string $message, int $code = 0)
    {
        if ($this->debug) {
            throw new InvalidConfigurationsException($message, $code);
        } else {
            return http_response_code(500);
        }
    }
}
