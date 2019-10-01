<?php

namespace Godogi\Safepay\Model\ResourceModel\Entry;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Godogi\Safepay\Model\ENtry', 'Godogi\Safepay\Model\ResourceModel\Entry');
	}
}
