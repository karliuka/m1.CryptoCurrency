<?php

class Faonni_CryptoCurrency_Model_Sales_Order 
	extends Mage_Sales_Model_Order
{
    /**
     * Retrieve price precision
     *
     * @return int
     */
    public function getPrecision()
    {
        return Mage::helper('faonni_cryptocurrency')->isCrypto($this->getOrderCurrencyCode()) ? 10 : 2;
    }

    /**
     * Get formated price value including order currency rate to order website currency
     *
     * @param   float $price
     * @param   int $precision	 
     * @param   bool  $addBrackets
     * @return  string
     */	
    public function formatPricePrecision($price, $precision, $addBrackets=false)
    {
        return $this->getOrderCurrency()->formatPrecision($price, $this->getPrecision(), array(), true, $addBrackets);
    }
	
    /**
     * Retrieve order total due value
     *
     * @return float
     */
    public function getTotalDue()
    {
        $total = $this->getGrandTotal()-$this->getTotalPaid();
		if (!Mage::helper('faonni_cryptocurrency')->isCrypto($this->getOrderCurrencyCode())) {
			$total = Mage::app()->getStore($this->getStoreId())->roundPrice($total);
		}
        return max($total, 0);
    }	
}