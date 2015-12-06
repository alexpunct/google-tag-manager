<?php
/**
 * Class BitLoop_GoogleTagManager_Block_Abstract
 *
 * Abstract class for the container
 *
 * @category BitLoop
 * @package  BitLoop_Core
 * @author   Alex Bejan <alex@bitloop.co.uk>
 * @license  Bitloop License <support@bitloop.co.uk>
 */
class BitLoop_GoogleTagManager_Block_Abstract extends Mage_Core_Block_Template
{
    /**
     * Block cache lifetime
     * Default: 1h (3600 seconds)
     */
    const CACHE_LIFETIME = 3600;

    /**
     * Class constructor. Set the cache lifetime so the block will be cached.
     *
     * @return void
     */
    protected function _construct()
    {
        // Set the block cache time
        $this->setData('cache_lifetime', self::CACHE_LIFETIME);

        parent::_construct();
    }

    /**
     * Return the block html or nothing if the container id was not set
     *
     * @return string
     */
    protected function _toHtml()
    {
        // Try to find the container id first
        $_containerId = $this->_getConfig()->getContainerId();

        // If we don't have a container id, do nothing
        if (!$_containerId) {
            return '';
        }

        // Set the container id against the block so it can be retrieved
        // by the template
        $this->setData('container_id', $_containerId);

        // Return the block html if the container id was found
        return parent::_toHtml();
    }

    /**
     * Get the config helper
     *
     * @return BitLoop_GoogleTagManager_Helper_Config
     */
    protected function _getConfig()
    {
        return Mage::helper('bitloop_googletagmanager/config');
    }
}
