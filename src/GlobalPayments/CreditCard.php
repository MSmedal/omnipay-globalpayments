<?php

namespace Omnipay\GlobalPayments;

use Omnipay\Common\CreditCard as CommonCreditCard;

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
     * Set card brand.
     *
     * @param string $value
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
     * Set mobile type (ApplePay / GooglePay)
     *
     * @param string $value
     * @return $this
     */
    public function setMobileType($value)
    {
        return $this->setParameter('mobileType', $value);
    }
}
