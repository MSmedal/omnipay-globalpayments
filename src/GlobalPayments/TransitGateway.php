<?php

namespace Omnipay\GlobalPayments;

use Omnipay\Common\AbstractGateway;

class TransitGateway extends AbstractGateway
{
    private $transitMessagePath = '\Omnipay\GlobalPayments\Message\TransitMessage';

    public function getName()
    {
        return 'Transit';
    }

    public function getDefaultParameters()
    {
        return array(
            'deviceId' => '',
            'username' => '',
            'password' => '',
            'developerId' => '003226G002',
            'merchantId' => '',
            'transactionKey' => ''
        );
    }

    // Methods for setting Gateway Authentication properties

    public function setDeviceId($value)
    {
        return $this->setParameter('deviceId', $value);
    }

    public function setUserName($value)
    {
        return $this->setParameter('userName', $value);
    }

    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    public function setDeveloperId($value)
    {
        return $this->setParameter('developerId', $value);
    }

    public function setVersionNumber($value)
    {
        return $this->setParameter('versionNumber', $value);
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    public function setTransactionKey($value)
    {
        return $this->setParameter('transactionKey', $value);
    }

    // Transactions

    public function purchase($options = array())
    {
        return $this->createRequest(
            $this->transitMessagePath . '\PurchaseRequest', $options
        );
    }

    public function authorize($options = array())
    {
        return $this->createRequest(
            $this->transitMessagePath . '\AuthorizeRequest', $options
        );
    }

    public function capture($options = array())
    {
        return $this->createRequest(
            $this->transitMessagePath . '\CaptureRequest', $options
        );
    }

    public function void($options = array())
    {
        return $this->createRequest(
            $this->transitMessagePath . '\VoidRequest', $options
        );
    }
    
    public function refund($options = array())
    {
        return $this->createRequest(
            $this->transitMessagePath . '\RefundRequest', $options
        );
    }

    public function createCard($options = array())
    {
        return $this->createRequest(
            $this->transitMessagePath . '\CreateCardRequest', $options
        );
    }
}
