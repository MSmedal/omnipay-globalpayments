<?php

namespace Omnipay\GlobalPayments\HeartlandMessage;

use GlobalPayments\Api\ServicesConfig;
use GlobalPayments\Api\ServicesContainer;
use Omnipay\GlobalPayments\AbstractRequest;
use Omnipay\GlobalPayments\Response;

abstract class AbstractPorticoRequest extends AbstractRequest
{
    protected $responseType = '\Omnipay\GlobalPayments\Response';

    public function sendData($data)
    {
        $this->setServicesConfig();

        return new Response($this, $this->runHPSTrans($data));
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

        if ($this->getCheck()) {
            $check = $this->getCheck();

            // add check info to $data
            $data['check'] = array();
            $data['check']['accountNumber']     = $check['accountNumber'];
            $data['check']['routingNumber']     = $check['routingNumber'];
            $data['check']['accountType']       = $check['accountType'];
            $data['check']['secCode']           = $check['secCode'];
            $data['check']['checkType']         = $check['checkType'];
            $data['check']['checkHolderName']   = $check['checkHolderName'];

            // add payor info to $data
            if (isset($check['billingAddress1'])) $data['billingAddress1']  = $check['billingAddress1'];
            if (isset($check['billingAddress2'])) $data['billingAddress2']  = $check['billingAddress2'];
            if (isset($check['billingCity'])) $data['billingCity']          = $check['billingCity'];
            if (isset($check['billingPostcode'])) $data['billingPostcode']  = $check['billingPostcode'];
            if (isset($check['billingState'])) $data['billingState']        = $check['billingState'];
            if (isset($check['billingCountry'])) $data['billingCountry']    = $check['billingCountry'];
            if (isset($check['billingPhone'])) $data['billingPhone']        = $check['billingPhone'];
            if (isset($check['email'])) $data['email']                      = $check['email'];
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
        $config = new ServicesConfig();

        if ($this->getSecretApiKey() != null && $this->getSecretApiKey() != "") {
            $config->secretApiKey = trim($this->getSecretApiKey());
        } else {
            $config->siteId     = $this->getSiteId();
            $config->licenseId  = $this->getLicenseId();
            $config->deviceId   = $this->getDeviceId();
            $config->username   = $this->getUsername();
            $config->password   = $this->getPassword();
        }

        $config->developerId    = $this->getDeveloperId();
        $config->versionNumber  = $this->getVersionNumber();

        ServicesContainer::configure($config);
    }
}
