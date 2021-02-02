<?php
namespace Omnipay\GlobalPayments;

use GlobalPayments\Api\Entities\Enums\CardType;
use Omnipay\Omnipay;
use Omnipay\Tests\TestCase;

/**
 * Integration tests for the Transit Gateway. These tests make real requests to Heartland sandbox environment.
 */
class TransitEcommerceTest extends TestCase
{
    protected $gateway;

    /**
     * Using these tokens in place of legit TSEP calls since generating TSEP tokens server-side requires considerable work.
     * I might re-work this in the future.
     */
    private $tsepMasterCard2Bin = '6GrNPfmCCjdq0011';
    private $tsepDiscover = 'LcsepTJXhdK86909';
    private $tsepMasterCard = 'Ch0WiL69BQ7Q0055';
    private $tsepJcb = '4sZHIIMj6oKS5859';
    private $tsepAmex = 'oHeftkZLJkh2376';
    private $tsepVisa = 'IYLPXjKmrTpm5439';
    private $tsepDiscuverCup = 'uu3pWBH1vhf62342';
    private $tsepDiners = 'jnaYZrd7vsDW0018';

    public function setUp()
    {
        parent::setUp();

        $transactionKey = 'DPJLWWAD1MOAX8XPCHZAXP15U0UME5U0';
        $deviceId = '88500000322601';
        $merchantId = '885000003226';
        $userName = 'TA5748226';

        $this->gateway = Omnipay::create('GlobalPayments\Transit');
        $this->gateway->setDeviceId($deviceId);
        $this->gateway->setMerchantId($merchantId);
        $this->gateway->setUserName($userName);
        $this->gateway->setTransactionKey($transactionKey);
    }

    /**
     * Basic purchase attempts using raw card numbers
     */

