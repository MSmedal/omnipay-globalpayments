<?php

namespace Omnipay\Heartland\Message;

use Omnipay\Common\Message\AbstractResponse;

class Response extends AbstractResponse
{
    public function __construct($request, $data)
    {        
        $this->request = $request;
        $this->response = $data;
    }

    public function isSuccessful()
    {
        return in_array($this->response->responseCode, $this->request->getGoodReponseCodes());
    }

    public function isDecline()
    {
        return !in_array($this->response->responseCode, $this->request->getGoodReponseCodes());
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

}
