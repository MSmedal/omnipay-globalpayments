<?php

namespace Omnipay\GlobalPayments;

use Omnipay\Common\CreditCard as CommonCreditCard;

/**
 * Extends Omnipay\Common\CreditCard to add support for the below params
 */
class CreditCard extends CommonCreditCard
{
    /**
     * Get card brand.
     *
     * @return string
     */
    public function getType()
    {
        return $this->getParameter('type');
    }

    /**
     * Sets card brand; required for TransIt Gateway
     * 
     * @param string $value card brand.
     * 
     * @return $this
     */
    public function setType($value)
    {
        return $this->setParameter('type', $value);
    }

    /**
     * Get mobile type (ApplePay / GooglePay)
     *
     * @return string
     */
    public function getMobileType()
    {
        return $this->getParameter('mobileType');
    }

    /**
     * Sets mobile wallet type
     * 
     * @param string $value mobile type (ApplePay / GooglePay)
     * 
     * @return $this
     */
    public function setMobileType($value)
    {
        return $this->setParameter('mobileType', $value);
    }
}
