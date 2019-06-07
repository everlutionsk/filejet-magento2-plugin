<?php

namespace Filejet\FilejetMagento2Plugin\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class ImageAttribute extends AbstractFieldArray
{
    protected function _prepareToRender()
    {
        $this->addColumn('imageAttribute', ['label' => __('Attribute'), 'class' => 'required-entry']);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add attribute');
    }
}
