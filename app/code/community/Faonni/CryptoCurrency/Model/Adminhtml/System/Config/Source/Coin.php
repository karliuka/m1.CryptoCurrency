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
class Faonni_CryptoCurrency_Model_Adminhtml_System_Config_Source_Coin
{
    /**
     * Options array
	 *
     * @var array
     */
    protected $_options;
	
    /**
     * Retrieve All options
	 *
     * @return array
     */
    public function toOptionArray($isMultiselect=false)
    {
        if (null === $this->_options) {
			$this->_options = array();
			$coins = Mage::app()->getConfig()->getNode('global/currency/coin');
			foreach ($coins->children() as $code => $coin){
				$this->_options[] = array('value' => $code, 'label' => $coin->name);
			}
        }
        $options = $this->_options;
        if(!$isMultiselect){
            array_unshift(
				$options, 
				array(
					'value' => '', 
					'label' => Mage::helper('adminhtml')->__('--Please Select--')
				)
			);
        }
        return $options;
    }
}