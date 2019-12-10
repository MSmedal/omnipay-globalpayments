<?php

namespace Omnipay\Heartland\Message;

use GlobalPayments\Api\ServicesConfig;
use GlobalPayments\Api\ServicesContainer;

abstract class AbstractPorticoRequest extends AbstractRequest
{
    protected $responseType = '\Omnipay\Heartland\Message\PorticoResponse';

    public function sendData($data)
    {
        $this->setServicesConfig();

        return new Response($this, $this->runHPSTrans($data));
    }

    protected function setServicesConfig()
    {
        $config = new ServicesConfig();

        if ($this->getSecretApiKey() != null && $this->getSecretApiKey() != "") {
            $config->secretApiKey = trim($this->getSecretApiKey());
        } else {
            $config->siteId =       $this->getSiteId();
            $config->licenseId =    $this->getLicenseId();
            $config->deviceId =     $this->getDeviceId();
            $config->username =     $this->getUsername();
            $config->password =     $this->getPassword();
        }
        
        ServicesContainer::configure($config);
    }

}
