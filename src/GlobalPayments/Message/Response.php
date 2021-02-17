<?php

namespace Omnipay\GlobalPayments\Message;

use GlobalPayments\Api\Entities\Transaction;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\GlobalPayments\Message\HeartlandMessage\UpdateCardRequest as HeartlandUpdateCardRequest;
use Omnipay\GlobalPayments\Message\HeartlandMessage\DeleteCardRequest as HeartlandDeleteCardRequest;

class Response extends AbstractResponse
{
    public function __construct($request, $data)
    {        
        $this->request = $request;
        $this->response = $data;
    }

    public function isSuccessful()
    {
        if ($this->response instanceof Transaction) {
            return in_array(
                $this->response->responseCode, $this->request->getGoodReponseCodes()
            );
        } elseif ($this->request instanceof HeartlandDeleteCardRequest || $this->request instanceof HeartlandUpdateCardRequest) {
            return $this->response;
        }

        return false;
    }

    public function getMessage()
    {
        return $this->response->responseMessage;
    }
    
    public function getCode()
    {
        return $this->response->responseCode;
    }

    public function getTransactionReference()
    {
        return $this->response->transactionId;
    }

    public function getCardReference()
    {
        return $this->response->token;
    }

    public function getCustomerReference()
    {
        return $this->response->id;
    }

    public function getPaymentMethodReference()
    {
        return $this->response->id;
    }
}
