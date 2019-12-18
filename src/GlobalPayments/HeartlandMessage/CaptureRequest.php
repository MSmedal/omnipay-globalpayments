<?php

namespace Omnipay\GlobalPayments\HeartlandMessage;

use GlobalPayments\Api\Entities\Transaction;

/**
 * Heartland Authorize Request
 * 
 * Example transaction that utilizes all supported fields:
 *  
 * <code>
 * 
 * $gateway = Omnipay::create('GlobalPayments\Heartland');
 * $gateway->setSecretApiKey('skapi_cert_MXvdAQB61V4AkyM-x3EJuY6hkEaCzaMimTWav7mVfQ');
 * 
 * $response = $gateway->capture(
 *     [
 *         'transactionReference' => // transactionReference from a previus authorizationRequest goes here
 *         'amount'        => '1.00', // required
 *         'description'   => 'Test Capture using Capture.php in scratch folder.'
 *     ]
 * )->send();
 * 
 * // Heartland doesn't use a redirect, so isSuccessful() and isDecline() are used to evaluate result and isRedirect() is not used. Response.php holds all of these supported methods
 * if ($response->isSuccessful()) {
 *     echo $response->getTransactionReference();
 * } elseif ($response->isDecline()) {
 *     echo $response>getMessage();
 * }
 * 
 * </code>
 */

class CaptureRequest extends AbstractPorticoRequest
{
    public function runHPSTrans($data)
    {
        $this->setGoodResponseCodes(array('00'));

        return Transaction::fromId($data['transactionReference'])
            ->capture($data['amount'])
            ->execute();
    }
}
