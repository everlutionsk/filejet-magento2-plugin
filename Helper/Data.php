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
		return $this->getConfigValue('filejet_mutations/general/mutations', $storeId);
	}

	public function getIgnoreListConfig($storeId = null)
	{
		return $this->getConfigValue('filejet_ignore_list/general/ignore_list', $storeId);
	}

	public function getImageAttributeConfig($storeId = null)
	{
		return $this->getConfigValue('filejet_image_attribute/general/image_attribute', $storeId);
	}

}
