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
            'secretApiKey' => '',
            'siteId' => '',
            'deviceId' => '',
            'licenseId' => '',
            'username' => '',
            'password' => '',
            'serviceUri' => '',
            'developerId' => '002914',
            'versionNumber' => '4285',
            'siteTrace' => ''
        );
    }

    public function setServiceUri($value)
    {
        return $this->setParameter('serviceUri', $value);
    }

    public function purchase($options = array())
    {
        return $this->createRequest('\Omnipay\Heartland\TransitMessage\PurchaseRequest', $options);
    }

}
