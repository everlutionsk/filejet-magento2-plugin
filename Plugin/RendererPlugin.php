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

        $ignoreList = array_reduce(
            json_decode($this->helperData->getIgnoreListConfig(), true),
            function(array $acc, array $item) {
                $acc[$item['className']] = $item['className'];
                return $acc;
                },
            []
        );

        $mutations = array_reduce(
            json_decode($this->helperData->getMutationsConfig(), true),
            function(array $acc, array $item) {
                $acc[$item['className']] = $item['mutation'];
                return $acc;
                },
            []
        );

        $imageAttributes = array_reduce(
            json_decode($this->helperData->getImageAttributeConfig(), true),
            function(array $acc, array $item) {
                $acc[$item['imageAttribute']] = $item['imageAttribute'];
                return $acc;
                },
            []
        );

        $replace = new ReplaceHtml(
            $this->helperData->getGeneralConfig('storage_id'),
            null,
            $this->helperData->getGeneralConfig('secret')
        );

        return $replace->replaceImages(
            $output,
            $ignoreList,
            $mutations,
            $imageAttributes
        );
    }
}
