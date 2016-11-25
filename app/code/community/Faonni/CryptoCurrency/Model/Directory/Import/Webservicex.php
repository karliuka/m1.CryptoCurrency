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
class Faonni_CryptoCurrency_Model_Directory_Import_Webservicex
	extends Mage_Directory_Model_Currency_Import_Webservicex
{
    /**
     * Retrieve allowed crypto currencies for current scope
     *
     * @return array
     */
    protected function _getAllowedCryptoCurrencies()
    {
        return explode(',', Mage::getStoreConfig('payment/cryptocurrency/allow'));
    }
	
    /**
     * Retrieve currency codes
     *
     * @return array
     */
    protected function _getCurrencyCodes()
    {
        return array_diff(
			Mage::getModel('directory/currency')->getConfigAllowCurrencies(), 
			$this->_getAllowedCryptoCurrencies()
		);
    }

    /**
     * Fetch Rates
     *
     * @return array
     */
    public function fetchRates()
    {
        $rates = parent::fetchRates();
        $currencies = $this->_getAllowedCryptoCurrencies();

        @set_time_limit(0);
        foreach ($rates as $currencyFrom => $data) {
            foreach ($currencies as $currencyTo) {
                if ($currencyFrom == $currencyTo) {
                    $rates[$currencyFrom][$currencyTo] = $this->_numberFormat(1);
                }
                else {
                    $rates[$currencyFrom][$currencyTo] = $this->_numberFormat($this->_convertCrypto($currencyFrom, $currencyTo));
                }
            }
            ksort($rates[$currencyFrom]);
        }
		
		//Mage::Log($rates, null, 'cryptocurrency.log');
        return $rates;
    }
	
    /**
     * Retrieve rate
     *
     * @param   string $currencyFrom
     * @param   string $currencyTo
     * @return  float
     */	
    protected function _convertCrypto($currencyFrom, $currencyTo, $retry=0)
    {
        $url = str_replace('{{CURRENCY_FROM}}', strtolower($currencyFrom), 'https://www.cryptonator.com/api/full/{{CURRENCY_FROM}}-{{CURRENCY_TO}}');
        $url = str_replace('{{CURRENCY_TO}}', strtolower($currencyTo), $url);

        try {
            $response = $this->_httpClient
                ->setUri($url)
                ->setConfig(array('timeout' => Mage::getStoreConfig('currency/webservicex/timeout')))
                ->request('GET')
                ->getBody();

            $json = json_decode($response);
			//Mage::Log($json->ticker->price, null, 'cryptocurrency.log');
            if(!$json || !isset($json->ticker->price)) {
                $this->_messages[] = Mage::helper('directory')->__('Cannot retrieve rate from %s.', $url);
                return null;
            }
            return (float) $json->ticker->price;
        }
        catch (Exception $e) {
            if( $retry == 0 ) {
                $this->_convert($currencyFrom, $currencyTo, 1);
            } else {
                $this->_messages[] = Mage::helper('directory')->__('Cannot retrieve rate from %s.', $url);
            }
        }
    }	
}