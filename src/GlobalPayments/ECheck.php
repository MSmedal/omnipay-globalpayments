<?php

namespace Omnipay\GlobalPayments;

use GlobalPayments\Api\Entities\Enums\AccountType;
use GlobalPayments\Api\Entities\Enums\CheckType;
use GlobalPayments\Api\Entities\Enums\SecCode;
use Omnipay\Common\CreditCard as CommonCreditCard;

/**
 * Extends Omnipay\Common\CreditCard to make use of most of that class's properties
 * before adding the below parameters specific to check/ACH
 */
class ECheck extends CommonCreditCard
{
    /**
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->getParameter('accountNumber');
    }

    /**
     * @param string $value
     * 
     * @return $this
     */
    public function setAccountNumber($value)
    {
        return $this->setParameter('accountNumber', $value);
    }

    /**
     * @return string
     */
    public function getRoutingNumber()
    {
        return $this->getParameter('routingNumber');
    }

    /**
     * @param string $value
     * 
     * @return $this
     */
    public function setRoutingNumber($value)
    {
        return $this->setParameter('routingNumber', $value);
    }

    /**
     * @return AccountType
     */
    public function getAccountType()
    {
        return $this->getParameter('accountType');
    }

    /**
     * @param AccountType $value
     * 
     * @return $this
     */
    public function setAccountType($value)
    {
        return $this->setParameter('accountType', $value);
    }

    /**
     * @return SecCode
     */
    public function getSecCode()
    {
        return $this->getParameter('secCode');
    }

    /**
     * @param SecCode $value
     * 
     * @return $this
     */
    public function setSecCode($value)
    {
        return $this->setParameter('secCode', $value);
    }

    /**
     * @return CheckType
     */
    public function getCheckType()
    {
        return $this->getParameter('checkType');
    }

    /**
     * @param CheckType $value
     * 
     * @return $this
     */
    public function setCheckType($value)
    {
        return $this->setParameter('checkType', $value);
    }

    /**
     * @return string
     */
    public function getCheckHolderName()
    {
        return $this->getParameter('checkHolderName');
    }

    /**
     * @param string $value
     * 
     * @return $this
     */
    public function setCheckHolderName($value)
    {
        return $this->setParameter('checkHolderName', $value);
    }
}
