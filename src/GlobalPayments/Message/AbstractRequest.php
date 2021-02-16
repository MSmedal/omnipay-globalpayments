<?php

namespace Omnipay\GlobalPayments\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $responseType = '\Omnipay\GlobalPayments\Response';

    protected abstract function runTrans();
    protected abstract function setServicesConfig();

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
