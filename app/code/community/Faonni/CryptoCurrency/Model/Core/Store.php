<?php
/**
 * Faonni Group
 *  
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade module to newer
 * versions in the future.
 * 
 * @package     Faonni_CryptoCurrency
 * @copyright   Copyright (c) 2016 Faonni Group(support@faonni.com) 
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Faonni_CryptoCurrency_Model_Core_Store 
	extends Mage_Core_Model_Store
{
    /**
     * Retrieve price precision
     *
     * @return int
     */
    public function getPrecision()
    {
        return Mage::helper('faonni_cryptocurrency')->isCrypto($this->getCurrentCurrencyCode()) ? 10 : 2;
    }

    /**
     * Round price
     *
     * @param mixed $price
     * @return double
     */
    public function roundPrice($price)
    {
		return round($price, $this->getPrecision());
    }

    /**
     * Format price with currency filter (taking rate into consideration)
     *
     * @param   double $price
     * @param   bool $includeContainer
     * @return  string
     */
    public function formatPrice($price, $includeContainer=true)
    {
		if ($this->getCurrentCurrency()) {
            return $this->getCurrentCurrency()->format($price, array('precision' => $this->getPrecision()), $includeContainer);
        }
        return $price;
    }
}
