<?php

$publicKey = 'pkapi_cert_jKc1FtuyAydZhZfbB3';

function getToken(array $card, $publicKey)
{
    $payload = array(
        'object' => 'token',
        'token_type' => 'supt',
        'card' => array(
            'number' => $card['number'],
            'exp_month' => $card['expiryMonth'],
            'exp_year' => $card['expiryYear'],
            'cvc' => $card['cvv'],
        ),
    );
    $url = 'https://cert.api2-c.heartlandportico.com/Hps.Exchange.PosGateway.Hpf.v1/api/token?api_key=' . $publicKey;
    $options = array(
        'http' => array(
            'header' => "Content-Type: application/json\r\n",
            'method' => 'POST',
            'content' => json_encode($payload),
        ),
    );
    $context = stream_context_create($options);
    $response = json_decode(file_get_contents($url, false, $context));
    if (!$response || isset($response->error)) {
        $this->fail('no single-use token obtained');
    }
    return $response->token_value;
}

function getVisaCard()
{
    return array(
        'number' => '4012002000060016',
        'expiryMonth' => 12,
        'expiryYear' => 2025,
        'cvv' => 123,
    );
}

var_dump(getToken(getVisaCard(), $publicKey));
