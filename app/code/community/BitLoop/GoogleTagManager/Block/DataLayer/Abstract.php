<?php
/**
 * Class BitLoop_GoogleTagManager_Block_DataLayer_Abstract
 *
 * Abstract class for the entity attributes data
 *
 * @category BitLoop
 * @package  BitLoop_Core
 * @author   Alex Bejan <alex@bitloop.co.uk>
 * @license  Bitloop License <support@bitloop.co.uk>
 */
abstract class BitLoop_GoogleTagManager_Block_DataLayer_Abstract
    extends Mage_Core_Block_Template
{
    /**
     * Data for the data layer array.
     *
     * The format needs to be gtmField => entity_attribute_code
     * The entity_attribute_code can be replaced with a callback in the
     * current class. Example: fieldName => array('callback'=>'getMyResult')
     *
     * @var array
     */
    protected $_dataLayer;

    /**
     * Here you can hardcode any data related to the entity
     *
     * The format is gtmField => value
     *
     * @var array
     */
    protected $_customData;

    /**
     * The attributes to retrieve
     * @var array
     */
    protected $_entityAttributes = array();

    /**
     * Get the product data for the dataLayer array
     *
     * @return array
     * @SuppressWarnings(PHPMD)
     */
    public function getDataLayer()
    {
        // If we already have the data, return it
        if ($this->_dataLayer) {
            return $this->_dataLayer;
        }

        // Here we will store the attributes data if we find any
        $_data = array();

        // Now, if we find the entity instance, we build the data array
        // with the entity attributes configured in the class
        if ($_entityInstance = $this->_getEntityInstance()) {
            foreach ($this->_entityAttributes as $_gtmCode => $_attribute) {
                // If the attribute is array, it means we have a callback
                // so the value is the value returned by the callback
                if (is_array($_attribute) && isset($_attribute['callback'])) {
                    // Get the value from the callback
                    $_data[$_gtmCode] = call_user_func(
                        array($this, $_attribute['callback'])
                    );
                    continue;
                }

                // If the attribute exists and has a value, add it to the data
                if ($_attribute
                    && $_attributeData = $_entityInstance->getData($_attribute)
                ) {
                    $_data[$_gtmCode] = $_attributeData;
                }
            }

            // Add custom data
            if (!empty($this->_customData)) {
                $_data = array_merge($_data, $this->_customData);
            }
        }

        // Cache the data agains the class
        $this->_dataLayer = $_data;

        // Return the data
        return $this->_dataLayer;
    }

    /**
     * Return the entity istance
     *
     * @return mixed
     */
    abstract protected function _getEntityInstance();

}
