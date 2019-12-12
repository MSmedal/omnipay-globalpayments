<?php

namespace Omnipay\GlobalPayments\TransitMessage;

use GlobalPayments\Api\Entities\Enums\GatewayProvider;
use GlobalPayments\Api\ServicesConfig;
use GlobalPayments\Api\ServicesContainer;
use Omnipay\GlobalPayments\AbstractRequest;
use Omnipay\GlobalPayments\Response;

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

        // add transaction information to $data
        $data['description']    = $this->getDescription();
        $data['amount']     = $this->getAmount();
        $data['currency']   = $this->getCurrency();
        $data['transactionReference'] = $this->getTransactionReference();

        return $data;
    }

    protected function setServicesConfig()
    {
        $config = new ServicesConfig();
        $config->merchantId = $this->getMerchantId();
        $config->username = $this->getUsername();
        $config->password = $this->getPassword();
        $config->deviceId = $this->getDeviceId();
        $config->developerId = $this->getDeveloperId();
        $config->gatewayProvider = GatewayProvider::TRANSIT;

        if ($this->getTransactionKey() != null && $this->getTransactionKey() != "") {
            $config->getTransactionKey = $this->getTransactionKey();
        } else {
            ServicesContainer::configure($config);
            $provider = ServicesContainer::instance()->getClient();
            $response = $provider->getTransactionKey();
            $config->transactionKey = $response->transactionKey;
        }
        
        ServicesContainer::configure($config);
    }

}
