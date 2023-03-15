<?php

namespace Wheelpros\WheelprosTest\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Wheelpros\Core\Model\Config;

/**
 * This class returns the default quantity configuration for category
 */

class GetCategory implements ArgumentInterface
{
    /**
     * @var Config
     */
    public Config $config;

    /**
     * @param Config   $config
     */
    public function __construct(
        Config   $config
    ){
        $this->config = $config;
    }

    /**
     * Returns the data from the Ranges form field
     *
     * @return array
     */
    public function getConfiguredCategories()
    {
        return $this->config->getConfig('wheelpros_test/quantity_ranges/quantity');
    }


    /**
     * @param $categoryId
     * @param $parentCategoryId
     * @return int|mixed
     */
    public function getQuantity($categoryId, $parentCategoryId): mixed
    {
        $quantity = 1;
        $configuredCategories = array_values((array)json_decode($this->getConfiguredCategories()));

        foreach ($configuredCategories as $categoriesData)
        {
            $categoryQty = (array)$categoriesData;

            if ($categoryQty['category'] == $categoryId)
            {
               return $categoryQty['quantity'];
            }
        }

        /*
         * This method returns the quantity for all subcategories
         */

        if ($quantity == 1)
        {
            foreach ($configuredCategories as $categoriesData)
            {
                $categoryQty = (array)$categoriesData;

                if ($categoryQty['category'] == $parentCategoryId)
                {
                    return $categoryQty['quantity'];
                }
            }
        }

        return $quantity;
    }
}
