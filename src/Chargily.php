<?php

namespace Chargily\ePay;

use Chargily\ePay\Core\Configurations;
use Chargily\ePay\Core\RedirectUrl;
use Chargily\ePay\Core\WebhookUrl;

class Chargily
{
    /**
     * configurations
     *
     * @var Configurations
     */
    protected $configurations;
    /**
     * cachedUrl
     *
     * @var null|string
     */
    protected $cachedRedirectUrl = null;
    /**
     * __construct
     *
     * @param  array|Configurations $configurations
     * @return void
     */
    public function __construct($configurations)
    {
        if ($configurations instanceof Configurations) {
            $this->configurations = $configurations;
        } elseif (is_array($configurations)) {
            $this->configurations = new Configurations($configurations);
        } else {
            throw new \Exception(static::class . "::__construct(\$configurations) . \$configurations argument must be instance of " . Configurations::class . " or an array", 1);
        }
    }
    /**
     * getRedirectUrl
     *
     * @return null|string
     */
    public function getRedirectUrl()
    {
        $this->configurations->validateRedirectConfigurations();
        //
        return $this->cachedRedirectUrl = ($this->cachedRedirectUrl) ? $this->cachedRedirectUrl : (new RedirectUrl($this->configurations))->getRedirectUrl();
    }
    /**
     * checkResponse
     *
     * @param  array $params
     * @return void
     */
    public function checkResponse()
    {
        $this->configurations->validateWebhookConfigurations();

        return (new WebhookUrl($this->configurations))->check();
    }
    /**
     * getResponseDetails
     *
     * @return array
     */
    public function getResponseDetails()
    {
        $this->configurations->validateWebhookConfigurations();

        return (new WebhookUrl($this->configurations))->getResponseDetails();
    }
}
