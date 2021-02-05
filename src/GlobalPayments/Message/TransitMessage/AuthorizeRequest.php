<?php

namespace Omnipay\GlobalPayments\Message\TransitMessage;

use Exception;
use GlobalPayments\Api\PaymentMethods\CreditCardData;
use GlobalPayments\Api\Entities\Address;
use GlobalPayments\Api\Entities\Enums\StoredCredentialInitiator;
use GlobalPayments\Api\Entities\StoredCredential;
use GlobalPayments\Api\Entities\Transaction;

class AuthorizeRequest extends AbstractTransitRequest
{
    public function runTransitTrans($data)
    {
        $this->setGoodResponseCodes(array('00', '10'));
        
        $chargeMe = new CreditCardData();
        $storedCreds = new StoredCredential();

        if (!empty($this->getToken())) {
            $chargeMe->token = $this->getToken();
        } elseif (!empty($this->getCardReference())) {
            $chargeMe->token = $this->getCardReference();
            $storedCreds->initiator = StoredCredentialInitiator::MERCHANT;
        } else {
            $chargeMe->number = $data['card']['number'];
        }
        
        // tokens and cardRefs do not contain/represent the below elements
        if (!empty($data['card']['expiryMonth'])) $chargeMe->expMonth = $data['card']['expiryMonth'];
        if (!empty($data['card']['expiryYear'])) $chargeMe->expYear = $data['card']['expiryYear'];
        if (!empty($data['card']['cvv'])) $chargeMe->cvn  = $data['card']['cvv'];
        if (!empty($data['card']['type'])) $chargeMe->cardType  = $data['card']['type'];

        if (!empty($data['firstName']) && !empty($data['lastName'])) {
            $chargeMe->cardHolderName = $data['firstName'] . " " . $data['lastName'];
        } elseif (!empty($data['firstName'])) {
            $chargeMe->cardHolderName = $data['firstName'];
        } elseif (!empty($data['lastName'])) {
            $chargeMe->cardHolderName = $data['lastName'];
        }        

        $address = new Address();
        if (!empty($data['billingAddress1'])) $address->streetAddress1 = $data['billingAddress1'];
        if (!empty($data['billingAddress2'])) $address->streetAddress2 = $data['billingAddress2'];
        if (!empty($data['billingCity'])) $address->city = $data['billingCity'];
        if (!empty($data['billingState'])) $address->state = $data['billingState'];
        if (!empty($data['billingCountry'])) $address->country = $data['billingCountry'];
        if (!empty($data['billingPostcode'])) $address->postalCode = $data['billingPostcode'];

        return $this->processTransaction($chargeMe, $data, $address, $storedCreds);
    }

    protected function processTransaction(
        CreditCardData $card,
        array $data,
        Address $billingAddress,
        StoredCredential $storedCredentials
    )
    {
        try {
            $response = $card->authorize($data['amount'])
                ->withAddress($billingAddress)
                ->withCurrency($data['currency'])
                ->withStoredCredential($storedCredentials)
                ->execute();

            if ($response->responseMessage === "Partially Approved") {
                $automaticVoid = Transaction::fromId($response->transactionId)
                    ->void()
                    ->execute();

                $automaticVoid->responseCode = "05";
                $automaticVoid->responseMessage = "Decline";

                return $automaticVoid;
            }

            return $response;
        } catch (Exception $e) {
            return $e;
        }
    }
}
