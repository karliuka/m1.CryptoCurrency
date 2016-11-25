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
class Faonni_CryptoCurrency_Model_Adminhtml_System_Config_Backend_Currency_Allow
	extends Mage_Adminhtml_Model_System_Config_Backend_Currency_Allow
{
    /**
     * Retrieve allowed crypto currencies for current scope
     *
     * @return array
     */
    protected function _getAllowedCryptoCurrencies()
    {
        return explode(',', Mage::getConfig()->getNode('payment/cryptocurrency/allow', $this->getScope(), $this->getScopeId()));
    }
	
    /**
     * Retrieve Installed Currencies
     *
     * @return array
     */
    protected function _getInstalledCurrencies()
    {
		return array_unique(array_merge($this->_getAllowedCryptoCurrencies(), parent::_getInstalledCurrencies()));
    }
	
    /**
     * Save object data
     *
     * @return Mage_Core_Model_Abstract
     */
    public function save()
    {
		$this->setValue(
			array_unique(array_merge($this->getValue(), $this->_getAllowedCryptoCurrencies()))
		);
        return parent::save(); 
    }	
}