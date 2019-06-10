<?php

namespace Filejet\FilejetMagento2Plugin\Observer;

use FileJet\External\ReplaceHtml;
use Filejet\FilejetMagento2Plugin\Helper\Data;
use Magento\Framework\App\State;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Renderer
 *
 * @author Martin Adamik <martin.adamik@everlution.sk>
 */
class Renderer implements \Magento\Framework\Event\ObserverInterface
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

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        try {
            if ($this->state->getAreaCode() === 'adminhtml') {
                return $this;
            }
        } catch (LocalizedException $e) {
            return $this;
        }

        if (!$this->helperData->getGeneralConfig('enable')) {
            return $this;
        }

        $response = $observer->getEvent()->getData('response');
        $output = $response->getBody();
        $replace = new ReplaceHtml(
            $this->helperData->getGeneralConfig('storage_id'),
            null,
            $this->helperData->getGeneralConfig('secret_key')
        );

        $body = $replace->replaceImages(
            $output,
            $this->helperData->getIgnoreListConfig(),
            $this->helperData->getMutationsConfig(),
            $this->helperData->getImageAttributeConfig()
        );

        $response->setBody($body);
        $observer->setData('response', $response);

        return $this;
    }
}