    public function test01PurchaseVisaManualEntry()
    {
        $request = $this->gateway->purchase(array(
            'card' => $this->getVisa(),
            'currency' => 'USD',
            'amount' => $this->randAmount()
        ));

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());
    }

    public function test02PurchaseMastercardManualEntry()
    {
        $request = $this->gateway->purchase(array(
            'card' => $this->getMasterCard(),
            'currency' => 'USD',
            'amount' => $this->randAmount()
        ));

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());
    }

    public function test03PurchaseMastercardBin2ManualEntry()
    {
        $request = $this->gateway->purchase(array(
            'card' => $this->getMasterCard2Bin(),
            'currency' => 'USD',
            'amount' => $this->randAmount()
        ));

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());
    }

    public function test04PurchaseDiscoverManualEntry()
    {
        $request = $this->gateway->purchase(array(
            'card' => $this->getDiscover(),
            'currency' => 'USD',
            'amount' => $this->randAmount()
        ));

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());
    }

    public function test05PurchaseDiscoverCupManualEntry()
    {
        $request = $this->gateway->purchase(array(
            'card' => $this->getDiscoverCup(),
            'currency' => 'USD',
            'amount' => $this->randAmount()
        ));

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());
    }

    public function test06PurchaseAmexManualEntry()
    {
        $request = $this->gateway->purchase(array(
            'card' => $this->getAmex(),
            'currency' => 'USD',
            'amount' => $this->randAmount()
        ));

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());
    }

    public function test07PurchaseJcbManualEntry()
    {
        $request = $this->gateway->purchase(array(
            'card' => $this->getJcb(),
            'currency' => 'USD',
            'amount' => $this->randAmount()
        ));

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());
    }

    public function test08PurchaseDinersManualEntry()
    {
        $request = $this->gateway->purchase(array(
            'card' => $this->getDiners(),
            'currency' => 'USD',
            'amount' => $this->randAmount()
        ));

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());
    }

    /**
     * Purchase attempts using TSEP
     */

    public function test09PurchaseVisaToken()
    {
        $request = $this->gateway->purchase(array(
            'token' => $this->tsepVisa,
            'card' => $this->getVisaTsep(),
            'currency' => 'USD',
            'amount' => $this->randAmount()
        ));

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());
    }

    public function test10PurchaseMastercardToken()
    {
        $request = $this->gateway->purchase(array(
            'token' => $this->tsepMasterCard,
            'card' => $this->getMasterCardTsep(),
            'currency' => 'USD',
            'amount' => $this->randAmount()
        ));

        $response = $request->send();
        
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());
    }

    public function test11PurchaseMastercardBin2Token()
    {
        $request = $this->gateway->purchase(array(
            'token' => $this->tsepMasterCard2Bin,
            'card' => $this->getMasterCard2BinTsep(),
            'currency' => 'USD',
            'amount' => $this->randAmount()
        ));

        $response = $request->send();
        
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());
    }

    public function test12PurchaseDiscoverToken()
    {
        $request = $this->gateway->purchase(array(
            'token' => $this->tsepDiscover,
            'card' => $this->getDiscoverTsep(),
            'currency' => 'USD',
            'amount' => $this->randAmount()
        ));

        $response = $request->send();
        
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());
    }

    public function test13PurchaseDiscoverCupToken()
    {
        $request = $this->gateway->purchase(array(
            'token' => $this->tsepDiscuverCup,
            'card' => $this->getDiscoverCupTsep(),
            'currency' => 'USD',
            'amount' => $this->randAmount()
        ));

        $response = $request->send();
        
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());
    }

    public function test14PurchaseAmexToken()
    {
        $request = $this->gateway->purchase(array(
            'token' => $this->tsepAmex,
            'card' => $this->getAmexTsep(),
            'currency' => 'USD',
            'amount' => $this->randAmount()
        ));

        $response = $request->send();
        
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());
    }

    public function test15PurchaseJcbToken()
    {
        $request = $this->gateway->purchase(array(
            'token' => $this->tsepJcb,
            'card' => $this->getJcbTsep(),
            'currency' => 'USD',
            'amount' => $this->randAmount()
        ));

        $response = $request->send();
        
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());
    }

    public function test16PurchaseDinersToken()
    {
        $request = $this->gateway->purchase(array(
            'token' => $this->tsepDiners,
            'card' => $this->getDinersTsep(),
            'currency' => 'USD',
            'amount' => $this->randAmount()
        ));

        $response = $request->send();
        
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());
    }

    /**
     * Test auth-only and subsequent capture
     */

    public function test17AuthAndCapture()
    {
        // Authorize
        $request = $this->gateway->authorize(array(
            'card' => $this->getVisa(),
            'currency' => 'USD',
            'amount' => $this->randAmount()
        ));

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());

        // Capture
        $request = $this->gateway->capture(array(
            'transactionReference' => $response->getTransactionReference()
        ));

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());
    }

    public function test18AuthAndPartialCapture()
    {
        // Authorize
        $request = $this->gateway->authorize(array(
            'card' => $this->getVisa(),
            'currency' => 'USD',
            'amount' => 100.00
        ));

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());

        // Capture
        $request = $this->gateway->capture(array(
            'transactionReference' => $response->getTransactionReference(),
            'amount' => 50.00
        ));

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());
    }

    public function test19AuthAndNoCapture()
    {
        // Authorize
        $request = $this->gateway->authorize(array(
            'card' => $this->getVisa(),
            'currency' => 'USD',
            'amount' => $this->randAmount()
        ));

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());
    }

    public function test20RefundFull()
    {
        $purchaseAmount = $this->randAmount();

        // Purchase
        $request = $this->gateway->purchase(array(
            'card' => $this->getVisa(),
            'currency' => 'USD',
            'amount' => $purchaseAmount,
        ));

        $response = $request->send();
        $purchaseTransactionReference = $response->getTransactionReference();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());

        // Refund
        $request = $this->gateway->refund(array(
            'transactionReference' => $purchaseTransactionReference,
        ));

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());
    }

    public function test21RefundPartial()
    {
        // Purchase
        $request = $this->gateway->purchase(array(
            'card' => $this->getVisa(),
            'currency' => 'USD',
            'amount' => 99.99,
        ));

        $response = $request->send();
        $purchaseTransactionReference = $response->getTransactionReference();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());

        // Refund
        $request = $this->gateway->refund(array(
            'transactionReference' => $purchaseTransactionReference,
            'amount' => 50.00
        ));

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());
    }

    public function test10AuthAndCaputreMastercardManualEntry()
    {
        // Authorize
        $request = $this->gateway->authorize(array(
            'card' => $this->getMasterCard(),
            'currency' => 'USD',
            'amount' => $this->randAmount()
        ));
        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());

        // Capture
        $request = $this->gateway->capture(array(
            'transactionReference' => $response->getTransactionReference()
        ));
        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());
    }
    public function test11AuthAndCaputreDiscoverManualEntry()
    {
        // Authorize
        $request = $this->gateway->authorize(array(
            'card' => $this->getDiscover(),
            'currency' => 'USD',
            'amount' => $this->randAmount()
        ));
        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());

        // Capture
        $request = $this->gateway->capture(array(
            'transactionReference' => $response->getTransactionReference()
        ));
        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());
    }
    public function test12AuthAndCaputreAmexManualEntry()
    {
        // Authorize
        $request = $this->gateway->authorize(array(
            'card' => $this->getAmex(),
            'currency' => 'USD',
            'amount' => $this->randAmount()
        ));
        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());

        // Capture
        $request = $this->gateway->capture(array(
            'transactionReference' => $response->getTransactionReference()
        ));
        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());
    }
    public function test13PartialRefund()
    {
        // Purchase
        $request = $this->gateway->purchase(array(
            'card' => $this->getAmex(),
            'currency' => 'USD',
            'amount' => '2.00',
        ));
        $response = $request->send();

        // Refund
        $request = $this->gateway->refund(array(
            'transactionReference' => $response->getTransactionReference(),
            'currency' => 'USD',
            'amount' => '1.00'
        ));
        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());
    }
    public function test14Void()
    {
        // Purchase
        $request = $this->gateway->authorize(array(
            'card' => $this->getAmex(),
            'currency' => 'USD',
            'amount' => $this->randAmount()
        ));
        $response = $request->send();

        // Void
        $request = $this->gateway->void(array(
            'transactionReference' => $response->getTransactionReference()
        ));
        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());
    }

    /**
     * 
     */
    protected function randAmount()
    {
        $numstring = '';
        $digits = rand(0, 4);
        
        for ($x = 0; $x < $digits; $x++)
        {
            $numstring = $numstring . (string) rand(0, 9);
        }

        return floatval($numstring . (string) number_format('.' . rand(0, 99), 2));
    }

    private function getMasterCard2Bin() {
        $card = array(
            'number' => '2223000048400011',
            'expiryMonth' => 12,
            'expiryYear' => 2025,
            'cvv' => 998,
            'type' => CardType::MASTERCARD
        );

        return array_merge($card, $this->allData);
    }

    private function getDiscover() {
        $card = array(
            'number' => '6011000993026909',
            'expiryMonth' => 12,
            'expiryYear' => 2025,
            'cvv' => 996,
            'type' => CardType::DISCOVER
        );

        return new CreditCard(array_merge($card, $this->avsData));
    }

    private function getMasterCard() {
        $card = array(
            'number' => '5146315000000055',
            'expiryMonth' => 12,
            'expiryYear' => 2025,
            'cvv' => 998,
            'type' => CardType::MASTERCARD
        );

        return new CreditCard(array_merge($card, $this->avsData));
    }

    private function getJcb() {
        $card = array(
            'number' => '3530142019945859',
            'expiryMonth' => 12,
            'expiryYear' => 2025,
            'cvv' => 996,
            'type' => CardType::JCB
        );

        return new CreditCard(array_merge($card, $this->avsData));
    }

    private function getAmex() {
        $card = array(
            'number' => '371449635392376',
            'expiryMonth' => 12,
            'expiryYear' => 2025,
            'cvv' => 9997,
            'type' => CardType::AMEX
        );

        return new CreditCard(array_merge($card, $this->avsData));
    }

    private function getVisa() {
        $card = array(
            'number' => '4012000098765439',
            'expiryMonth' => 12,
            'expiryYear' => 2025,
            'cvv' => 999,
            'type' => CardType::VISA
        );

        return new CreditCard(array_merge($card, $this->avsData));
    }

    private function getDiscoverCup() {
        $card = array(
            'number' => '6282000123842342',
            'expiryMonth' => 12,
            'expiryYear' => 2025,
            'cvv' => 996,
            'type' => CardType::DISCOVER
        );

        return new CreditCard(array_merge($card, $this->avsData));
    }

    private function getDiners() {
        $card = array(
            'number' => '3055155515160018',
            'expiryMonth' => 12,
            'expiryYear' => 2025,
            'cvv' => 996,
            'type' => CardType::DINERS
        );

        return new CreditCard(array_merge($card, $this->avsData));
    }

    private function getMasterCard2BinTsep() {
        $card = array(
            // 'number' => '2223000048400011',
            'expiryMonth' => 12,
            'expiryYear' => 2025,
            'cvv' => 998,
            'type' => CardType::MASTERCARD
        );

        return array_merge($card, $this->allData);
    }

    private function getDiscoverTsep() {
        $card = array(
            // 'number' => '6011000993026909',
            'expiryMonth' => 12,
            'expiryYear' => 2025,
            'cvv' => 996,
            'type' => CardType::DISCOVER
        );

        return new CreditCard(array_merge($card, $this->avsData));
    }

    private function getMasterCardTsep() {
        $card = array(
            // 'number' => '5146315000000055',
            'expiryMonth' => 12,
            'expiryYear' => 2025,
            'cvv' => 998,
            'type' => CardType::MASTERCARD
        );

        return new CreditCard(array_merge($card, $this->avsData));
    }

    private function getJcbTsep() {
        $card = array(
            // 'number' => '3530142019945859',
            'expiryMonth' => 12,
            'expiryYear' => 2025,
            'cvv' => 996,
            'type' => CardType::JCB
        );

        return new CreditCard(array_merge($card, $this->avsData));
    }

    private function getAmexTsep() {
        $card = array(
            // 'number' => '371449635392376',
            'expiryMonth' => 12,
            'expiryYear' => 2025,
            'cvv' => 9997,
            'type' => CardType::AMEX
        );

        return new CreditCard(array_merge($card, $this->avsData));
    }

    private function getVisaTsep() {
        $card = array(
            // 'number' => '4012000098765439',
            'expiryMonth' => 12,
            'expiryYear' => 2025,
            'cvv' => 999,
            'type' => CardType::VISA
        );

        return new CreditCard(array_merge($card, $this->avsData));
    }

    private function getDiscoverCupTsep() {
        $card = array(
            // 'number' => '6282000123842342',
            'expiryMonth' => 12,
            'expiryYear' => 2025,
            'cvv' => 996,
            'type' => CardType::DISCOVER
        );

        return new CreditCard(array_merge($card, $this->avsData));
    }

    private function getDinersTsep() {
        $card = array(
            // 'number' => '3055155515160018',
            'expiryMonth' => 12,
            'expiryYear' => 2025,
            'cvv' => 996,
            'type' => CardType::DINERS
        );

        return new CreditCard(array_merge($card, $this->avsData));
    }

    private $avsData = array(
        'billingAddress1' => '8320',
        'billingPostcode' => '85284'
    );

    private $allData = array(
        'firstName'         => 'Tony',
        'lastName'          => 'Smedal',
        'billingAddress1'   => '8320 Some Road',
        'billingAddress2'   => 'Some Apt Number',
        'billingCity'       => 'Billing Town',
        'billingPostcode'   => 85284, // see if an int messes things up
        'billingState'      => 'Indiana',
        'billingCountry'    => 'USA',
        'billingPhone'      => 5556667777,
        'shippingAddress1'  => '1 Shipping Address',
        'shippingAddress2'  => 'Address Line 2',
        'shippingCity'      => 'Shipping City',
        'shippingPostcode'  => '47130',
        'shippingState'     => 'AK',
        'shippingCountry'   => 'United States of America',
        'shippingPhone'     => '(567) 678-7890',
        'company'           => 'Global Payments',
        'email'             => "mark.smedal@heartland.us",
    );

}
