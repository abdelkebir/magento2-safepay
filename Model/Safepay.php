<?php
namespace Godogi\Safepay\Model;

/**
 * Pay In Store payment method model
 */
class Safepay extends \Magento\Payment\Model\Method\AbstractMethod
{

    /**
     * Payment code
     *
     * @var string
     */
    protected $_code = 'safepaymod';
}
