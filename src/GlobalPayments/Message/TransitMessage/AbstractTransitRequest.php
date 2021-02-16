<?php

namespace Omnipay\GlobalPayments\Message\TransitMessage;

use GlobalPayments\Api\Entities\Address;
use GlobalPayments\Api\Entities\Enums\StoredCredentialInitiator;
use GlobalPayments\Api\Entities\StoredCredential;
use GlobalPayments\Api\PaymentMethods\CreditCardData;
use GlobalPayments\Api\ServiceConfigs\AcceptorConfig;
use GlobalPayments\Api\ServiceConfigs\Gateways\TransitConfig;
use GlobalPayments\Api\ServicesContainer;
use Omnipay\GlobalPayments\Message\AbstractRequest;

abstract class AbstractTransitRequest extends AbstractRequest
{
    protected $gpBillingAddyObj;
    protected $gpCardObj;

    protected function getGpCardObj()
    {
        $gpCardObj = new CreditCardData();

        if ($this->getCard()) {
            $omnipayCardObj = $this->getCard();
            
            $gpCardObj->number = $omnipayCardObj->getNumber();
            $gpCardObj->expMonth = $omnipayCardObj->getExpiryMonth();
            $gpCardObj->expYear = $omnipayCardObj->getExpiryYear();
            $gpCardObj->cvn = $omnipayCardObj->getCvv();
            $gpCardObj->cardHolderName = $omnipayCardObj->getFirstName() . $omnipayCardObj->getLastName();
        }

        if (!empty($this->getToken())) {
            $gpCardObj->token = $this->getToken();
        } elseif (!empty($this->getCardReference())) {
            $gpCardObj->token = $this->getCardReference();
            $storedCredentials = new StoredCredential();
            $storedCredentials->initiator = StoredCredentialInitiator::MERCHANT;
        }

        return $gpCardObj;
    }

    protected function getGpBillingAddyObj()
    {
        $gpAddyObj = new Address();

        if ($this->getCard()) {
            $omnipayCardObj = $this->getCard();

            $gpAddyObj->streetAddress1 = $omnipayCardObj->getBillingAddress1();
            $gpAddyObj->streetAddress2 = $omnipayCardObj->getBillingAddress2();
            $gpAddyObj->city = $omnipayCardObj->getBillingCity();
            $gpAddyObj->postalCode = $omnipayCardObj->getBillingPostcode();
            $gpAddyObj->state = $omnipayCardObj->getBillingState();
            $gpAddyObj->country = $omnipayCardObj->getBillingCountry();
        }

        return $gpAddyObj;
    }

    public function getData()
    {
        $this->gpBillingAddyObj = $this->getGpBillingAddyObj();
        $this->gpCardObj = $this->getGpCardObj();
    }

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
