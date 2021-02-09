<?php

namespace Omnipay\GlobalPayments\Message\HeartlandMessage;

use GlobalPayments\Api\ServiceConfigs\Gateways\PorticoConfig;
use GlobalPayments\Api\ServicesContainer;
use Omnipay\GlobalPayments\Message\AbstractRequest;
use Omnipay\GlobalPayments\Message\Response;

abstract class AbstractHeartlandRequest extends AbstractRequest
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
            $data['company']            = $card->getBillingCompany();
        }

        if ($this->getCheck()) {
            $check = $this->getCheck();

            // add check info to $data; all of these are required for Heartland ACH
            $data['check'] = array();
            $data['check']['accountNumber']     = $check->getAccountNumber();
            $data['check']['routingNumber']     = $check->getRoutingNumber();
            $data['check']['accountType']       = $check->getAccountType();
            $data['check']['secCode']           = $check->getSecCode();
            $data['check']['checkType']         = $check->getCheckType();

            if (!empty($check->getFirstName()) && !empty($check->getLastName())) {
                $data['check']['checkHolderName'] = $check->getFirstName() . ' ' . $check->getLastName();
            } elseif(!empty($check->getFirstName()) || !empty($check->getLastName())) {
                $data['check']['checkHolderName'] = !empty($check->getFirstName()) ? $check->getFirstName() : $check->getLastName();
            } else {
                $data['check']['checkHolderName'] = $check->getBillingCompany();
            }

            $check->setCheckHolderName($data['check']['checkHolderName']);

            // add payor info to $data
            $data['firstName']          = $check->getFirstName();
            $data['lastName']           = $check->getLastName();
            $data['billingAddress1']    = $check->getBillingAddress1();
            $data['billingAddress2']    = $check->getBillingAddress2();
            $data['billingCity']        = $check->getBillingCity();
            $data['billingPostcode']    = $check->getBillingPostcode();
            $data['billingState']       = $check->getBillingState();
            $data['billingCountry']     = $check->getBillingCountry();
            $data['billingPhone']       = $check->getBillingPhone();
            $data['email']              = $check->getEmail();
            $data['company']            = $check->getBillingCompany();
        }

        if ($this->getCustomer()) {
            $customer = $this->getCustomer();

            // add customer info to $data
            if ($this->getCustomerReference()) $data['customerReference']           = $this->getCustomerReference(); // will be generated automatically if not provided
            if (isset($customer['firstName'])) $data['firstName']                   = $customer['firstName'];
            if (isset($customer['lastName'])) $data['lastName']                     = $customer['lastName'];
            if (isset($customer['company'])) $data['company']                       = $customer['company'];
            if (isset($customer['email'])) $data['email']                           = $customer['email'];
            if (isset($customer['billingAddress1'])) $data['billingAddress1']       = $customer['billingAddress1'];
            if (isset($customer['billingAddress2'])) $data['billingAddress2']       = $customer['billingAddress2'];
            if (isset($customer['billingCity'])) $data['billingCity']               = $customer['billingCity'];
            if (isset($customer['billingPostcode'])) $data['billingPostcode']       = $customer['billingPostcode'];
            if (isset($customer['billingState'])) $data['billingState']             = $customer['billingState'];
            if (isset($customer['billingCountry'])) $data['billingCountry']         = $customer['billingCountry']; // required
        }

        if ($this->getCustomer()) { ////////////waitwut
            $customer = $this->getCustomer();

            // add customer info to $data
            if ($this->getCustomerReference()) $data['customerReference']           = $this->getCustomerReference(); // will be generated automatically if not provided
            if (isset($customer['firstName'])) $data['firstName']                   = $customer['firstName'];
            if (isset($customer['lastName'])) $data['lastName']                     = $customer['lastName'];
            if (isset($customer['company'])) $data['company']                       = $customer['company'];
            if (isset($customer['email'])) $data['email']                           = $customer['email'];
            if (isset($customer['billingAddress1'])) $data['billingAddress1']       = $customer['billingAddress1'];
            if (isset($customer['billingAddress2'])) $data['billingAddress2']       = $customer['billingAddress2'];
            if (isset($customer['billingCity'])) $data['billingCity']               = $customer['billingCity'];
            if (isset($customer['billingPostcode'])) $data['billingPostcode']       = $customer['billingPostcode'];
            if (isset($customer['billingState'])) $data['billingState']             = $customer['billingState'];
            if (isset($customer['billingCountry'])) $data['billingCountry']         = $customer['billingCountry']; // required
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
        $config = new PorticoConfig();

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

        ServicesContainer::configureService($config);
    }
}
