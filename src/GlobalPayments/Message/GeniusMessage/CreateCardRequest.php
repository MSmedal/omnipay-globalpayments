<?php

namespace Omnipay\GlobalPayments\Message\GeniusMessage;

use GlobalPayments\Api\PaymentMethods\CreditCardData;
use GlobalPayments\Api\Entities\Address;

class CreateCardRequest extends AbstractGeniusRequest
{
    public function runGeniusTrans($data)
    {
        $this->setGoodResponseCodes(array('00', '85'));
        
        // new GlobalPayments credit card object
        $chargeMe = new CreditCardData();

        if ($this->getToken() != null && $this->getToken() != "") {
            $chargeMe->token = $this->getToken();
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

        return $chargeMe->verify($data['amount'])
            ->withAddress($address)
            ->withRequestMultiUseToken(true)
            ->execute();
    }
    
}