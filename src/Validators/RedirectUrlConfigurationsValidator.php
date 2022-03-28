<?php

namespace Chargily\ePay\Validators;

use Chargily\ePay\Exceptions\InvalidConfigurationsException;

class RedirectUrlConfigurationsValidator
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
     * availlable_modes
     *
     * @var array
     */
    protected $availlable_modes = ["CIB", "EDAHABIA"];
    protected $availlable_urls = ["back_url", "webhook_url"];
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
        if (!isset($array['urls']) or !is_array($array['urls']) or empty($array['urls'])) {
            $this->throwException("configurations.urls is required and must be array with two keys (back_url,webhook_url)");
        }
        foreach ($this->availlable_urls as $key) {
            if (!isset($array['urls'][$key]) or !is_string($array['urls'][$key]) or !filter_var($array['urls'][$key], FILTER_VALIDATE_URL)) {
                $this->throwException("configurations.urls.{$key} is required and must be valid url");
            }
        }
        if (!isset($array['mode']) or !is_string($array['mode']) or !in_array($array['mode'], $this->availlable_modes)) {
            $this->throwException("configurations.mode is required and must be string");
        }
        if (!isset($array['payment']) or !is_array($array['payment']) or empty($array['payment'])) {
            $this->throwException("configurations.payment is required and must be array");
        }
        $payment = $array['payment'];
        if (!isset($payment['number']) or !is_string($payment['number']) or empty($payment['number'])) {
            $this->throwException("configurations.payment.number is required and must be string");
        }
        if (!isset($payment['client_name']) or !is_string($payment['client_name']) or empty($payment['client_name'])) {
            $this->throwException("configurations.payment.client_name is required and must be string");
        }
        if (!isset($payment['client_email']) or !is_string($payment['client_email']) or empty($payment['client_email'])) {
            $this->throwException("configurations.payment.client_email is required and must be string and valid email");
        }
        if (!isset($payment['amount']) or !is_numeric($payment['amount'])) {
            $this->throwException("configurations.payment.amount is required and must be numeric");
        }
        if ($payment['amount'] < 75) {
            $this->throwException("configurations.payment.amount must be grather or equal than 75");
        }
        if (!isset($payment['discount']) or !is_numeric($payment['discount']) or $payment['discount'] < 0 or $payment['discount'] > 99.99) {
            $this->throwException("configurations.payment.discount is required and must be numeric and must be between 0 to 99.99");
        }
        if (!isset($payment['description']) or !is_string($payment['description'])) {
            $this->throwException("configurations.payment.description is required and must be string");
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
