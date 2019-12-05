<?php

namespace Omnipay\Heartland\Message;

use GlobalPayments\Api\PaymentMethods\CreditCardData;

class PurchaseRequest extends AbstractPorticoRequest
{
    public function getTransactionType()
    {
        return "CreditSale";
    }
    
    public function runHPSTrans($data)
    {
        // set up credit card for HPS
        $chargeMe = new CreditCardData();

        // will need to do some logic for card number vs token etc.
        $chargeMe->number = $data['card']['number'] ;
        $chargeMe->expMonth = $data['card']['expiryMonth'];
        $chargeMe->expYear = $data['card']['expiryYear'];
        $chargeMe->cvn  = $data['card']['cvv'];

        return $chargeMe->charge($this->getAmount())
            ->withCurrency($this->getCurrency())
            ->execute();
    }

    public function getData()
    {
        $data = array();

        // control structure to pick between token or manual entry or payplan thing needs to go here
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

        // add good HPS response codes for trans type
        $data['goodResponseCodes'] = array('00', '10');

        return $data;
    }
    
}
