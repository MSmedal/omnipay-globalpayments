<?php

namespace Omnipay\GlobalPayments\Message;

use GlobalPayments\Api\Entities\Address;
use GlobalPayments\Api\Entities\Enums\StoredCredentialInitiator;
use GlobalPayments\Api\Entities\StoredCredential;
use GlobalPayments\Api\PaymentMethods\CreditCardData;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $responseType = '\Omnipay\GlobalPayments\Response';
    protected $gpBillingAddyObj;
    protected $gpCardObj;

    protected abstract function runTrans();
    protected abstract function setServicesConfig();

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
            $gpCardObj->cardType = $omnipayCardObj->getType();
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

    public function sendData($data)
    {
        $this->setServicesConfig();

        return new Response($this, $this->runTrans());
    }

    public function getDeviceId()
    {
        return $this->getParameter('deviceId');
    }

    public function setDeviceId($value)
    {
        return $this->setParameter('deviceId', $value);
    }

    public function getUsername()
    {
        return $this->getParameter('username');
    }

    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    public function getDeveloperId()
    {
        return $this->getParameter('developerId');
    }

    public function setDeveloperId($value)
    {
        return $this->setParameter('developerId', $value);
    }

    public function getGoodReponseCodes()
    {
        return $this->getParameter('goodResponseCodes');
    }

    public function setGoodResponseCodes($value)
    {
        return $this->setParameter('goodResponseCodes', $value);
    }
}
