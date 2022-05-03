<?php 

namespace Chargily\ePay;

use Chargily\ePay\Abstracts\Chargily;
use Chargily\ePay\Core\Configuration;
use Chargily\ePay\Core\WebhookUrl;
use Chargily\ePay\Validators\WebhookUrlConfigurationsValidator;

final class ChargilyProccessor extends Chargily {

    /**
     * configurations
     *
     * @var Configurations
     */
    protected Configuration $configurations;
    /**
     * cachedUrl
     *
     * @var null|string
     */
    protected ?string $cachedRedirectUrl = null;

	/**
     * checkResponse
     *
     * @param  array $params
     * @return void
     */
    public function checkResponse()
    {
        return (new WebhookUrl($this->configurations))->check();
    }
    /**
     * getResponseDetails
     *
     * @return array
     */
    public function getResponseDetails()
    {
        return (new WebhookUrl($this->configurations))->getResponseDetails();
    }

    public function resolveValidator() : string 
    {
        return WebhookUrlConfigurationsValidator::class;
    }

}