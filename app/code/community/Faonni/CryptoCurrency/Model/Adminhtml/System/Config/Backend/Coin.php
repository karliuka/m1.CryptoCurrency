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
class Faonni_CryptoCurrency_Model_Adminhtml_System_Config_Backend_Coin
	 extends Mage_Core_Model_Config_Data
{
    /**
     * Retrieve allowed currencies for current scope
     *
     * @return array
     */
    protected function _getAllowedCurrencies()
    {
		$allowed = explode(',', Mage::getConfig()->getNode(
			Mage_Directory_Model_Currency::XML_PATH_CURRENCY_ALLOW, 
			$this->getScope(), 
			$this->getScopeId())
		);
		return array_intersect($allowed, explode(',', Mage::getStoreConfig('system/currency/installed')));
    }
	
    /**
     * Save object data
     *
     * @return Mage_Core_Model_Abstract
     */
    public function save()
    {
		Mage::getConfig()->saveConfig(
			Mage_Directory_Model_Currency::XML_PATH_CURRENCY_ALLOW, 
			implode(',', array_unique(array_merge($this->_getAllowedCurrencies(), $this->getValue()))),
			$this->getScope(), 
			$this->getScopeId()
		);
        return parent::save(); 
    }
}