<?php
/**
 * Class BitLoop_GoogleTagManager_Block_DataLayer_Category
 *
 * Category data for the dataLayer array
 *
 * @category BitLoop
 * @package  BitLoop_Core
 * @author   Alex Bejan <alex@bitloop.co.uk>
 * @license  Bitloop License <support@bitloop.co.uk>
 */
class BitLoop_GoogleTagManager_Block_DataLayer_Category
    extends BitLoop_GoogleTagManager_Block_DataLayer_Abstract
{
    /**
     * The attributes to retrieve
     * @var array
     */
    protected $_entityAttributes = array(
        'categoryId' => 'entity_id',
        'categoryName' => 'name',
        'categoryIsAnchor' => 'is_anchor',
        'categoryProductsCount' => array(
            'callback'=>'_getCategoryProductsCount'
        ),
        'categoryHasImage' => 'image',
        'categoryCmsBlockId' => 'landing_page',
        'categoryDisplayMode' => 'display_mode',
    );

    /**
     * Hardcoded data for the product pages
     * @var array
     */
    protected $_customData = array(
        'pageCategory' => 'category'
    );

    /**
     * Get the current product instance
     *
     * @return Mage_Catalog_Model_Category
     */
    protected function _getEntityInstance()
    {
        return Mage::registry('current_category');
    }

    /**
     * Get an array of category products
     *
     * @return array
     */
    protected function _getCategoryProductsCount()
    {
        if ($_category = $this->_getEntityInstance()) {
            return $_category->getProductCount();
        }

        return array();
    }
}
