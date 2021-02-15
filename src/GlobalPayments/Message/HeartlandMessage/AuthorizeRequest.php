<?php

namespace Omnipay\GlobalPayments\Message\HeartlandMessage;

use GlobalPayments\Api\Entities\Enums\StoredCredentialInitiator;
use GlobalPayments\Api\Entities\StoredCredential;

class AuthorizeRequest extends AbstractHeartlandRequest
{
    public function runHPSTrans($data)
    {
        $this->setGoodResponseCodes(array('00', '10'));

        $chargeMe = $this->getGpCardObj();
        $storedCredentials = new StoredCredential();

        if (!empty($this->getToken())) {
            $chargeMe->token = $this->getToken();
        } elseif (!empty($this->getCardReference())) {
            $chargeMe->token = $this->getCardReference();
            $storedCredentials->initiator = StoredCredentialInitiator::MERCHANT;
        }

        return $chargeMe->authorize($this->getAmount())
            ->withAddress($this->getGpBillingAddyObj())
            ->withAddress($this->getGpShippingAddyObj())
            ->withCurrency($this->getCurrency())
            ->withDescription($this->getDescription())
            ->withClientTransactionId($this->getTransactionId())
            ->execute();
    }
}
