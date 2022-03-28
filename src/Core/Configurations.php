<?php

namespace Chargily\ePay\Core;

use Chargily\ePay\Validators\RedirectUrlConfigurationsValidator;
use Chargily\ePay\Validators\WebhookUrlConfigurationsValidator;

class Configurations
{
    /**
     * configurations
     *
     * @var array
     */
    protected $configurations = [];
    /**
     * __construct
     *
     * @param  array $array
     * @return void
     */
    public function __construct(array $array)
    {
        $this->configurations = $array;
    }
    /**
     * getApikey
     *
     * @return string
     */
    public function getApikey()
    {
        return $this->configurations["api_key"];
    }
    /**
     * getApiSecret
     *
     * @return string
     */
    public function getApiSecret()
    {
        return $this->configurations["api_secret"];
    }
    /**
     * getUrls
     *
     * @return array
     */
    public function getUrls()
    {
        return $this->configurations["urls"]  ?? [];
    }
    /**
     * getBackUrl
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->configurations["urls"]['back_url']  ?? null;
    }
    /**
     * geWebhookUrl
     *
     * @return string
     */
    public function getWebhookUrl()
    {
        return $this->configurations["urls"]['webhook_url']  ?? null;
    }
    /**
     * getMode
     *
     * @return string
     */
    public function getMode()
    {
        return $this->configurations["mode"]  ?? null;
    }
    /**
     * getPaymentDetails
     *
     * @return array
     */
    public function getPaymentDetails()
    {
        return $this->configurations["payment"]  ?? [];
    }
    /**
     * getPaymentNumber
     *
     * @return string
     */
    public function getPaymentNumber()
    {
        return $this->configurations["payment"]["number"]  ?? null;
    }
    /**
     * getPaymentClientName
     *
     * @return string
     */
    public function getPaymentClientName()
    {
        return $this->configurations["payment"]["client_name"]  ?? null;
    }
    /**
     * getPaymentClientEmail
     *
     * @return string
     */
    public function getPaymentClientEmail()
    {
        return $this->configurations["payment"]["client_email"]  ?? null;
    }
    /**
     * getPaymentAmount
     *
     * @return int|integer|float
     */
    public function getPaymentAmount()
    {
        return $this->configurations["payment"]["amount"]  ?? null;
    }
    /**
     * getPaymentDiscount
     *
     * @return float|int|integer
     */
    public function getPaymentDiscount()
    {
        return $this->configurations["payment"]["discount"]  ?? null;
    }
    /**
     * getPaymentDescription
     *
     * @return string
     */
    public function getPaymentDescription()
    {
        return $this->configurations["payment"]["description"] ?? null;
    }
    /**
     * getOptions
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->configurations["options"] ?? [];
    }
    /**
     * getOptionsHeaders
     *
     * @return array
     */
    public function getOptionsHeaders()
    {
        return $this->configurations["options"]['headers'] ?? [];
    }
    /**
     * getOptions
     *
     * @return int|integer|float
     */
    public function getOptionsTimeout()
    {
        return $this->configurations["options"]['timeout'] ?? 20;
    }
    /**
     * validateAndGetConfigurations
     *
     * @param  array $array
     * @return void|array
     */
    public function validateWebhookConfigurations()
    {
        return (new WebhookUrlConfigurationsValidator($this->configurations, true))->validate();
    }
    /**
     * validateAndGetConfigurations
     *
     * @param  array $array
     * @return void|array
     */
    public function validateRedirectConfigurations()
    {
        return (new RedirectUrlConfigurationsValidator($this->configurations, true))->validate();
    }
}
