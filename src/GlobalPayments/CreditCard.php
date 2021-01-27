<?php

namespace Omnipay\GlobalPayments;

use Omnipay\Common\CreditCard as CommonCreditCard;

class CreditCard extends CommonCreditCard 
{
    /**
     * Get Card Type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->getParameter('type');
    }

    /**
     * Sets the last part of the card billing name.
     *
     * @param string $value
     * @return $this
     */
    public function setType($value)
    {
        return $this->setParameter('type', $value);
    }
}
