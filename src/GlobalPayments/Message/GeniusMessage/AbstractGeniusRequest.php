<?php

namespace Omnipay\GlobalPayments\Message\GeniusMessage;

use GlobalPayments\Api\Entities\Enums\GatewayProvider;
use GlobalPayments\Api\ServiceConfigs\Gateways\GeniusConfig;
use GlobalPayments\Api\ServicesContainer;
use Omnipay\GlobalPayments\Message\AbstractRequest;
use Omnipay\GlobalPayments\Message\Response;

abstract class AbstractGeniusRequest extends AbstractRequest
{
    protected $responseType = '\Omnipay\GlobalPayments\Response';

    public function sendData($data)
    {
        $this->setServicesConfig();

        return new Response($this, $this->runGeniusTrans($data));
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
        $data['description']    = $this->getDescription();
        $data['amount']     = $this->getAmount();
        $data['currency']   = $this->getCurrency();
        $data['transactionReference'] = $this->getTransactionReference();

        return $data;
    }

    protected function setServicesConfig()
    {
        $config = new GeniusConfig();
        $config->merchantName = $this->getMerchantName();
        $config->merchantSiteId = $this->getMerchantSiteId();
        $config->merchantKey = $this->getMerchantKey();
        $config->developerId = $this->getDeveloperId();
        $config->gatewayProvider = GatewayProvider::GENIUS;
        
        ServicesContainer::configureService($config);
    }

    public function getMerchantName()
    {
        return $this->getParameter('merchantName');
    }

    public function setMerchantName($value)
    {
        return $this->setParameter('merchantName', $value);
    }

    public function getMerchantSiteId()
    {
        return $this->getParameter('merchantSiteId');
    }

    public function setMerchantSiteId($value)
    {
        return $this->setParameter('merchantSiteId', $value);
    }
    
    public function getMerchantKey()
    {
        return $this->getParameter('merchantKey');
    }

    public function setMerchantKey($value)
    {
        return $this->setParameter('merchantKey', $value);
    }
}
