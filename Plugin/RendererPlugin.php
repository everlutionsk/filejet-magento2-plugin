<?php

namespace Filejet\FilejetMagento2Plugin\Plugin;


use FileJet\External\ReplaceHtml;
use Magento\Framework\App\State;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\AbstractBlock;
use Filejet\FilejetMagento2Plugin\Helper\Data;

/**
 * Class RendererPlugin
 *
 * @author Martin Adamik <martin.adamik@everlution.sk>
 */
class RendererPlugin
{


    /** @var Data */
    private $helperData;
    /** @var State */
    private $state;

    public function __construct(
        Data $helperData,
        State $state
    )
    {
        $this->helperData = $helperData;
        $this->state = $state;
    }

    public function afterToHtml(AbstractBlock $block, $output){

        try {
            if ($this->state->getAreaCode() === 'adminhtml') {
                return $output;
            }
        } catch (LocalizedException $e) {
            return $output;
        }

        if(!$this->helperData->getGeneralConfig('enable')) {
            return $output;
        }

        $replace = new ReplaceHtml(
            $this->helperData->getGeneralConfig('storage_id'),
            null,
            $this->helperData->getGeneralConfig('secret')
        );

        return $replace->replaceImages($output);
    }
}
