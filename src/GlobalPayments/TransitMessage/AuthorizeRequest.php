<?php

namespace Omnipay\GlobalPayments\TransitMessage;

use GlobalPayments\Api\PaymentMethods\CreditCardData;
use GlobalPayments\Api\Entities\Address;

class AuthorizeRequest extends AbstractTransitRequest
{
    public function runTransitTrans($data)
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
        if (isset($data['card']['number'])) $chargeMe->number = $data['card']['number'];
        if (isset($data['card']['expiryMonth'])) $chargeMe->expMonth = $data['card']['expiryMonth'];
        if (isset($data['card']['expiryYear'])) $chargeMe->expYear = $data['card']['expiryYear'];
        if (isset($data['card']['cvv'])) $chargeMe->cvn  = $data['card']['cvv'];

        if (isset($data['firstName']) && isset($data['lastName'])) {
            $chargeMe->cardHolderName = $data['firstName'] . " " . $data['lastName'];
        } elseif (isset($data['firstName'])) {
            $chargeMe->cardHolderName = $data['firstName'];
        } elseif (isset($data['lastName'])) {
            $chargeMe->cardHolderName = $data['lastName'];
        }        

        // new GlobalPayments address object
        $address = new Address();
        if (isset($data['billingAddress1'])) $address->streetAddress1 = $data['billingAddress1'];
        if (isset($data['billingAddress2'])) $address->streetAddress2 = $data['billingAddress2'];
        if (isset($data['billingCity'])) $address->city = $data['billingCity'];
        if (isset($data['billingState'])) $address->state = $data['billingState'];
        if (isset($data['billingCountry'])) $address->country = $data['billingCountry'];
        if (isset($data['billingPostcode'])) $address->postalCode = $data['billingPostcode'];

        return $chargeMe->authorize($data['amount'])
            ->withAddress($address)
            ->withCurrency($data['currency'])
            ->execute();
    }
    
}
