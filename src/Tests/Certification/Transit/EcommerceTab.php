<?php
namespace Omnipay\GlobalPayments;

use GlobalPayments\Api\Entities\Enums\StoredCredentialInitiator;
use GlobalPayments\Api\Entities\StoredCredential;
use GlobalPayments\Api\PaymentMethods\CreditCardData;
use Omnipay\Omnipay;
use Omnipay\Tests\TestCase;

/**
 * Integration tests for the Transit Gateway. These tests make real requests to Heartland sandbox environment.
 */
class EcommerceTab extends TestCase
{
    private static $partialVoidTarget;
    private static $fullVoidTarget;
    private static $visaReference;
    private static $mastercardReference;
    private static $refundTarget;

    public function setUp()
    {
        parent::setUp();
        $transactionKey = 'DPJLWWAD1MOAX8XPCHZAXP15U0UME5U0';
        $deviceId = '88500000322601';
        $merchantId = '885000003226';
        $userName = 'TA5748226';
        if ($deviceId) {
            $this->gateway = Omnipay::create('GlobalPayments\Transit');
            $this->gateway->setDeviceId($deviceId);
            $this->gateway->setMerchantId($merchantId);
            $this->gateway->setUserName($userName);
            $this->gateway->setTransactionKey($transactionKey);
        }
    }
    public function test01()
    {
        $request = $this->gateway->purchase(array(
            'card' => $this->getMasterCard2Bin(),
            'currency' => 'USD',
            'amount' => 11.10
        ));
        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
    }
    public function test02()
    {
        $request = $this->gateway->purchase(array(
            'card' => $this->getDiscover(),
            'currency' => 'USD',
            'amount' => '12.00'
        ));
        $response = $request->send();
        $this->assertTrue($response->isSuccessful());
    }
    public function test03()
    {
        $request = $this->gateway->purchase(array(
            'card' => $this->getMasterCard(),
            'currency' => 'USD',
            'amount' => '15.00'
        ));
        $response = $request->send();
        static::$partialVoidTarget = $response->getTransactionReference();
        $this->assertTrue($response->isSuccessful());
    }
    public function test04()
    {
        $request = $this->gateway->purchase(array(
            'card' => $this->getMasterCard(),
            'currency' => 'USD',
            'amount' => 34.13
        ));
        $response = $request->send();
        $this->assertTrue($response->isSuccessful());
    }
    public function test05()
    {
        $request = $this->gateway->purchase(array(
            'card' => $this->getJcb(),
            'currency' => 'USD',
            'amount' => '13.00'
        ));
        $response = $request->send();
        $this->assertTrue($response->isSuccessful());
    }

    public function test06()
    {
        $card = $this->getAmex();
        unset($card['cvv']); // test specifies not to send

        $request = $this->gateway->purchase(array(
            'card' => $card,
            'currency' => 'USD',
            'amount' => 13.50
        ));
        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
    }

    public function test07()
    {
        $request = $this->gateway->purchase(array(
            'card' => $this->getVisa(),
            'currency' => 'USD',
            'amount' => 32.49
        ));
        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
    }

    public function test08()
    {
        $request = $this->gateway->purchase(array(
            'card' => $this->getDiscoverCup(),
            'currency' => 'USD',
            'amount' => '10.00'
        ));
        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
    }

    public function test09()
    {
        $request = $this->gateway->purchase(array(
            'card' => $this->getVisa(),
            'currency' => 'USD',
            'amount' => 11.12
        ));

        $response = $request->send();
        static::$refundTarget = $response->getTransactionReference();

        $this->assertTrue($response->isSuccessful());
    }

    public function test10()
    {
        $request = $this->gateway->purchase(array(
            'card' => $this->getAmex(),
            'currency' => 'USD',
            'amount' => '4.00'
        ));
        $response = $request->send();
        static::$fullVoidTarget = $response->getTransactionReference();

        $this->assertTrue($response->isSuccessful());
    }

    public function testCardAuthentication01()
    {
        $request = $this->gateway->createCard(array(
            'card' => $this->getVisa()
        ));

        $response = $request->send();
        static::$visaReference = $response->getCardReference();

        $this->assertTrue($response->isSuccessful());
    }

    public function testCardAuthentication02()
    {
        $request = $this->gateway->createCard(array(
            'card' => $this->getMasterCard()
        ));
        $response = $request->send();
        static::$mastercardReference = $response->getCardReference();

        $this->assertTrue($response->isSuccessful());
    }

    public function testCardAuthentication03()
    {
        $request = $this->gateway->createCard(array(
            'card' => $this->getAmex()
        ));
        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
    }

