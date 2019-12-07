<?php

/**
 * Heartland Gateway redux
 */

namespace Omnipay\Heartland;

use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway 
{
    public function getName()
    {
        return 'Heartland';
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

    public function setSecretApiKey($value)
    {
        return $this->setParameter('secretApiKey', $value);
    }

    public function setSiteId($value)
    {
        return $this->setParameter('siteId', $value);
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
        return $this->setVersionNumber('versionNumber', $value);
    }

    public function setSiteTrace($value)
    {
        return $this->setParameter('siteTrace', $value);
    }

    public function setServiceUri($value)
    {
        return $this->setParameter('serviceUri', $value);
    }

    public function purchase($options = array())
    {
        return $this->createRequest('\Omnipay\Heartland\Message\PurchaseRequest', $options);
    }
    
}
