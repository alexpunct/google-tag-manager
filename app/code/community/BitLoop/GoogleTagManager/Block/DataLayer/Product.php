<?php
/**
 * Class BitLoop_GoogleTagManager_Block_DataLayer_Product
 *
 * Product data for the dataLayer array
 *
 * @category BitLoop
 * @package  BitLoop_Core
 * @author   Alex Bejan <alex@bitloop.co.uk>
 * @license  Bitloop License <support@bitloop.co.uk>
 */
class BitLoop_GoogleTagManager_Block_DataLayer_Product
    extends BitLoop_GoogleTagManager_Block_DataLayer_Abstract
{
    /**
     * The attributes to retrieve
     * @var array
     */
    protected $_entityAttributes = array(
        'productId' => 'entity_id',
        'productSku' => 'sku',
        'productName' => 'name',
        'productType' => 'type_id',
        'productInStock' => 'is_in_stock',
        'productPrice' => 'price',
        'productSpecialPrice' => 'special_price',
    );

    /**
     * Hardcoded data for the product pages
     * @var array
     */
    protected $_customData = array(
        'pageCategory' => 'product'
    );

    /**
     * Get the current product instance
     *
     * @return Mage_Catalog_Model_Product
     */
    protected function _getEntityInstance()
    {
        return Mage::registry('current_product');
    }
}
