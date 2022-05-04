<?php

namespace Chargily\ePay\Core;

use Chargily\ePay\Core\Configuration;

class WebhookUrl
{
    /**
     * method
     *
     * @var string
     */
    protected $method = 'POST';
    /**
     * configurations
     *
     * @var \Chargily\ePay\Core\Configuration
     */
    protected $configurations;
    /**
     * cachedHeaders
     *
     * @var null|array
     */
    protected $cachedHeaders = null;
    /**
     * cachedContent
     *
     * @var null|string
     */
    protected $cachedContent = null;

    /**
     * __construct
     *
     * @param  Configurations $configurations
     * @return void
     */
    public function __construct(Configuration $configurations)
    {
        $this->configurations = $configurations;
        $configurations->validateWebhookConfigurations();
    }
    /**
     * checkResponse
     *
     * @return bool
     */
    public function check(): bool
    {
        $computedSignature = hash_hmac('sha256', $this->getContent(), $this->configurations->getApiSecret());

        return hash_equals($computedSignature, $this->getSignature());
    }
    /**
     * getInvoiceDetails
     *
     * @return array
     */
    public function getResponseDetails(): array
    {
        return $this->getContentToArray() ?? [];
    }

    /**
     * getSignature
     *
     * @return string
     */
    protected function getSignature(): string
    {
        if (isset($this->getHeaders()['signature'])) {
            return $this->getHeaders()['signature'];
        } elseif (isset($this->getHeaders()['Signature'])) {
            return $this->getHeaders()['Signature'];
        }
        return "";
    }
    /**
     * getContent
     *
     * @return null|string
     */
    protected function getContent(): ?string
    {
        return $this->cachedContent = ($this->cachedContent) ? $this->cachedContent : file_get_contents("php://input");
    }
    /**
     * getContentToArray
     *
     * @return array
     */
    protected function getContentToArray(): array
    {
        return json_decode($this->getContent(), true) ?? [];
    }
    /**
     * getHeaders
     *
     * @return array
     */
    protected function getHeaders(): array
    {
        return $this->cachedHeaders = ($this->cachedHeaders) ? $this->cachedHeaders : getallheaders();
    }
}
