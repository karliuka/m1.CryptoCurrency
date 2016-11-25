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
class Faonni_CryptoCurrency_Model_Observer
{
    /**
     * Dispatch event before action
     *
     * @return Faonni_CryptoCurrency_Model_Observer
     */
    public function currency($observer)
    {
		$options = $observer->getEvent()->getCurrencyOptions();
		$currency = $observer->getEvent()->getBaseCode();
		$coins = Mage::helper('faonni_cryptocurrency')->getAllCoins();
		
		if (isset($coins[$currency])) {
			$options->setName($coins[$currency]->getName());
			$options->setSymbol($coins[$currency]->getSymbol());
			$options->setPosition($this->getPosition($coins[$currency]->getPosition()));
		}
        return $this;
    }
	
    /**
     * Returns value for defining the position of the currencysign
     *
     * @return int
     */
    public function getPosition($position)
    {
		if ('left' == $position) {
			return Zend_Currency::LEFT;
		} elseif ('right' == $position){
			return Zend_Currency::RIGHT;
		}
        return Zend_Currency::STANDARD;
    }	
}