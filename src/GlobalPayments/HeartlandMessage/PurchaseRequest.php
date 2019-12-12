<?php

namespace Omnipay\GlobalPayments\HeartlandMessage;

use GlobalPayments\Api\PaymentMethods\CreditCardData;
use GlobalPayments\Api\Entities\Address;

class PurchaseRequest extends AbstractPorticoRequest
{
    public function runHPSTrans($data)
    {
        $this->setGoodResponseCodes(array('00', '10'));
        
        // new GlobalPayments credit card object
        $chargeMe = new CreditCardData();

        if ($this->getToken() != null && $this->getToken() != "") {
            $chargeMe->token = $this->getToken();
        } elseif ($this->getCardReference() != null && $this->getCardReference() != "") {
            $chargeMe->token = $this->getCardReference();
        }
        // token and card info can be submitted simultaneously; discrete card info values (below vars) will take precedence over token-contained card info
        $chargeMe->number = $data['card']['number'] ;
        $chargeMe->expMonth = $data['card']['expiryMonth'];
        $chargeMe->expYear = $data['card']['expiryYear'];
        $chargeMe->cvn  = $data['card']['cvv'];
        $chargeMe->cardHolderName = $data['firstName'] . " " . $data['lastName'];

        // new GlobalPayments address object
        $address = new Address();
        $address->streetAddress1 = $data['billingAddress1'];
        $address->streetAddress2 = $data['billingAddress2'];
        $address->city = $data['billingCity'];
        $address->state = $data['billingState'];
        $address->country = $data['billingCountry'] ;
        $address->postalCode = $data['billingPostcode'];

        return $chargeMe->charge($data['amount'])
            ->withAddress($address)
            ->withCurrency($data['currency'])
            ->execute();
    }
    
}
