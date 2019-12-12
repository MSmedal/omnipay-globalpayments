<?php

namespace Omnipay\GlobalPayments;

use Omnipay\Common\AbstractGateway;

class TransitGateway extends AbstractGateway 
{
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
            'developerId' => '002914',
            'versionNumber' => '4285',
            'merchantId' => '',
            'transactionKey' => ''
        );
    }

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

    public function purchase($options = array())
    {
        return $this->createRequest('\Omnipay\GlobalPayments\TransitMessage\PurchaseRequest', $options);
    }

    public function authorize($options = array())
    {
        return $this->createRequest('\Omnipay\GlobalPayments\TransitMessage\AuthorizeRequest', $options);
    }

    public function capture($options = array())
    {
        return $this->createRequest('\Omnipay\GlobalPayments\TransitMessage\CaptureRequest', $options);
    }

    public function void($options = array())
    {
        return $this->createRequest('\Omnipay\GlobalPayments\TransitMessage\VoidRequest', $options);
    }
    
    public function refund($options = array())
    {
        return $this->createRequest('\Omnipay\GlobalPayments\TransitMessage\RefundRequest', $options);
    }

    // public function createCard($options = array())
    // {
    //     return $this->createRequest('\Omnipay\Heartland\Message\CreateCardRequest', $options);
    // }

    // public function updateCard($options = array())
    // {
    //     return $this->createRequest('\Omnipay\Heartland\Message\UpdateCardRequest', $options);
    // }

    // public function deleteCard($options = array())
    // {
    //     return $this->createRequest('\Omnipay\Heartland\Message\DeleteCardRequest', $options);
    // }

}
