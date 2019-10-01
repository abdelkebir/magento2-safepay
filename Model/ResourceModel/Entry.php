<?php

namespace Godogi\Safepay\Model\ResourceModel;

class Entry extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

	public function __construct(
		\Magento\Framework\Model\ResourceModel\Db\Context $context
	){
		parent::__construct($context);
	}

	protected function _construct()
	{
		$this->_init('godogi_safepay_entry', 'entry_id');
	}

}
