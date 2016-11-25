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
class Faonni_CryptoCurrency_Helper_Data 
	extends Mage_Core_Helper_Abstract
{
    /**
     * Crypto currency list path
     *
     * @var string	 
     */	
    const XML_PATH_CURRENCY_COIN = 'global/currency/coin';
	
    /**
     * Crypto currencies array
     *
     * @var array	 
     */	
    protected $cryptoCurrencies;
	
    /**
     * Retrieve crypto currencies list
	 *
     * @return array
     */
    public function getAllCoins()
    {
        if (null === $this->cryptoCurrencies) {
			$this->cryptoCurrencies = array();
			$cryptoCurrencies = Mage::app()->getConfig()->getNode(self::XML_PATH_CURRENCY_COIN);
			foreach ($cryptoCurrencies->children() as $code => $currency){
				$this->cryptoCurrencies[$code] = new Varien_Object($currency->asArray());
			}
        }
        return $this->cryptoCurrencies;
    }
	
    public function isCrypto($currency)
    {
        $cryptoCoin = $this->getAllCoins();
		return isset($cryptoCoin[$currency]);
    }	
}
