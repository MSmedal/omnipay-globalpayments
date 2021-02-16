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
