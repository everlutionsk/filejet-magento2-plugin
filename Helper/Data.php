<?php

namespace Filejet\FilejetMagento2Plugin\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{

	const XML_PATH_FILEJET = 'filejet/';

	public function getConfigValue($field, $storeId = null)
	{
		return $this->scopeConfig->getValue(
			$field, ScopeInterface::SCOPE_STORE, $storeId
		);
	}

	public function getGeneralConfig($code, $storeId = null)
	{
		return $this->getConfigValue(self::XML_PATH_FILEJET .'general/'. $code, $storeId);
	}

	public function getMutationsConfig($storeId = null)
	{
        $value = $this->getConfigValue('filejet_mutations/general/mutations', $storeId);

        if ($value === null) {
            return [];
        }

        $decoded = json_decode($value, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return [];
        }

        return array_reduce(
            $decoded,
            static function (array $acc, array $item) {
                $acc[$item['className']] = $item['mutation'];
                return $acc;
            },
            []
        );
	}

	public function getIgnoreListConfig($storeId = null)
	{
	    $value = $this->getConfigValue('filejet_ignore_list/general/ignore_list', $storeId);

	    if ($value === null) {
	        return [];
        }

        $decoded = json_decode($value, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return [];
        }

        return array_reduce(
            $decoded,
            static function (array $acc, array $item) {
                $acc[$item['className']] = $item['className'];
                return $acc;
            },
            []
        );
	}

	public function getImageAttributeConfig($storeId = null)
	{
        $value = $this->getConfigValue('filejet_image_attribute/general/image_attribute', $storeId);

        if ($value === null) {
            return [];
        }

        $decoded = json_decode($value, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return [];
        }

        return array_reduce(
            $decoded,
            static function (array $acc, array $item) {
                $acc[$item['imageAttribute']] = $item['imageAttribute'];
                return $acc;
            },
            []
        );
	}

}
