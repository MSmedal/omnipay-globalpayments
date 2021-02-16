<?php

namespace Omnipay\GlobalPayments\Message\HeartlandMessage;

use GlobalPayments\Api\Entities\Address;
use GlobalPayments\Api\Entities\Enums\AddressType;
use GlobalPayments\Api\Entities\Enums\StoredCredentialInitiator;
use GlobalPayments\Api\Entities\StoredCredential;
use GlobalPayments\Api\PaymentMethods\CreditCardData;
use GlobalPayments\Api\PaymentMethods\ECheck;
use GlobalPayments\Api\ServiceConfigs\Gateways\PorticoConfig;
use GlobalPayments\Api\ServicesContainer;
use Omnipay\GlobalPayments\Message\Response;

abstract class AbstractHeartlandRequest extends \Omnipay\GlobalPayments\Message\AbstractRequest
{
    protected $gpBillingAddyObj;
    protected $gpCardObj;
    protected $gpCheckObj;

    protected function getGpCheckObj()
    {
        $gpCheckObj = new ECheck();

        if ($this->getCheck()) {
            $omnipayCheckObj = $this->getCheck();

            // Single-Use Token contains/represents account and routing numbers
            if (!empty($this->getToken())) {
                $gpCheckObj->token = $this->getToken();
            } else {
                $gpCheckObj->accountNumber = $omnipayCheckObj->getAccountNumber();
                $gpCheckObj->routingNumber = $omnipayCheckObj->getRoutingNumber();
            }

            $gpCheckObj->accountType      = $omnipayCheckObj->getAccountType();
            $gpCheckObj->checkType        = $omnipayCheckObj->getCheckType();
            $gpCheckObj->secCode          = $omnipayCheckObj->getSecCode();
            $gpCheckObj->checkHolderName  = $omnipayCheckObj->getCheckHolderName();
        }

        return $gpCheckObj;
    }

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
        $this->gpCheckObj = $this->getGpCheckObj();
    }

    protected function setServicesConfig()
    {
        $config = new PorticoConfig();

        if (!empty($this->getSecretApiKey())) {
            $config->secretApiKey = trim($this->getSecretApiKey());
        } else {
            $config->siteId     = $this->getSiteId();
            $config->licenseId  = $this->getLicenseId();
            $config->deviceId   = $this->getDeviceId();
            $config->username   = $this->getUsername();
            $config->password   = $this->getPassword();
        }

        $config->developerId    = $this->getDeveloperId();
        $config->versionNumber  = $this->getVersionNumber();

        ServicesContainer::configureService($config);
    }

    public function getSecretApiKey()
    {
        return $this->getParameter('secretApiKey');
    }

    public function setSecretApiKey($value)
    {
        return $this->setParameter('secretApiKey', $value);
    }

    public function getSiteId()
    {
        return $this->getParameter('siteId');
    }

    public function setSiteId($value)
    {
        return $this->setParameter('siteId', $value);
    }

    public function getLicenseId()
    {
        return $this->getParameter('licenseId');
    }

    public function setLicenseId($value)
    {
        return $this->setParameter('licenseId', $value);
    }

    public function getVersionNumber()
    {
        return $this->getParameter('versionNumber');
    }

    public function setVersionNumber($value)
    {
        return $this->setParameter('versionNumber', $value);
    }

    public function getCheck()
    {
        return $this->getParameter('check');
    }

    public function setCheck($value)
    {
        return $this->setParameter('check', $value);
    }

    public function getCustomerReference()
    {
        return $this->getParameter('customerReference');
    }

    public function setCustomerReference($value)
    {
        return $this->setParameter('customerReference', $value);
    }

    public function getCustomer()
    {
        return $this->getParameter('customer');
    }

    public function setCustomer($value)
    {
        return $this->setParameter('customer', $value);
    }

    public function getPaymentMethodReference()
    {
        return $this->getParameter('paymentMethodReference');
    }

    public function setPaymentMethodReference($value)
    {
        return $this->setParameter('paymentMethodReference', $value);
    }
}
