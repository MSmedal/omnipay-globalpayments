<?php

namespace Omnipay\Heartland\Message;

use GlobalPayments\Api\PaymentMethods\CreditCardData;

class AuthorizeRequest extends AbstractPorticoRequest
{
    /**
     * @return string
     */
    public function getTransactionType()
    {
        return 'CreditAuth';
    }
    
    public function getData()
    {
        $cardInfo = $this->getCard();

        $card = new CreditCardData();
        if ($this->getToken() != null && $this->getToken() != "") {
            $card->token = $this->getToken();
        } else {
            $card->number = $cardInfo->getNumber();
            $card->expMonth = $cardInfo->getExpiryMonth();
            $card->expYear = $cardInfo->getExpiryYear();
            $card->cvn = $cardInfo->getCvv();
        }

        // parent::getData();
        // $amount = HpsInputValidation::checkAmount($this->getAmount());
        // $xml = new DOMDocument();
        // $hpsTransaction = $xml->createElement('hps:Transaction');
        // $hpsCreditAuth = $xml->createElement('hps:' . $this->getTransactionType());
        // $hpsBlock1 = $xml->createElement('hps:Block1');
        // $hpsBlock1->appendChild($xml->createElement('hps:AllowDup', 'Y'));
        // //$hpsBlock1->appendChild($xml->createElement('hps:AllowPartialAuth', ($allowPartialAuth ? 'Y' : 'N')));
        // $hpsBlock1->appendChild($xml->createElement('hps:Amt', $amount));
        // if ($this->getPurchaseCardRequest()) {
        //     $hpsBlock1->appendChild($xml->createElement(
        //         'hps:CPCReq',
        //         $this->getPurchaseCardRequest() === true ? 'Y' : 'N'
        //     ));
        // }
        // $hpsBlock1->appendChild($this->hydrateCardHolderData($xml));
        // if ($this->getTransactionId()) {
        //     $hpsBlock1->appendChild($this->hydrateAdditionalTxnFields($xml));
        // }
        // if ($this->getDescription()) {
        //     $hpsBlock1->appendChild($xml->createElement('hps:TxnDescriptor', $this->getDescription()));
        // }
        // $cardData = $xml->createElement('hps:CardData');
        // if ($this->getToken()) {
        //     $cardData->appendChild($this->hydrateTokenData($xml));
        // } else {
        //     $cardData->appendChild($this->hydrateManualEntry($xml));
        // }
        // if ($this->getRequestCardReference()) {
        //     $cardData->appendChild($xml->createElement(
        //         'hps:TokenRequest',
        //         $this->getRequestCardReference() === true ? 'Y' : 'N'
        //     ));
        // }
        // $hpsBlock1->appendChild($cardData);
        // $hpsCreditAuth->appendChild($hpsBlock1);
        // $hpsTransaction->appendChild($hpsCreditAuth);
        // return $hpsTransaction = 'let\'s see what this does';

        

        return $card;
    }
    public function handleResponse($response)
    {
        if ($this->getPurchaseCardRequest() && $response->getPurchaseCardIndicator()) {
            $cpcEdit = new PurchaseCardEditRequest($this->httpClient, $this->httpRequest);
            foreach ($this->getParameters() as $key => $value) {
                $cpcEdit->setParameter($key, $value);
            }
            $cpcEdit->setTransactionReference($response->getTransactionReference());
            $response->setPurchaseCardResponse($cpcEdit->send());
        }
        return $response;
    }
    public function setCustomerReference($value)
    {
        return $this->setParameter('customerReference', $value);
    }
    public function getCustomerReference()
    {
        return $this->getParameter('customerReference');
    }
    public function setPaymentMethodReference($value)
    {
        return $this->setParameter('paymentMethodKey', $value);
    }
    public function getPaymentMethodReference()
    {
        return $this->getParameter('paymentMethodKey');
    }
    public function getPurchaseCardRequest()
    {
        return $this->getCardHolderPONumber()
            || $this->getTaxAmount()
            || $this->getTaxType();
    }
    public function getCardHolderPONumber()
    {
        return $this->getParameter('cardHolderPONumber');
    }
    public function setCardHolderPONumber($value)
    {
        return $this->setParameter('cardHolderPONumber', $value);
    }
    public function getTaxAmount()
    {
        return $this->getParameter('taxAmount');
    }
    public function setTaxAmount($value)
    {
        return $this->setParameter('taxAmount', $value);
    }
    public function getTaxType()
    {
        return $this->getParameter('taxType');
    }
    public function setTaxType($value)
    {
        return $this->setParameter('taxType', $value);
    }
    public function getRequestCardReference()
    {
        return $this->getParameter('requestCardReference');
    }
    public function setRequestCardReference($value)
    {
        return $this->setParameter('requestCardReference', $value);
    }
}