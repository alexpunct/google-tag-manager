<?php
/**
 * Class BitLoop_GoogleTagManager_Helper_Config
 *
 * Retrieve configuration values
 *
 * @category BitLoop
 * @package  BitLoop_Core
 * @author   Alex Bejan <alex@bitloop.co.uk>
 * @license  Bitloop License <support@bitloop.co.uk>
 */
class BitLoop_GoogleTagManager_Helper_Config extends BitLoop_Core_Helper_Data
{
    /**
     * General Configuration paths
     */
    const CONFIG_TAG_MANAGER_ENABLED =
        'bitloop_googletagmanager/configuration/enable';
    const CONFIG_TAG_CONTAINER_ID =
        'bitloop_googletagmanager/configuration/container_id';

    /**
     * Data Layer configuration paths
     */
    const CONFIG_DATA_LAYER_MAGENTO_CONTEXT =
        'bitloop_googletagmanager/data_layer/magento_context';
    const CONFIG_DATA_LAYER_CATEGORY_DATA =
        'bitloop_googletagmanager/data_layer/category_page';
    const CONFIG_DATA_LAYER_PRODUCT_DATA =
        'bitloop_googletagmanager/data_layer/product_page';
    const CONFIG_DATA_LAYER_ORDER_TRANSACTION_DATA =
        'bitloop_googletagmanager/data_layer/order_success';

    /**
     * Check if Google Tag Manager is enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return (bool) Mage::getStoreConfig(self::CONFIG_TAG_MANAGER_ENABLED);
    }

    /**
     * Return the configured container id for the current store
     * Or return false
     *
     * @return bool|string
     */
    public function getContainerId()
    {
        // If GTM is not enabled, return false
        if (!$this->isEnabled()) {
            return false;
        }

        // Try to find the container id in the config
        $_containerId = Mage::getStoreConfig(self::CONFIG_TAG_CONTAINER_ID);

        // If the container id doesn't exist, return false
        if (empty($_containerId)) {
            return false;
        }

        // Return the container id
        return $_containerId;
    }

    /**
     * Check if the Magento Context for dataLayer is enabled
     *
     * @return bool
     */
    public function isDataLayerMagentoContextEnabled()
    {
        return (bool) Mage::getStoreConfig(
            self::CONFIG_DATA_LAYER_MAGENTO_CONTEXT
        );
    }

    /**
     * Check if the Category data for dataLayer is enabled
     *
     * @return bool
     */
    public function isDataLayerCategoryEnabled()
    {
        return (bool) Mage::getStoreConfig(
            self::CONFIG_DATA_LAYER_CATEGORY_DATA
        );
    }

    /**
     * Check if the Product data for dataLayer is enabled
     *
     * @return bool
     */
    public function isDataLayerProductEnabled()
    {
        return (bool) Mage::getStoreConfig(
            self::CONFIG_DATA_LAYER_PRODUCT_DATA
        );
    }

    /**
     * Check if the Transaction data for dataLayer is enabled for order success
     *
     * @return bool
     */
    public function isDataLayerOrderSuccessEnabled()
    {
        return (bool) Mage::getStoreConfig(
            self::CONFIG_DATA_LAYER_ORDER_TRANSACTION_DATA
        );
    }
}
