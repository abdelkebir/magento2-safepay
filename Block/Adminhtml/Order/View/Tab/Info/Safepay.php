<?php

namespace Godogi\Safepay\Block\Adminhtml\Order\View\Tab\Info;

class Safepay extends \Magento\Sales\Block\Adminhtml\Order\AbstractOrder
{
    protected $_safepayEntryFactory;
    /**
     * Constructor
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Registry $registry
     * @param \Godogi\Safepay\Model\EntryFactory $safepayEntryFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Sales\Helper\Admin $adminHelper,
        \Godogi\Safepay\Model\EntryFactory $safepayEntryFactory,
        array $data = []
    ) {
        $this->_safepayEntryFactory = $safepayEntryFactory;
        parent::__construct($context, $registry, $adminHelper, $data);
    }

    public function getOrderId(){
        return $this->getOrder()->getId();
    }

    public function getSafepayEntry(){
        $safepayEntryCollection = $this->_safepayEntryFactory->create()->getCollection();
        $safepayEntryCollection->addFieldToFilter('order_id', array('eq' => $this->getOrderId()));
        return $safepayEntryCollection->getFirstItem()->getData();
    }
    public function getPaymentMethod(){
        $order = $this->getOrder();
        $payment = $order->getPayment();
        $method = $payment->getMethodInstance();
        $methodTitle = $method->getTitle();
        return $payment->getMethod();
    }
}
