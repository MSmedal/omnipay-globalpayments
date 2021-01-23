<?php

namespace Omnipay\GlobalPayments;

use Omnipay\Common\AbstractGateway;

class GeniusGateway extends AbstractGateway 
{
    public function getName()
    {
        return 'Genius';
    }

    public function getDefaultParameters()
    {
        return array(
            'merchantName' => '',
            'siteId' => '',
            'merchantKey' => '',
            'developerId' => '',
            'versionNumber' => '',
        );
    }

    public function setMerchantName($value)
    {
        return $this->setParameter('merchantName', $value);
    }

    public function setMerchantSiteId($value)
    {
        return $this->setParameter('merchantSiteId', $value);
    }

    public function setMerchantKey($value)
    {
        return $this->setParameter('merchantKey', $value);
    }

    public function setDeveloperId($value)
    {
        return $this->setParameter('developerId', $value);
    }

    public function setVersionNumber($value)
    {
        return $this->setParameter('versionNumber', $value);
    }

    public function purchase($options = array())
    {
        return $this->createRequest('\Omnipay\GlobalPayments\GeniusMessage\PurchaseRequest', $options);
    }

    public function authorize($options = array())
    {
        return $this->createRequest('\Omnipay\GlobalPayments\GeniusMessage\AuthorizeRequest', $options);
    }

    public function capture($options = array())
    {
        return $this->createRequest('\Omnipay\GlobalPayments\GeniusMessage\CaptureRequest', $options);
    }

    public function void($options = array())
    {
        return $this->createRequest('\Omnipay\GlobalPayments\GeniusMessage\VoidRequest', $options);
    }
    
    public function refund($options = array())
    {
        return $this->createRequest('\Omnipay\GlobalPayments\GeniusMessage\RefundRequest', $options);
    }

    public function createCard($options = array())
    {
        return $this->createRequest('\Omnipay\GlobalPayments\GeniusMessage\CreateCardRequest', $options);
    }

    public function updateCard($options = array())
    {
        return $this->createRequest('\Omnipay\GlobalPayments\GeniusMessage\UpdateCardRequest', $options);
    }

    public function deleteCard($options = array())
    {
        return $this->createRequest('\Omnipay\GlobalPayments\GeniusMessage\DeleteCardRequest', $options);
    }

}
