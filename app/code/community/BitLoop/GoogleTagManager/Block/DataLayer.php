<?php
/**
 * Class BitLoop_GoogleTagManager_Block_DataLayer
 *
 * @category BitLoop
 * @package  BitLoop_Core
 * @author   Alex Bejan <alex@bitloop.co.uk>
 * @license  Bitloop License <support@bitloop.co.uk>
 */
class BitLoop_GoogleTagManager_Block_DataLayer
    extends BitLoop_GoogleTagManager_Block_Abstract
{
    /**
     * Data Layer parameters array
     * @var array
     */
    protected $_dataLayer;

    /**
     * We want this block to be cached based on the parameters.
     * If any of the parameters in the data layer changes, we want to serve
     * the updated version to the visitor, that's why we include the
     * parameters values in the cache key so when they are updated, the cache
     * key will have a different value
     *
     * @return array
     */
    public function getCacheKeyInfo()
    {
        // Get the parent cache key array
        $_parentCacheKey = parent::getCacheKeyInfo();

        // Merge the parent cache key with the data layer parameter values
        return array_merge(
            array_values($this->getDataLayer()), $_parentCacheKey
        );
    }

    /**
     * Get the array of parameters for the data layer
     *
     * @return array
     * @throws Exception
     */
    public function getDataLayer()
    {
        if ($this->_dataLayer) {
            return $this->_dataLayer;
        }

        $_dataLayer = array();

        // Add the Magento Context data if enabled
        if ($_magentoContextData = $this->_getMagentoContextData()) {
            $_dataLayer = array_merge($_dataLayer, $_magentoContextData);
        }

        // Add the Category page data if enabled
        if ($_categoryData = $this->_getCategoryPageData()) {
            $_dataLayer = array_merge($_dataLayer, $_categoryData);
        }

        // Add the Product page data if enabled
        if ($_productData = $this->_getProductPageData()) {
            $_dataLayer = array_merge($_dataLayer, $_productData);
        }

        // Add the Order Success page transaction data if enabled
        if ($_transactionData = $this->_getOrderSuccessPageData()) {
            $_dataLayer = array_merge($_dataLayer, $_transactionData);
        }

        // Cache the data layer array agains the class
        $this->_dataLayer = $_dataLayer;

        // Return the data layer array
        return $this->_dataLayer;
    }

    /**
     * Get the data for data layer as json
     *
     * @return bool|string
     * @throws Exception
     */
    public function getJsonDataLayer()
    {
        // Get the data as array
        $_data = $this->getDataLayer();

        // If the data doesn't exist, return false
        if (empty($_data)) {
            return false;
        }

        // Return the data encoded as JSON
        return json_encode($_data);
    }

    /**
     * Get the Magento context data:
     * - request module name
     * - request controller name
     * - request action name
     * - customer group id
     * - current store code
     * - current store id
     * - current locale code
     *
     * @return array|bool
     * @throws Exception
     */
    protected function _getMagentoContextData()
    {
        // Add the Magento Context if enabled return an array with all the data
        if ($this->_getConfig()->isDataLayerMagentoContextEnabled()) {
            return array(
                'magentoModule' => $this->getRequest()->getModuleName(),
                'magentoController' => $this->getRequest()
                                            ->getControllerName(),
                'magentoAction'=> $this->getRequest()->getActionName(),
                'customerGroupId' => Mage::getSingleton('customer/session')
                                         ->getCustomerGroupId(),
                'storeCode' => Mage::app()->getStore()->getCode(),
                'storeId' => Mage::app()->getStore()->getId(),
                'locale' => Mage::app()->getLocale()->getLocaleCode()
            );
        }

        return false;
    }

    /**
     * Get the category page data. Will return false if we are not on a
     * category page
     *
     * @return bool|array
     */
    protected function _getCategoryPageData()
    {
        /**
         * Try to find a child category block (available only on category pages)
         * @var BitLoop_GoogleTagManager_Block_DataLayer_Category $_catBlock
         */
        if ($this->_getConfig()->isDataLayerCategoryEnabled()
            && ($_catBlock = $this->getChild('bl_gtm_dl_category'))
        ) {
            return $_catBlock->getDataLayer();
        }

        return false;
    }

    /**
     * Get the product page data. Will return false if we are not on the
     * product page
     *
     * @return bool|array
     */
    protected function _getProductPageData()
    {
        /**
         * Try to find a child product block (available only on product pages)
         * @var BitLoop_GoogleTagManager_Block_DataLayer_Product $_productBlock
         */
        if ($this->_getConfig()->isDataLayerProductEnabled()
            && ($_productBlock = $this->getChild('bl_gtm_dl_product'))
        ) {
            return $_productBlock->getDataLayer();
        }

        return false;
    }

    /**
     * Get the transaction data. Will return false if we are not on the
     * order success page
     *
     * @return bool|array
     */
    protected function _getOrderSuccessPageData()
    {
        /**
         * Try to find a child order success block
         * @var BitLoop_GoogleTagManager_Block_DataLayer_Product $_productBlock
         */
        if ($this->_getConfig()->isDataLayerOrderSuccessEnabled()
            && ($_transactionBlock = $this->getChild('bl_gtm_dl_order_success'))
        ) {
            return $_transactionBlock->getDataLayer();
        }

        return false;
    }
}
