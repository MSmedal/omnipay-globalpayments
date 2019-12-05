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

        return new Response($data, $this->runHPSTrans($data));
    }

    public function getEndpoint()
    {
        if ($this->getSecretApiKey() != null && $this->getSecretApiKey() != "") {
            if (strpos($this->getSecretApiKey(), '_cert_') !== false) {
                $this->setParameter('testMode', true);
                return "https://cert.api2.heartlandportico.com";
            } elseif (strpos($this->getSecretApiKey(), '_uat_') !== false) {
                $this->setParameter('testMode', true);
                return "https://posgateway.uat.secureexchange.net";
            } else {
                $this->setParameter('testMode', false);
                return "https://api2-c.heartlandportico.com";
            }
        } else {
            return $this->getServiceUri();
        }
    }

    protected function setServicesConfig()
    {
        $config = new ServicesConfig();
        $config->serviceUrl = $this->getEndpoint();

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
