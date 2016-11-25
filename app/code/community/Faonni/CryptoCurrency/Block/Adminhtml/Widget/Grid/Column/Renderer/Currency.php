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
class Faonni_CryptoCurrency_Block_Adminhtml_Widget_Grid_Column_Renderer_Currency
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Currency
{
    /**
     * Renders grid column
     *
     * @param   Varien_Object $row
     * @return  string
     */
    public function render(Varien_Object $row)
    {
        if ($data = (string)$row->getData($this->getColumn()->getIndex())) {
            $currency_code = $this->_getCurrencyCode($row);

            if (!$currency_code) {
                return $data;
            }
			
			$precision = Mage::helper('faonni_cryptocurrency')->isCrypto($currency_code) ? 10 : 2;
			
            $data = floatval($data) * $this->_getRate($row);
            $sign = (bool)(int)$this->getColumn()->getShowNumberSign() && ($data > 0) ? '+' : '';
            $data = sprintf("%F", $data);
            $data = Mage::app()->getLocale()->currency($currency_code)->toCurrency($data, array('precision' => $precision));
            return $sign . $data;
        }
        return $this->getColumn()->getDefault();
    }
}