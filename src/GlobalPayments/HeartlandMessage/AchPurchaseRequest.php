<?php

namespace Omnipay\GlobalPayments\HeartlandMessage;

use GlobalPayments\Api\Entities\Enums\AccountType;
use GlobalPayments\Api\Entities\Enums\CheckType;
use GlobalPayments\Api\PaymentMethods\ECheck;
use \GlobalPayments\Api\Entities\Enums\SecCode;
use GlobalPayments\Api\Entities\Address;

class AchPurchaseRequest extends AbstractPorticoRequest
{
    public function runHPSTrans($data)
    {
        $this->setGoodResponseCodes(array('00'));

        // new Heartland check object
        $check = new ECheck();

        // set account and routing number
        if ($this->getToken() != null && $this->getToken() != "") {
            $chargeMe->token = $this->getToken();
        } elseif ($this->getCardReference() != null && $this->getCardReference() != "") {
            $chargeMe->token = $this->getCardReference();
        } else {
            $check->accountNumber = $data['check']['accountNumber'];
            $check->routingNumber = $data['check']['routingNumber'];

        }

        // set account type
        if ($data['check']['accountType'] == 'checking') {
            $check->accountType = AccountType::CHECKING;
        } elseif ($data['check']['accountType'] == 'savings') {
            $check->accountType = AccountType::SAVINGS;
        }

        // set check type
        if ($data['check']['checkType'] == 'personal') {
            $check->checkType = CheckType::PERSONAL;
        } elseif ($data['check']['checkType'] == 'business') {
            $check->checkType = CheckType::BUSINESS;
        }

        // set secCode
        if ($data['check']['secCode'] == 'web') {
            $check->secCode = secCode::WEB;
        } elseif ($data['check']['secCode'] = 'ppd') {
            $check->secCode = secCode::PPD;
        } elseif ($data['check']['secCode'] = 'ccd') {
            $check->secCode = secCode::CCD;
        }        

        // set checkholder name
        $check->checkHolderName =  $data['check']['checkHolderName'];

        // new GlobalPayments address object
        $address = new Address();
        if (isset($data['billingAddress1'])) $address->streetAddress1 = $data['billingAddress1'];
        if (isset($data['billingAddress2'])) $address->streetAddress2 = $data['billingAddress2'];
        if (isset($data['billingCity'])) $address->city = $data['billingCity'];
        if (isset($data['billingState'])) $address->state = $data['billingState'];
        if (isset($data['billingCountry'])) $address->country = $data['billingCountry'];
        if (isset($data['billingPostcode'])) $address->postalCode = $data['billingPostcode'];

        return $check->charge($data['amount'])
            ->withAddress($address)
            ->withCurrency($data['currency'])
            ->execute();
    }
    
}