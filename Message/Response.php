<?php

namespace Omnipay\Heartland\Message;

use Omnipay\Common\Message\AbstractResponse;

class Response extends AbstractResponse {

    public function __construct($request, $data)
    {        
        $this->request = $request;
        $this->response = $data;
    }

    public function isSuccessful()
    {
        return in_array($this->response->responseCode, $this->request["goodResponseCodes"]);
    }

    public function getMessage()
    {
        return $this->response->responseMessage;
    }

}

