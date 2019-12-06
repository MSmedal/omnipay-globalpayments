<?php

namespace Omnipay\Heartland\Message;

use Symfony\Component\HttpFoundation\Request as HttpRequest;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /**
     * Create a new Request
     *
     * @param HttpRequest     $httpRequest A Symfony HTTP request object
     */
    
    /**
     * Gets the full URL to the required web service.
     *
     * @return string
     */
    abstract public function getEndpoint();

    /**
     * Gets the transaction type for response parsing and logging.
     *
     * @return string
     */
    abstract public function getTransactionType();

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

    /**
     * Get the gateway service URI
     *
     * @param string $value
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function getServiceUri()
    {
        return $this->getParameter('serviceUri');
    }

    /**
     * Set the gateway service URI
     *
     * @param string $value
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setServiceUri($value)
    {
        return $this->setParameter('serviceUri', $value);
    }

    public function getCustomerReference()
    {
        return $this->getParameter('customerReference');
    }

    public function setCustomerReference($value)
    {
        return $this->setParameter('customerReference', $value);
    }

    public function getTransactionHistoryId()
    {
        return $this->getParameter('transactionHistoryId');
    }

    public function setTransactionHistoryId($value)
    {
        return $this->setParameter('transactionHistoryId', $value);
    }

}
