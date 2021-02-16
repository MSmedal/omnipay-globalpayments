<?php

namespace Omnipay\GlobalPayments\Message\HeartlandMessage;

use Exception;
use GlobalPayments\Api\PaymentMethods\CreditCardData;
use GlobalPayments\Api\Entities\Customer;

/**
 * Heartland CreateCustomer Request
 * 
 * Example that utilizes all supported fields:
 *  
 * <code>
 * 
 * $gateway = Omnipay::create('GlobalPayments\Heartland');
 * $gateway->setSecretApiKey('skapi_cert_MXvdAQB61V4AkyM-x3EJuY6hkEaCzaMimTWav7mVfQ');
 * 
 * // Example form data
 * $formData = [
 *     'number'            => '5454545454545454',
 *     'expiryMonth'       => '12',
 *     'expiryYear'        => '2025',
 *     'cvv'               => '123'
 * ];
 * 
 * $response = $gateway->createPaymentMethod(
 *     [
 *         'card'              => $formData,
 *         // 'token'             => 'tokentoken', // if using a single-use token; multi-use tokens aren't currently supported
 *         'customerReference' => 1578420678,
 *         'paymentMethodReference' => 'test'
 *     ]
 * )->send();
 * 
 * // Heartland doesn't use a redirect, so isSuccessful() and isDecline() are used to evaluate result and isRedirect() is not used. Response.php holds all of these supported methods
 * if ($response->isSuccessful()) {
 *     echo $response->getPaymentMethodReference();
 * } elseif ($response->isDecline()) {
 *     echo $response>getMessage();
 * }
 * 
 * </code>
 */

class CreatePaymentMethodRequest extends AbstractHeartlandRequest
{
    public function runTrans($data)
    {
        // obtain customer object from Heartland
        $customer = Customer::find((int) $this->getCustomerReference());

        // new GlobalPayments credit card object
        $newPaymentMethod = new CreditCardData();

        if ($this->getToken() != null && $this->getToken() != "") {
            $newPaymentMethod->token = $this->getToken();
        }
        // token and card info can be submitted simultaneously; discrete card info values (below vars) will take precedence over token-contained card info
        if (isset($data['card']['number'])) { $newPaymentMethod->number           = $data['card']['number'];
        }
        if (isset($data['card']['expiryMonth'])) { $newPaymentMethod->expMonth    = $data['card']['expiryMonth'];
        }
        if (isset($data['card']['expiryYear'])) { $newPaymentMethod->expYear      = $data['card']['expiryYear'];
        }
        if (isset($data['card']['cvv'])) { $newPaymentMethod->cvn                 = $data['card']['cvv'];
        }

        if ($this->getPaymentMethodReference()) {
            $paymentMethodId = $this->getPaymentMethodReference();
        } else {
            $paymentMethodId = time() . "__PaymentMethod"; // generate this automatically not provided
        }

        try {
            return $customer->addPaymentMethod(
                $paymentMethodId,
                $newPaymentMethod
            );
        } catch (Exception $e) {
            return false;
        }
    }
}
