<?php
/**
 * Class BitLoop_GoogleTagManager_Block_DataLayer_OrderSuccess
 *
 * Transaction data for the dataLayer array
 *
 * @category BitLoop
 * @package  BitLoop_Core
 * @author   Alex Bejan <alex@bitloop.co.uk>
 * @license  Bitloop License <support@bitloop.co.uk>
 */
class BitLoop_GoogleTagManager_Block_DataLayer_OrderSuccess
    extends BitLoop_GoogleTagManager_Block_DataLayer_Abstract
{
    /**
     * The attributes to retrieve
     * @var array
     */
    protected $_entityAttributes = array(
        'transactionId' => 'increment_id',
        'transactionAffiliation' => 'store_id',
        'transactionTotal' => 'grand_total',
        'transactionProducts' => array(
            'callback'=>'_getTransactionProducts'
        ),
        'transactionShipping' => 'shipping_amount',
        'transactionTax' => 'tax_amount',
        'transactionCurrency' => 'order_currency_code'
    );

    /**
     * Hardcoded data for the order success page
     * @var array
     */
    protected $_customData = array(
        'pageCategory' => 'new_order'
    );

    /**
     * Get the current product instance
     *
     * @return Mage_Sales_Model_Order
     */
    protected function _getEntityInstance()
    {
        // Get the last order from the session
        return Mage::getSingleton('checkout/session')->getLastRealOrder();
    }

    /**
     * Get an array of ordered products - callback
     *
     * @return array
     */
    protected function _getTransactionProducts()
    {
        $_orderItems = array();

        // If the order exists, loop through all products and add them
        if (($_order = $this->_getEntityInstance())
            && $_order instanceof Mage_Sales_Model_Order
            && $_order->getId()
        ) {
            /**
             * @var Mage_Sales_Model_Order_Item $_item
             */
            foreach ($_order->getAllItems() as $_item) {
                $_orderItems[] = array(
                    'name' => $_item->getName(),
                    'sku' => $_item->getSku(),
                    'category' => $_item->getProduct()->getCategory() ?
                        $_item->getProduct()->getCategory()->getName() : '',
                    'price' => $_item->getPrice(),
                    'quantity' => $_item->getQtyOrdered()
                );
            }

            return $_orderItems;
        }

        return array();
    }
}