    public function test11()
    {
        $request = $this->gateway->void(array(
            'transactionReference' => static::$partialVoidTarget
        ));
        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
    }

    public function test12()
    {
        $request = $this->gateway->void(array(
            'transactionReference' => static::$fullVoidTarget
        ));
        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
    }

    // public function consumerInitiated01()
    // {
    //     $request = $this->gateway->purchase(array(
    //         'card' => static::$visaReference,
    //         'currency' => 'USD',
    //         'amount' => 11.12
    //     ));
    //     $response = $request->send();

    //     $this->assertTrue($response->isSuccessful());
    // }

    // public function consumerInitiated02()
    // {
    //     $request = $this->gateway->purchase(array(
    //         'card' => static::$mastercardReference,
    //         'currency' => 'USD',
    //         'amount' => 11.12
    //     ));
    //     $response = $request->send();

    //     $this->assertTrue($response->isSuccessful());
    // }

    public function testTempSaleVisaCIT () {
        $storedcreds = new StoredCredential;
        $storedcreds->initiator = StoredCredentialInitiator::MERCHANT;

        // 'number' => '4012000098765439',
        // 'expiryMonth' => 12,
        // 'expiryYear' => 2025,
        // 'cvv' => 999,

        $card = new CreditCardData();
        $card->token = static::$visaReference;
        $card->expMonth = $this->getVisa()['expiryMonth'];
        $card->expYear = $this->getVisa()['expiryYear'];
        $card->cvn = $this->getVisa()['cvv'];

        $response = $card->charge(14.00)
            ->withCurrency('USD')
            ->withClientTransactionId('test30_' . time())
            ->withStoredCredential($storedcreds)
            ->execute();

        $this->assertEquals('00', $response->responseCode);
    }

    public function testTempSaleNonVisaCIT () {
        $storedcreds = new StoredCredential;
        $storedcreds->initiator = StoredCredentialInitiator::MERCHANT;

        $card = new CreditCardData();
        $card->number = static::$mastercardReference;
        $card->expMonth = $this->getMasterCard()['expiryMonth'];
        $card->expYear = $this->getMasterCard()['expiryYear'];
        $card->cvn = $this->getMasterCard()['cvv'];

        // 'number' => '5146315000000055',
        // 'expiryMonth' => 12,
        // 'expiryYear' => 2025,
        // 'cvv' => 998,

        $response = $card->charge(15.00)
            ->withCurrency('USD')
            ->withClientTransactionId('test31_' . time())
            ->withStoredCredential($storedcreds)
            ->execute();

        $this->assertEquals('00', $response->responseCode);
    }

    public function testReturn01()
    {
        $request = $this->gateway->refund(array(
            'transactionReference' => static::$refundTarget,
            'currency' => 'USD',
        ));
        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
    }

    private function getMasterCard2Bin() {
        $card = array(
            'number' => '2223000048400011',
            'expiryMonth' => 12,
            'expiryYear' => 2025,
            'cvv' => 998,
        );

        return array_merge($card, $this->avsData);
    }

    private function getDiscover() {
        $card = array(
            'number' => '6011000993026909',
            'expiryMonth' => 12,
            'expiryYear' => 2025,
            'cvv' => 996,
        );

        return array_merge($card, $this->avsData);
    }

    private function getMasterCard() {
        $card = array(
            'number' => '5146315000000055',
            'expiryMonth' => 12,
            'expiryYear' => 2025,
            'cvv' => 998,
        );

        return array_merge($card, $this->avsData);
    }

    private function getJcb() {
        $card = array(
            'number' => '3530142019945859',
            'expiryMonth' => 12,
            'expiryYear' => 2025,
            'cvv' => 996,
        );

        return array_merge($card, $this->avsData);
    }

    private function getAmex() {
        $card = array(
            'number' => '371449635392376',
            'expiryMonth' => 12,
            'expiryYear' => 2025,
            'cvv' => 9997,
        );

        return array_merge($card, $this->avsData);
    }

    private function getVisa() {
        $card = array(
            'number' => '4012000098765439',
            'expiryMonth' => 12,
            'expiryYear' => 2025,
            'cvv' => 999,
        );

        return array_merge($card, $this->avsData);
    }

    private function getDiscoverCup() {
        $card = array(
            'number' => '6282000123842342',
            'expiryMonth' => 12,
            'expiryYear' => 2025,
            'cvv' => 996,
        );

        return array_merge($card, $this->avsData);
    }

    private $avsData = array(
            'billingAddress1' => '8320',
            'billingPostcode' => '85284'
    );
}
