<?php

namespace Filejet\FilejetMagento2Plugin\Block;


use Filejet\FilejetMagento2Plugin\Helper\Data;

/**
 * Class Dashboard
 *
 * @author Martin Adamik <martin.adamik@everlution.sk>
 */
class Dashboard extends \Magento\Framework\View\Element\Template
{
    /** @var Data */
    private $helperData;
    /** @var \Magento\Framework\App\Request\Http */
    private $request;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        Data $helperData,
        \Magento\Framework\App\Request\Http $request
    )
    {
        parent::__construct($context);
        $this->helperData = $helperData;
        $this->request = $request;
    }

    public function getStatisticsData($year = null, $month = null)
    {
        $apiKey = $this->helperData->getGeneralConfig('api_key');
        $storageId = $this->helperData->getGeneralConfig('storage_id');

        if (!$apiKey || !$storageId) {
            return null;
        }

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => sprintf(
                'https://twrfq4l8y8.execute-api.eu-west-1.amazonaws.com/prod/stats?apiKey=%s&storageId=%s&year=%s&month=%s',
                $apiKey,
                $storageId,
                $year ?: (new \DateTime())->format('Y'),
                $month ?: (new \DateTime())->format('n')
            )
        ]);
        $resp = curl_exec($curl);
        curl_close($curl);

        $decoded = json_decode($resp, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return [];
        }

        return $decoded;
    }

    public function formatBytes($bytes, $decimals = 2)
    {
        $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' ' . @$size[$factor];
    }

    public function getYear()
    {
        return $this->request->getParam('year', (new \DateTime())->format('Y'));
    }

    public function getMonth()
    {
        return $this->request->getParam('month', (new \DateTime())->format('n'));
    }

    public function isConfigured()
    {
        return $this->helperData->getGeneralConfig('storage_id') && $this->helperData->getGeneralConfig('api_key') && $this->helperData->getGeneralConfig('secret_key');
    }
}
