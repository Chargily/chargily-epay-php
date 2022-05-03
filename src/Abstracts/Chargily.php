<?php

namespace Chargily\ePay\Abstracts;

use Chargily\ePay\ChargilyPayer;
use Chargily\ePay\ChargilyProccessor;
use Chargily\ePay\Core\Configuration;
use Chargily\ePay\Core\RedirectUrl;
use Chargily\ePay\Core\WebhookUrl;
use Chargily\ePay\Exceptions\ValidationException;

abstract class Chargily
{
    /**
     * __construct
     *
     * @param  array|Configurations $configurations
     * @return void
     */
    public function __construct(array|Configuration $configurations, public bool $debug = true)
    {
        $this->configurations = new Configuration($configurations);

        if (! is_a($this, ChargilyPayer::class) AND ! is_a($this, ChargilyProccessor::class)) {
            throw new \Exception("Class undefined", 1);
        }

        try {
            $this->configurations->validateConfiguration($this->resolveValidator());
        } catch (ValidationException $e) {
            if ($this->configurations->from("options")->getDebug() === true) {
                echo 'Caught exception: ',  $e->getMessage(), " please verify your configurations array. \n";
                exit;
            }
            http_response_code(500);
            exit;
        }
        
    }

    abstract public function resolveValidator() : string;
}
