<?php

namespace Omnipay\GlobalPayments;

use Symfony\Component\HttpFoundation\Request as HttpRequest;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /**
     * Create a new Request
     *
     * @param HttpRequest     $httpRequest A Symfony HTTP request object
     */
    
    /**
     * Get the gateway Secret API Key.
     *
     * Authentication is by means of a single secret API key set as
     * the secretApiKey parameter when creating the gateway object.
     *
     * @return string
     */
    public function getSecretApiKey()
    {
        return $this->getParameter('secretApiKey');
    }

    /**
     * Set the gateway Secret API Key.
     *
     * Authentication is by means of a single secret API key set as
     * the secretApiKey parameter when creating the gateway object.
     *
     * Heartland accounts have test-mode API keys as well as live-mode
     * API keys. These keys can be active at the same time. Data
     * created with test-mode credentials will never hit the credit
     * card networks and will never cost anyone money.
     *
     * Unlike some gateways, there is no test mode endpoint separate
     * to the live mode endpoint, the Heartland API endpoint is the same
     * for test and for live.
     *
     * Setting the testMode flag on this gateway has no effect.  To
     * use test mode just use your test mode API key.
     *
     * You can get your secret API key in heartland payments developer site
     *
     * @link https://developer.heartlandpaymentsystems.com/Account/KeysandCredentials
     *
     * @param string $value
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setSecretApiKey($value)
    {
        return $this->setParameter('secretApiKey', $value);
    }

    /**
     * Get the gateway Site Id.
     *
     * Authentication is by means of a single secret API key set as
     * the secretApiKey parameter when creating the gateway object.
     *
     * When you don't have a Secret API Key you can use your Site Id, Device Id, License Id
     * User name and Password details
     *
     * @return string
     */
    public function getSiteId()
    {
        return $this->getParameter('siteId');
    }

    /**
     * Set the gateway Site Id.
     *
     * Authentication is by means of a single secret API key set as
     * the secretApiKey parameter when creating the gateway object.
     *
     * When you don't have a Secret API Key you can use your Site Id, Device Id, License Id
     * User name and Password details
     *
     * @param string $value
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setSiteId($value)
    {
        return $this->setParameter('siteId', $value);
    }

    /**
     * Get the gateway Device Id.
     *
     * Authentication is by means of a single secret API key set as
     * the secretApiKey parameter when creating the gateway object.
     *
     * When you don't have a Secret API Key you can use your Site Id, Device Id, License Id
     * User name and Password details
     *
     * @return string
     */
    public function getDeviceId()
    {
        return $this->getParameter('deviceId');
    }

    /**
     * Set the gateway Device Id.
     *
     * Authentication is by means of a single secret API key set as
     * the secretApiKey parameter when creating the gateway object.
     *
     * When you don't have a Secret API Key you can use your Site Id, Device Id, License Id
     * User name and Password details
     *
     * @param string $value
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setDeviceId($value)
    {
        return $this->setParameter('deviceId', $value);
    }

    /**
     * Get the gateway License Id.
     *
     * Authentication is by means of a single secret API key set as
     * the secretApiKey parameter when creating the gateway object.
     *
     * When you don't have a Secret API Key you can use your Site Id, Device Id, License Id
     * User name and Password details
     *
     * @return string
     */
    public function getLicenseId()
    {
        return $this->getParameter('licenseId');
    }

    /**
     * Set the gateway License Id.
     *
     * Authentication is by means of a single secret API key set as
     * the secretApiKey parameter when creating the gateway object.
     *
     * When you don't have a Secret API Key you can use your Site Id, Device Id, License Id
     * User name and Password details
     *
     * @param string $value
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setLicenseId($value)
    {
        return $this->setParameter('licenseId', $value);
    }

    /**
     * Get the gateway username.
     *
     * Authentication is by means of a single secret API key set as
     * the secretApiKey parameter when creating the gateway object.
     *
     * When you don't have a Secret API Key you can use your Site Id, Device Id, License Id
     * User name and Password details
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->getParameter('username');
    }

    /**
     * Set the gateway username.
     *
     * Authentication is by means of a single secret API key set as
     * the secretApiKey parameter when creating the gateway object.
     *
     * When you don't have a Secret API Key you can use your Site Id, Device Id, License Id
     * User name and Password details
     *
     * @param string $value
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    /**
     * Get the gateway password.
     *
     * Authentication is by means of a single secret API key set as
     * the secretApiKey parameter when creating the gateway object.
     *
     * When you don't have a Secret API Key you can use your Site Id, Device Id, License Id
     * User name and Password details
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->getParameter('password');
    }

    /**
     * Get the gateway password.
     *
     * Authentication is by means of a single secret API key set as
     * the secretApiKey parameter when creating the gateway object.
     *
     * When you don't have a Secret API Key you can use your Site Id, Device Id, License Id
     * User name and Password details
     *
     * @param string $value
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    /**
     * Get the integration developer ID.
     *
     * The developer ID, in conjunction with the version number, is used to identify a
     * specific integration.
     *
     * @return string
     */
    public function getDeveloperId()
    {
        return $this->getParameter('developerId');
    }

    /**
     * Set the integration developer ID.
     *
     * The developer ID, in conjunction with the version number, is used to identify a
     * specific integration.
     *
     * @param string $value
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setDeveloperId($value)
    {
        return $this->setParameter('developerId', $value);
    }

    /**
     * Get the integration version number.
     *
     * The version number, in conjunction with the developer ID, is used to identify a
     * specific integration.
     *
     * @return string
     */
    public function getVersionNumber()
    {
        return $this->getParameter('versionNumber');
    }

    /**
     * Set the integration version number.
     *
     * The version number, in conjunction with the developer ID, is used to identify a
     * specific integration.
     *
     * @param string $value
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setVersionNumber($value)
    {
        return $this->setParameter('versionNumber', $value);
    }

    /**
     * Get the gateway site trace value.
     *
     * This can be used to debug issues with the gateway.
     *
     * @return string
     */
    public function getSiteTrace()
    {
        return $this->getParameter('siteTrace');
    }

    /**
     * Set the gateway site trace value.
     *
     * This can be used to debug issues with the gateway.
     *
     * @param string $value
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setSiteTrace($value)
    {
        return $this->setParameter('siteTrace', $value);
    }

    public function getCustomerReference()
    {
        return $this->getParameter('customerReference');
    }

    public function setCustomerReference($value)
    {
        return $this->setParameter('customerReference', $value);
    }

    public function getGoodReponseCodes()
    {
        return $this->getParameter('goodResponseCodes');
    }

    public function setGoodResponseCodes($value)
    {
        return $this->setParameter('goodResponseCodes', $value);
    }

    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    public function getTransactionKey()
    {
        return $this->getParameter('transactionKey');
    }

    public function setTransactionKey($value)
    {
        return $this->setParameter('transactionKey', $value);
    }

    public function getMerchantName()
    {
        return $this->getParameter('merchantName');
    }

    public function setMerchantName($value)
    {
        return $this->setParameter('merchantName', $value);
    }

    public function getMerchantSiteId()
    {
        return $this->getParameter('merchantSiteId');
    }

    public function setMerchantSiteId($value)
    {
        return $this->setParameter('merchantSiteId', $value);
    }
    
    public function getMerchantKey()
    {
        return $this->getParameter('merchantKey');
    }

    public function setMerchantKey($value)
    {
        return $this->setParameter('merchantKey', $value);
    }

    public function getCheck()
    {
        return $this->getParameter('check');
    }

    public function setCheck($value)
    {
        return $this->setParameter('check', $value);
    }

    public function getCustomer()
    {
        return $this->getParameter('customer');
    }

    public function setCustomer($value)
    {
        return $this->setParameter('customer', $value);
    }

    public function getPaymentMethodReference()
    {
        return $this->getParameter('paymentMethodReference');
    }

    public function setPaymentMethodReference($value)
    {
        return $this->setParameter('paymentMethodReference', $value);
    }

}
