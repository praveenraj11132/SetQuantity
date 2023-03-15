<?php
declare(strict_types=1);

namespace Wheelpros\WheelprosTest\Block\Adminhtml\Form\Field;

use Magento\Framework\View\Element\Html\Select;
use Magento\Backend\Block\Template\Context;
use Magento\Catalog\Model\CategoryFactory;

class CategoryColumn extends Select
{
    protected $categoryFactory;

    /**
     * Set "name" for <select> element
     *
     * @param string $value
     * @return $this
     */

    public function __construct(
        Context $context,
        CategoryFactory $categoryFactory,
        array $data = []
    )
    {
        $this->categoryFactory = $categoryFactory;
        parent::__construct($context, $data);
    }
    public function setInputName($value)
    {
        return $this->setName($value);
    }

    /**
     * Set "id" for <select> element
     *
     * @param $value
     * @return $this
     */
    public function setInputId($value)
    {
        return $this->setId($value);
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    public function _toHtml(): string
    {
        if (!$this->getOptions()) {
            $this->setOptions($this->getSourceOptions());
        }
        return parent::_toHtml();
    }

    private function getSourceOptions(): array
    {
        /** @var AbstractCollection $categoryCollection */
        $categoryCollection = $this->categoryFactory->create()->getCollection()
            ->addAttributeToSelect('name')
            ->addAttributeToFilter('level', ['gt' => 1]);  // exclude root category
//            ->addAttributeToFilter('children_count', ['gt' => 0]); // filter only subcategories that have children

        return $categoryCollection->toOptionArray();
    }
}
