<?php

namespace Omnipay\GlobalPayments\Message\TransitMessage;

use GlobalPayments\Api\ServiceConfigs\AcceptorConfig;
use GlobalPayments\Api\ServiceConfigs\Gateways\TransitConfig;
use GlobalPayments\Api\ServicesContainer;
use Omnipay\GlobalPayments\Message\AbstractRequest;
use Omnipay\GlobalPayments\Message\Response;

abstract class AbstractTransitRequest extends AbstractRequest
{
    protected $responseType = '\Omnipay\GlobalPayments\Response';

    public function sendData($data)
    {
        $this->setServicesConfig();

        return new Response($this, $this->runTransitTrans($data));
    }

    public function getData()
    {
        $data = array();

        if ($this->getCard()) {
            $card = $this->getCard();
        
            // add card info to $data
            $data['card'] = array();
            $data['card']['number']         = $card->getNumber();
            $data['card']['expiryMonth']    = $card->getExpiryMonth();
            $data['card']['expiryYear']     = $card->getExpiryYear();
            $data['card']['cvv']            = $card->getCvv();
            $data['card']['type']           = $card->getType();
    
            // add payor info to $data
            $data['firstName']          = $card->getFirstName();
            $data['lastName']           = $card->getLastName();
            $data['billingAddress1']    = $card->getBillingAddress1();
            $data['billingAddress2']    = $card->getBillingAddress2();
            $data['billingCity']        = $card->getBillingCity();
            $data['billingPostcode']    = $card->getBillingPostcode();
            $data['billingState']       = $card->getBillingState();
            $data['billingCountry']     = $card->getBillingCountry();
            $data['billingPhone']       = $card->getBillingPhone();
            $data['email']              = $card->getEmail();
        }

        // add transaction information to $data
        $data['description']            = $this->getDescription();
        $data['amount']                 = $this->getAmount();
        $data['currency']               = $this->getCurrency();
        $data['transactionReference']   = $this->getTransactionReference();

        return $data;
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
