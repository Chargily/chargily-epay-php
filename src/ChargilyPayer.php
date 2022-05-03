<?php 

namespace Chargily\ePay;

use Chargily\ePay\Abstracts\Chargily;
use Chargily\ePay\Core\Configuration;
use Chargily\ePay\Core\RedirectUrl;
use Chargily\ePay\Exceptions\InvalidResponseException;
use Chargily\ePay\Validators\RedirectUrlConfigurationsValidator;

final class ChargilyPayer extends Chargily {

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
     * getRedirectUrl
     *
     * @return null|string
     */
    public function getRedirectUrl() : string
    {   
        try {
            $url = $this->cachedRedirectUrl = ($this->cachedRedirectUrl) ? $this->cachedRedirectUrl : (new RedirectUrl($this->configurations))->getRedirectUrl();
        } catch (InvalidResponseException|\RuntimeException $e) {
            if ($this->configurations->from("options")->getDebug()) {
                echo $e->getMessage()."\n";
                exit;
            }
            http_response_code(500);
            exit;
        }
        return $url;
    }

    public function resolveValidator() : string 
    {
        return RedirectUrlConfigurationsValidator::class;
    }

}