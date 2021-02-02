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
     * Sets set card brand.
     *
     * @param string $value
     * @return $this
     */
    public function setType($value)
    {
        return $this->setParameter('type', $value);
    }
}
