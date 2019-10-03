<?php
namespace Godogi\Safepay\Block\Adminhtml\Order\View\Tab\Info;

use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Safepay extends \Magento\Sales\Block\Adminhtml\Order\AbstractOrder
{
    protected $_storeManager;
    protected $_scopeConfig;
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
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        $this->_safepayEntryFactory = $safepayEntryFactory;
        $this->_storeManager = $storeManager;
        $this->_scopeConfig = $scopeConfig;
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
    public function validateCallback($tracker) {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $safepayTest = $this->_scopeConfig->getValue(\Godogi\Safepay\Model\SafepayConfigProvider::SAFEPAY_TEST_CONFIG, $storeScope);
        $safepaySandbox = $this->_scopeConfig->getValue(\Godogi\Safepay\Model\SafepayConfigProvider::SAFEPAY_SANDBOX_CONFIG, $storeScope);
        $safepayProduction = $this->_scopeConfig->getValue(\Godogi\Safepay\Model\SafepayConfigProvider::SAFEPAY_PRODUCTION_CONFIG, $storeScope);

  			if($safepayTest) {
  				$url = "https://sandbox.api.getsafepay.com/order/v1/".$tracker;
  			} else {
  				$url = "https://api.getsafepay.com/order/v1/".$tracker;
  			}
  			$ch =  curl_init($url);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
		    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)');
  			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  			$result = curl_exec($ch);
  			if (curl_errno($ch)) {
  			   return false;
  			}
  			curl_close($ch);
  			$result_array = json_decode($result);
  			if(empty($result_array->status->errors)) {
  				$state = $result_array->data->state;
  				if($state === "TRACKER_ENDED") {
  					return true;
  				} else {
  					return false;
  				}
  			} else {
  				return false;
  			}
    }
}
