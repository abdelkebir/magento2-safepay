<?php

namespace Godogi\Safepay\Model;

class Entry extends \Magento\Framework\Model\AbstractModel
{
  protected function _construct()
  {
    $this->_init('Godogi\Safepay\Model\ResourceModel\Entry');
  }
}
