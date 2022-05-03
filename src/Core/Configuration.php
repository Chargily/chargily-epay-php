<?php

namespace Chargily\ePay\Core;

use Chargily\ePay\Validators\RedirectUrlConfigurationsValidator;
use Chargily\ePay\Validators\WebhookUrlConfigurationsValidator;
use Illuminate\Support\Str;

class Configuration
{
    /**
     * @var array configurations
     * Store initial configuration array
     */
    protected $configurations = [];

    /**
     * @var array configPrefix
     * store the prefix of desired configuration , example: get from payment client email , the prefix is payment
     */
    public array $configPrefixs = [];

    /**
     * @param array configurations
     */
    public function __construct(array $configurations)
    {
        if (! array_key_exists("options", $configurations)) {
            $configurations["options"] = $this->defualtConfiguration(); 
        }
        $this->configurations = $configurations;
    }

    /**
     * @return mixed
     * This method is responsible for dynamic get configurations.
     * @throws \Exception
     */
    public function __call($name, $arguments) : mixed 
    {
        $name = Str::after($name, "get");
        if (is_null($name)) {
            throw new \Exception("Undefined getter");
        }
        $method = Str::snake($name, "_");
        if (! empty($this->configPrefixs)) {
            $value =  $this->resolveConfigurationsWithPrefix($this->configPrefixs, $method);
        }else {
            if (! array_key_exists($method, $this->configurations)) {
                throw new \Exception("Undefined configuration ".$method);
            }
            $value = $this->configurations[$method];
        }
        $this->configPrefixs = [];
        return $value;
    }

    /**
     * @method from
     * @param string key
     * Set the desired prefix
     * @return Configuration
     */
    public function from(string $key) : Configuration 
    {
        $prefixes = explode(".", $key);
        foreach($prefixes as $prefix) {
            array_push($this->configPrefixs, $prefix);
        }
        return $this;
    }


    public function resolveConfigurationsWithPrefix(array $prefixes, string $key) : mixed {
        $currentValue = null;
        foreach($prefixes as $iteration => $prefix) {
            if ($iteration === 0) {
                if (! array_key_exists($prefix, $this->configurations)) {
                    throw new \Exception("Undefined configuration ".$prefix.".".$prefix);
                }
                $currentValue = $this->configurations[$prefix];
            }else {
                if (! array_key_exists($prefix, $currentValue)) {
                    throw new \Exception("Undefined configuration ".$prefix.".".$key);
                }
                $currentValue = $currentValue[$prefix];
            }
        }
        return $currentValue[$key];
    }

    public function validateConfiguration($validator) : array {
        return (new $validator($this->configurations))->validate();
    }

    /**
     * @method defualtConfiguration
     * Store the default config for options
     * @return array
     */
    public function defualtConfiguration() : array 
    {
        return [
            "headers"   =>  [],
            "timeout"   =>  30,
            "debug"     =>  true
        ];
    }
}
