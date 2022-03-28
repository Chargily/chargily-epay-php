<?php

namespace Chargily\ePay\Core;

use GuzzleHttp\Client;
use Chargily\ePay\Exceptions\InvalidResponseException;

class RedirectUrl
{
    /**
     * create payment api url
     *
     * @var string
     */
    protected $api_url = 'http://epay.chargily.com.dz/api/invoice';
    /**
     * method
     *
     * @var string
     */
    protected $method = 'POST';
    /**
     * configurations
     *
     * @var \Chargily\ePay\Core\Configurations
     */
    protected Configurations $configurations;
    /**
     * cachedResponse
     *
     * @var object
     */
    protected $cachedResponse = null;

    /**
     * __construct
     *
     * @param  Chargily\ePay\Core\Configurations $configurations
     * @return void
     */
    public function __construct(Configurations $configurations)
    {
        $this->configurations = $configurations;
    }

    /**
     * send
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        $this->validateResponse();
        //get response
        $response = $this->getResponse();
        //get response content
        $content = $response->getBody()->getContents();
        //convert json to php array
        $content_to_array = json_decode($content, true);
        //
        return $content_to_array['checkout_url'];
    }
    /**
     * getResponse
     *
     * @return Request
     */
    protected function getResponse()
    {
        return $this->cachedResponse = ($this->cachedResponse) ? $this->cachedResponse : (new Client())->request($this->method, $this->api_url, $this->buildRequest());
    }
    /**
     * validateResponse
     *
     * @return void
     */
    protected function validateResponse()
    {

        $response = $this->getResponse();

        if (!in_array($response->getStatusCode(), ['201'])) {
            throw new InvalidResponseException("Invalid response status code ({$response->getStatusCode()}) when trying to get redirect url . More info (" . $response->getBody()->getContents() . ')');
        }
    }
    /**
     * buildRequest
     *
     * @return array
     */
    protected function buildRequest()
    {
        $headers = array_merge(['Accept' => 'application/json', 'X-Authorization' => $this->configurations->getApikey()], $this->configurations->getOptionsHeaders());
        return [
            'allow_redirects' => false,
            'http_errors' => false,
            'timeout' => $this->configurations->getOptionsTimeout(),
            'headers' => $headers,
            'form_params' => [
                'client' => $this->configurations->getPaymentClientName(),
                'client_email' => $this->configurations->getPaymentClientEmail(),
                'invoice_number' => $this->configurations->getPaymentNumber(),
                'amount' => $this->configurations->getPaymentAmount(),
                'discount' => $this->configurations->getPaymentDiscount(),
                'back_url' => $this->configurations->getBackUrl(),
                'webhook_url' => $this->configurations->getWebhookUrl(),
                'mode' => $this->configurations->getMode(),
                'comment' => $this->configurations->getPaymentDescription(),
            ]
        ];
    }
}
