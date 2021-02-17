<?php

namespace Omnipay\GlobalPayments\Message\TransitMessage;

use Exception;
use GlobalPayments\Api\Entities\Transaction;

class AuthorizeRequest extends AbstractTransitRequest
{
    public function runTrans()
    {
        $this->setGoodResponseCodes(array('00'));
        
        $chargeMe = $this->gpCardObj;

        if (empty($chargeMe->cardType)) {
            trigger_error(
                'cardType (card brand) required for TransIt gateway', E_USER_WARNING
            );
        }

        try {
            $response = $chargeMe->authorize($this->getAmount())
                ->withAddress($this->gpBillingAddyObj)
                ->withCurrency($this->getCurrency())
                ->withDescription($this->getDescription())
                ->withClientTransactionId($this->getTransactionId())
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
