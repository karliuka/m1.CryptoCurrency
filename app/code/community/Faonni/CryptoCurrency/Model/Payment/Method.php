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
class Faonni_CryptoCurrency_Model_Payment_Method 
	extends Mage_Payment_Model_Method_Abstract
{

    /**
     * Status pending approval constant
     */
    const STATUS_PENDING_PAYMENT_APPROVAL = 'crypto_pending_approval';
	
    /**
     * Unique internal payment method identifier
     *
     * @var string	 
     */
    protected $_code = 'cryptocurrency';
	
	protected $_isInitializeNeeded      = true;
	protected $_canUseInternal          = false;
	protected $_canUseForMultishipping  = false;	
	
    /**
     * Form block type
     *
     * @var string	 
     */	
    protected $_formBlockType = 'faonni_cryptocurrency/payment_form';
	
    /**
     * Info block type
     *
     * @var string	 
     */		
    protected $_infoBlockType = 'faonni_cryptocurrency/payment_info';
	
    /**
     * Assign data to info model instance
     *
     * @param   mixed $data
     * @return  Mage_Payment_Model_Method_Abstract
     */
    public function assignData($data)
    {
        if (!($data instanceof Varien_Object)) {
            $data = new Varien_Object($data);
        }
		
		// �������� ������� ��������� ������ !!!
		
		//Mage::app()->getStore()->getData('available_currency_codes');
		
		Mage::app()->getStore()->setCurrentCurrencyCode($data->getCryptocurrency());
		//Mage::Log($data->getCryptocurrency(), null, 'cryptocurrency.log');
        $this->getInfoInstance()->setWalletAddress($data->getCryptocurrency());
		// add new address
		
        return $this;
    }
	
}