<?php

namespace Omnipay\Heartland\Message;

use GlobalPayments\Api\PaymentMethods\CreditCardData;
use GlobalPayments\Api\Entities\Address;
use GlobalPayments\Api\Entities\Customer;


class PurchaseRequest extends AbstractPorticoRequest
{
    public function runHPSTrans($data)
    {
        $this->setGoodResponseCodes(array('00', '10'));
        
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

        return $chargeMe->charge($data['amount'])
            ->withAddress($address)
            ->withCurrency($data['currency'])
            ->execute();
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

        return $data;
    }
    
}
