<?php
namespace Wheelpros\WheelprosTest\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;
use Wheelpros\WheelprosTest\Block\Adminhtml\Form\Field\CategoryColumn;

/**
 * Class Ranges
 */
class Category extends AbstractFieldArray
{
    /**
     * @var CategoryColumn
     */
    private $categoryRenderer;

    /**
     * Prepare rendering the new field by adding all the needed columns
     * @throws LocalizedException
     */
    protected function _prepareToRender()
    {
        $this->addColumn('category', [
            'label' => __('Category'),
            'renderer' => $this->getCategoryRenderer()
        ]);

        $this->addColumn('quantity', [
            'label' => __('Quantity'),
            'class' => 'required-entry'
        ]);

        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }

    /**
     * Prepare existing row data object
     *
     * @param DataObject $row
     * @throws LocalizedException
     */
    protected function _prepareArrayRow(DataObject $row): void
    {
        $options = [];

        $category = $row->getCategory();
        if ($category !== null) {
            $options['option_' . $this->getCategoryRenderer()->calcOptionHash($category)] = 'selected="selected"';
        }

        $row->setData('option_extra_attrs', $options);
    }

    /**
     * @return false|string
     * @throws LocalizedException
     */
    private function getCategoryRenderer()
    {
        if (!$this->categoryRenderer) {
            $this->categoryRenderer = $this->getLayout()->createBlock(
                CategoryColumn::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }

        return $this->categoryRenderer;
    }
}
