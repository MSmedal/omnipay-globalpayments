<?php

namespace Omnipay\GlobalPayments\Message\TransitMessage;

use GlobalPayments\Api\ServiceConfigs\AcceptorConfig;
use GlobalPayments\Api\ServiceConfigs\Gateways\TransitConfig;
use GlobalPayments\Api\ServicesContainer;
use Omnipay\GlobalPayments\Message\AbstractRequest;

abstract class AbstractTransitRequest extends AbstractRequest
{
    protected function setServicesConfig()
    {
        $config = new TransitConfig();
        $config->merchantId = $this->getMerchantId();
        $config->username = $this->getUsername();
        $config->password = $this->getPassword();
        $config->deviceId = $this->getDeviceId();
        $config->developerId = $this->getDeveloperId();
        $config->acceptorConfig = new AcceptorConfig();
        
        if (!empty($this->getTransactionKey())) {
            $config->transactionKey = $this->getTransactionKey();
        } else {
            ServicesContainer::configureService($config);
            $provider = ServicesContainer::instance()->getClient('default');
            $response = $provider->getTransactionKey();
            $config->transactionKey = $response->transactionKey;
        }
        
        ServicesContainer::configureService($config);
    }
    
    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    public function getTransactionKey()
    {
        return $this->getParameter('transactionKey');
    }

    public function setTransactionKey($value)
    {
        return $this->setParameter('transactionKey', $value);
    }
}
