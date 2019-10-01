<?php
namespace Godogi\Safepay\Controller\Safepay;

use Magento\Checkout\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Checkout\Model\Cart;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class PostData extends \Magento\Framework\App\Action\Action
{
    protected $_logger;
    protected $_cart;
    protected $_checkoutSession;
    protected $_storeManager;
    protected $_resultJsonFactory;
    protected $_scopeConfig;

    protected $_entryModel;
    protected $_formKeyValidator;

    public function __construct(
        Context $context,
        \Psr\Log\LoggerInterface $logger,
        Session $checkoutSession,
        Cart $cart,
        JsonFactory $resultJsonFactory,
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig,
        \Godogi\Safepay\Model\Entry  $entryModel,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
    ){
        parent::__construct($context);
        $this->_logger = $logger;
        $this->_checkoutSession = $checkoutSession;
        $this->_cart = $cart;
        $this->_resultJsonFactory = $resultJsonFactory;
        $this->_storeManager = $storeManager;
        $this->_scopeConfig = $scopeConfig;
        $this->_entryModel = $entryModel;
        $this->_formKeyValidator = $formKeyValidator;
    }

    public function execute()
    {
        try {
            if (!$this->_formKeyValidator->validate($this->getRequest())) {
                $post_data = array('success' => false, 'message' => 'Are you a Robot ?');
                $result = $this->_resultJsonFactory->create();
                return $result->setData($post_data);
            }else{
                $postEntry = $this->getRequest()->getPost();
                $entry = $this->_entryModel;

                foreach ($postEntry as $key => $value) {
                    if (preg_match('/[^A-Za-z-_:.0-9]/', $value)) // '/[^a-z\d]/i' should also work.
                    {
                        $post_data = array('success' => false, 'message' => 'Are you a Robot ? 23');
                        $result = $this->_resultJsonFactory->create();
                        return $result->setData($post_data);
                    }
                }
                $order = $this->_checkoutSession->getLastRealOrder();
                $orderId = $order->getEntityId();
                $orderIncrement = $order->getIncrementId();
                $orderAmount = $order->getGrandTotal();
                $orderCurrency = $order->getOrderCurrencyCode();
                $entry->setOrderId($orderId);
                $entry->setIncrementId($orderIncrement);
                $entry->setAmount($orderAmount);
                $entry->setClient($postEntry['client']);
                $entry->setUser($postEntry['user']);
                $entry->setCurrency($postEntry['currency']);
                $entry->setFees($postEntry['fees']);
                $entry->setNet($postEntry['net']);
                $entry->setReference($postEntry['reference']);
                $entry->setToken($postEntry['token']);
                $entry->setTracker($postEntry['tracker']);
                $entry->setCreatedAt($postEntry['created_at']);
                $entry->setUpdatedAt($postEntry['updated_at']);
                $entry->save();
                $post_data = array('success' => true , 'order_increment' => $orderIncrement);
                $result = $this->_resultJsonFactory->create();
                return $result->setData($post_data);
            }
        } catch (Exception $e) {
            $this->_logger->info($e->getMessage());
            $post_data = array('success' => false, 'message' => $e->getMessage());
            $result = $this->_resultJsonFactory->create();
            return $result->setData($post_data);
        }
    }
}
