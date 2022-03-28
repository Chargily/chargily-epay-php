<?php

namespace Chargily\ePay\Validators;

use Chargily\ePay\Exceptions\InvalidConfigurationsException;

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
    public function validate()
    {
        $array = $this->configurations;
        //
        if (!isset($array['api_key']) or !is_string($array['api_key'])) {
            $this->throwException("configurations.api_key is required and must be string");
        }
        if (!isset($array['api_secret']) or !is_string($array['api_secret'])) {
            $this->throwException("configurations.api_secret is required and must be string");
        }
        return $array;
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
