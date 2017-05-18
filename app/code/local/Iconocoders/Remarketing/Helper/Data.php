<?php

/**
 * Iconocoders_Remarketing_Helper_Data
 *
 * @category  Iconocoders
 * @package   Iconocoders_Remarketing
 * @author    Daniel Akos Kovacs, Attila Kiss, Peter Szabo
 * @copyright 2017 Iconocoders (https://iconocoders.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */

class Iconocoders_Remarketing_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * isPixelEnabled
     *
     * @return mixed
     */
    public function isPixelEnabled()
    {
        return Mage::getStoreConfig("iconocoders_remarketing/tracking/enabled");
    }

    /**
     * isConversionEnabled
     *
     * @return mixed
     */
    public function isConversionEnabled()
    {
        return Mage::getStoreConfig("iconocoders_remarketing/tracking/conversion");
    }

    /**
     * getPixelId
     *
     * @return mixed
     */
    public function getPixelId()
    {
        return Mage::getStoreConfig("iconocoders_remarketing/tracking/pixel_id");
    }

    /**
     * Returns the store config value for javascript tag google_conversion_id
     * @return string $conversionId
     */
    public function getGoogleConversionId()
    {
        $conversionId = Mage::getStoreConfig('iconocoders_remarketing/tracking/ga_conversion_id');
        if($conversionId != ''){
            return $conversionId;
        }
        return false;
    }

    /**
     * Returns the store config value for javascript tag google_remarketing_only
     * @return boolean;
     */
    public function getGoogleRemarketingOnly()
    {
        $boolean = (boolean)Mage::getStoreConfig('iconocoders_remarketing/tracking/js_remarketing_only');
        return $boolean === true ? "true": "false";
    }

    /**
     * Returns a javascript object with unquoted keys
     * Also double quotes are not allowed so we replace them with single ones
     *
     * @param array $data
     * @return mixed
     */
    public function getJsObjectString(array $data)
    {
        return str_replace('"',"'",preg_replace('/"([^"]+)"s*:s*/', '$1:', json_encode($data)) );
    }

    /**
     * getCartProductIds
     *
     * @param $quote Mage_Sales_Model_Quote
     * @return string
     */
    public function getCartProductIds($quote)
    {
        $productIds = [];
        /**
         * @var $item Mage_Catalog_Model_Product
         */
        foreach ($quote->getAllItems() as $item) {
            if ($item->getParentItemId()) {continue;}
            $productIds[] = $item->getSku();
        }

        return implode(', ', $productIds);
    }

    /**
     * getProductCategories
     *
     * @param array $categoryIds
     * @return string
     */
    public function getProductCategories($categoryIds)
    {
        $categories = [];

        if (is_array($categoryIds) && (count($categoryIds) > 0)) {
            foreach ($categoryIds as $categoryId) {
                $category = Mage::getModel('catalog/category')->load($categoryId);
                $categories[] = $category->getName();
            }
        }

        return implode(', ', $categories);
    }
}