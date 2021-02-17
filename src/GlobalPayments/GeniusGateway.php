<?php

namespace Omnipay\GlobalPayments;

use Omnipay\Common\AbstractGateway;

class GeniusGateway extends AbstractGateway
{
    private $geniusMessagePath = '\Omnipay\GlobalPayments\Message\GeniusMessage';

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

    // Methods for setting Gateway Authentication properties

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

    // Transactions
    
    public function purchase($options = array())
    {
        return $this->createRequest(
            $this->geniusMessagePath . '\PurchaseRequest', $options
        );
    }

    public function authorize($options = array())
    {
        return $this->createRequest(
            $this->geniusMessagePath . '\AuthorizeRequest', $options
        );
    }

    public function capture($options = array())
    {
        return $this->createRequest(
            $this->geniusMessagePath . '\CaptureRequest', $options
        );
    }

    public function void($options = array())
    {
        return $this->createRequest(
            $this->geniusMessagePath . '\VoidRequest', $options
        );
    }
    
    public function refund($options = array())
    {
        return $this->createRequest(
            $this->geniusMessagePath . '\RefundRequest', $options
        );
    }

    public function createCard($options = array())
    {
        return $this->createRequest(
            $this->geniusMessagePath . '\CreateCardRequest', $options
        );
    }
}
