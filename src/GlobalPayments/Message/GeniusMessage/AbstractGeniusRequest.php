<?php

namespace Omnipay\GlobalPayments\Message\GeniusMessage;

use GlobalPayments\Api\Entities\Enums\GatewayProvider;
use GlobalPayments\Api\ServiceConfigs\Gateways\GeniusConfig;
use GlobalPayments\Api\ServicesContainer;
use Omnipay\GlobalPayments\Message\AbstractRequest;

abstract class AbstractGeniusRequest extends AbstractRequest
{
    protected function setServicesConfig()
    {
        $config = new GeniusConfig();
        $config->merchantName = $this->getMerchantName();
        $config->merchantSiteId = $this->getMerchantSiteId();
        $config->merchantKey = $this->getMerchantKey();
        $config->developerId = $this->getDeveloperId();
        $config->gatewayProvider = GatewayProvider::GENIUS;
        
        ServicesContainer::configureService($config);
    }

    public function getMerchantName()
    {
        return $this->getParameter('merchantName');
    }

    public function setMerchantName($value)
    {
        return $this->setParameter('merchantName', $value);
    }

    public function getMerchantSiteId()
    {
        return $this->getParameter('merchantSiteId');
    }

    public function setMerchantSiteId($value)
    {
        return $this->setParameter('merchantSiteId', $value);
    }
    
    public function getMerchantKey()
    {
        return $this->getParameter('merchantKey');
    }

    public function setMerchantKey($value)
    {
        return $this->setParameter('merchantKey', $value);
    }
}
