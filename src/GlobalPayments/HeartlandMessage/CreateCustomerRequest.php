<?php

namespace Omnipay\GlobalPayments\HeartlandMessage;

use Exception;
use GlobalPayments\Api\Entities\Address;
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
 *     'firstName'         => 'Tony', // required if company isn't used
 *     'lastName'          => 'Smedal', // required if company isn't used
 *     'company'           => 'Heartland Payment Systems', // required if firstname & lastname isn't used
 *     'billingAddress1'   => '1 Heartland Way', // optional
 *     'billingCity'       => 'Jeffersonville', // optional
 *     'billingPostcode'   => '47130', // optional
 *     'billingState'      => 'IN', // optional
 *     'billingCountry'    => 'USA', // optional
 *     'email'             => 'mark.smedal@e-hps.com', // optional
 *     'billingPhone'      => '5026405620' // optional
 * ];
 * 
 * $response = $gateway->createCustomer(
 *     [
 *         'customer' => $formData
 *     ]
 * )->send();
 * 
 * // Heartland doesn't use a redirect, so isSuccessful() and isDecline() are used to evaluate result and isRedirect() is not used. Response.php holds all of these supported methods
 * if ($response->isSuccessful()) {
 *     echo $response->getCustomerReference();
 * } elseif ($response->isDecline()) {
 *     echo $response>getMessage();
 * }
 * 
 * </code>
 */

class CreateCustomerRequest extends AbstractPorticoRequest
{
    public function runHPSTrans($data)
    {
        // new GlobalPayments credit card object
        $newCustomer = new Customer();

        if (isset($data['customerReference'])) {
            $newCustomer->id = $data['customerReference'];
        } else {
            $newCustomer->id = time() . "__Omnipay__" . rand(100, 999); // generate this automatically not provided
        }
        if (isset($data['firstName'])) $newCustomer->firstName          = $data['firstName'];
        if (isset($data['lastName'])) $newCustomer->lastName            = $data['lastName'];
        if (isset($data['company'])) $newCustomer->company              = $data['company'];

        // new GlobalPayments address object
        $address = new Address();
        if (isset($data['billingAddress1'])) $address->streetAddress1   = $data['billingAddress1'];
        if (isset($data['billingAddress2'])) $address->streetAddress2   = $data['billingAddress2'];
        if (isset($data['billingCity'])) $address->city                 = $data['billingCity'];
        if (isset($data['billingState'])) $address->state               = $data['billingState'];
        if (isset($data['billingCountry'])) $address->country           = $data['billingCountry'];
        if (isset($data['billingPostcode'])) $address->postalCode       = $data['billingPostcode'];

        $newCustomer->address = $address;

        try {
            return $newCustomer->create();
        } catch (Exception $e) {
            return false;
        }
    }
}
