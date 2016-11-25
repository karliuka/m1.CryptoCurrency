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
class Faonni_CryptoCurrency_Model_Core_Locale 
	extends Mage_Core_Model_Locale
{
    /**
     * Create Zend_Currency object for current locale
     *
     * @param   string $currency
     * @return  Zend_Currency
     */
    public function currency($currency)
    {
        if (!Mage::helper('faonni_cryptocurrency')->isCrypto($currency)) {
			return parent::currency($currency);
		}
		if (!isset(self::$_currencyCache[$this->getLocaleCode()][$currency])) {
			$options = array();
			$options['name'] = $currency;
			$options['currency'] = $currency;
			$options['symbol'] = $currency;
			
            $options = new Varien_Object($options);
            Mage::dispatchEvent('currency_display_options_forming', array(
                'currency_options' => $options,
                'base_code' => $currency
            ));
			
			$currencyObject = new Zend_Currency($options->toArray());
            self::$_currencyCache[$this->getLocaleCode()][$currency] = $currencyObject;			
		}
        return self::$_currencyCache[$this->getLocaleCode()][$currency];
    }
	
	/**
     * Returns a localized information string, supported are several types of informations.
     * For detailed information about the types look into the documentation
     *
     * @param  string             $value  Name to get detailed information about
     * @param  string             $path   (Optional) Type of information to return
     * @return string|false The wished information in the given language
     */
    public function getTranslation($value = null, $path = null)
    {
        if (!Mage::helper('faonni_cryptocurrency')->isCrypto($value) || $path != 'nametocurrency') {
			return parent::getTranslation($value, $path);
		}
		
		$coins = Mage::helper('faonni_cryptocurrency')->getAllCoins();
		if (isset($coins[$value])) {
			return $coins[$value]->getName();
		}
        return $value;
    }
}