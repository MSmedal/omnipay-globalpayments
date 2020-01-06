<?php
namespace Omnipay\GlobalPayments;

use Omnipay\Omnipay;
use Omnipay\Tests\TestCase;

/**
 * Integration tests for the  Gateway. These tests make real requests to Heartland sandbox environment using Certification MID 777700959162
 */
class HeartlandEcommerceTest extends TestCase
{
    /** @var Gateway */
    protected $gateway;
    /** @var string */
    protected $publicKey = 'pkapi_cert_EuYk7ncMQaZLDLC0Gg';

    public function setUp()
    {
        parent::setUp();
        $secretAPIKey = 'skapi_cert_MXvdAQB61V4AkyM-x3EJuY6hkEaCzaMimTWav7mVfQ';
        if ($secretAPIKey) {
            $this->gateway = Omnipay::create('GlobalPayments\Heartland');
            $this->gateway->setSecretApiKey($secretAPIKey);
        }
    }
    public function test01PurchaseVisaManualEntry()
    {
        $request = $this->gateway->purchase(array(
            'card' => $this->getVisaCard(),
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
            'card' => $this->getMastercardCard(),
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
    public function test03PurchaseDiscoverManualEntry()
    {
        $request = $this->gateway->purchase(array(
            'card' => $this->getDiscoverCard(),
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
    public function test04PurchaseAmexManualEntry()
    {
        $request = $this->gateway->purchase(array(
            'card' => $this->getAmexCard(),
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
    public function test05PurchaseVisaSingleUseToken()
    {
        $request = $this->gateway->purchase(array(
            'token' => $this->getToken($this->getVisaCard()),
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
    public function test06PurchaseMastercardSingleUseToken()
    {
        $request = $this->gateway->purchase(array(
            'token' => $this->getToken($this->getMastercardCard()),
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
    public function test07PurchaseDiscoverSingleUseToken()
    {
        $request = $this->gateway->purchase(array(
            'token' => $this->getToken($this->getDiscoverCard()),
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
    public function test08PurchaseAmexSingleUseToken()
    {
        $request = $this->gateway->purchase(array(
            'token' => $this->getToken($this->getAmexCard()),
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
    public function test09AuthAndCaputreVisaManualEntry()
    {
        // Authorize
        $request = $this->gateway->authorize(array(
            'card' => $this->getVisaCard(),
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
    public function test10AuthAndCaputreMastercardManualEntry()
    {
        // Authorize
        $request = $this->gateway->authorize(array(
            'card' => $this->getMastercardCard(),
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
            'card' => $this->getDiscoverCard(),
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
            'card' => $this->getAmexCard(),
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
    public function test13Refund()
    {
        // Purchase
        $request = $this->gateway->purchase(array(
            'card' => $this->getAmexCard(),
            'currency' => 'USD',
            'amount' => $this->randAmount()
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
            'card' => $this->getAmexCard(),
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
    public function test15VisaCreateCard()
    {
        // Requires Heartland Multi-Use Tokens be enabled
        $request = $this->gateway->createCard(array(
            'card' => $this->getVisaCard()
        ));
        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());
        $this->assertNotNull($response->getCardReference());
        $this->assertNotEmpty($response->getCardReference());
    }
    public function test16AmexCreateCard()
    {
        // Requires Heartland Multi-Use Tokens be enabled
        // Amex will require an address to create a Card Reference (multi-use token)
        $request = $this->gateway->createCard(array(
            'card' => array_merge($this->getAmexCard(), $this->getAddress())
        ));
        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());
        $this->assertNotNull($response->getCardReference());
        $this->assertNotEmpty($response->getCardReference());
    }
    public function test17DeleteMastercardCardReference() {
        // Requires Heartland Multi-Use Tokens be enabled
        $request = $this->gateway->createCard(array(
            'card' => $this->getMastercardCard()
        ));
        $response = $request->send();
        
        $cardReference = $response->getCardReference();

        $request = $this->gateway->deleteCard(array(
            'cardReference' => $cardReference
        ));
        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
    }
    public function test18UpdateDiscoverCardReference() {
        // Requires Heartland Multi-Use Tokens be enabled
        $request = $this->gateway->createCard(array(
            'card' => $this->getDiscoverCard()
        ));
        $response = $request->send();
        
        $cardReference = $response->getCardReference();

        $request = $this->gateway->updateCard(array(
            'card' => array(
                'expiryYear' => '2020',
                'expiryMonth' => '1'
            ),
            'cardReference' => $cardReference
        ));
        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isDecline());
    }
    public function test19ACHPurchase()
    {
        // Requires Heartland ACH be enabled
        $request = $this->gateway->purchase(array(
            'check' => $this->getPersonalCheck(),
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
    public function test20CreateCustomer()
    {
        // Requires Payplan to be enabled
        $request = $this->gateway->createCustomer(array(
            'company' => 'Heartland Payment Systems',
            'country' => 'USA'
        ));
        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertNotNull($response->getCustomerReference());
    }

    protected function randAmount()
    {
        return rand(1, 9) . "." . rand(1, 99);
    }

    protected function getAmexCard()
    {
        return array(
            'number' => '372700699251018',
            'expiryMonth' => 12,
            'expiryYear' => 2025,
            'cvv' => 1234,
        );
    }
    protected function getDiscoverCard()
    {
        return array(
            'number' => '6011000990156527',
            'expiryMonth' => 12,
            'expiryYear' => 2025,
            'cvv' => 123,
        );
    }
    protected function getJcbCard()
    {
        return array(
            'number' => '3566007770007321',
            'expiryMonth' => 12,
            'expiryYear' => 2025,
            'cvv' => 123,
        );
    }
    protected function getMastercardCard()
    {
        return array(
            'number' => '5473500000000014',
            'expiryMonth' => 12,
            'expiryYear' => 2025,
            'cvv' => 123,
        );
    }
    protected function getVisaCard()
    {
        return array(
            'number' => '4012002000060016',
            'expiryMonth' => 12,
            'expiryYear' => 2025,
            'cvv' => 123,
        );
    }
    protected function getPersonalCheck()
    {
        return array(
            'accountNumber' => '1357902468',
            'routingNumber' => '122000030',
            'accountType' => 'checking',
            'checkType' => 'personal',
            'secCode' => 'ppd',
            'checkHolderName' => 'Tony Smedal'
        );
    }
    protected function getAddress()
    {
        return array(
            'billingAddress1'       => '1 Heartland Way',
            'billingCountry'        => 'USA',
            'billingCity'           => 'Jeffersonville',
            'billingPostcode'       => '47130',
            'billingState'          => 'IN'
        );
    }
    protected function getToken(array $card)
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
        $url = 'https://cert.api2-c.heartlandportico.com/Hps.Exchange.PosGateway.Hpf.v1/api/token?api_key=' . $this->publicKey;
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
}
