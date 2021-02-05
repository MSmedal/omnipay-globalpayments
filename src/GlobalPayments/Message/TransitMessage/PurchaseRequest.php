<?php

namespace Omnipay\GlobalPayments\Message\TransitMessage;

use Exception;
use GlobalPayments\Api\PaymentMethods\CreditCardData;
use GlobalPayments\Api\Entities\Address;
use GlobalPayments\Api\Entities\StoredCredential;
use GlobalPayments\Api\Entities\Transaction;

class PurchaseRequest extends AuthorizeRequest
{
    protected function processTransaction(
        CreditCardData $card,
        array $data,
        Address $billingAddress,
        StoredCredential $storedCredentials
    )
    {
        try {
            $response = $card->charge($data['amount']) // only change from AuthorizeRequest
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
