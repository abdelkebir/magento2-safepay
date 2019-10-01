<?php
namespace Godogi\Safepay\Model;

class SafepayConfigProvider implements \Magento\Checkout\Model\ConfigProviderInterface
{
    const SAFEPAY_TEST_CONFIG = 'payment/safepaymod/test';
    const SAFEPAY_SANDBOX_CONFIG = 'payment/safepaymod/sandbox_key';
    const SAFEPAY_PRODUCTION_CONFIG = 'payment/safepaymod/production_key';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ){
        $this->_scopeConfig = $scopeConfig;
    }

    public function getConfig()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $safepayTest = $this->_scopeConfig->getValue(self::SAFEPAY_TEST_CONFIG, $storeScope);
        $safepaySandbox = $this->_scopeConfig->getValue(self::SAFEPAY_SANDBOX_CONFIG, $storeScope);
        $safepayProduction = $this->_scopeConfig->getValue(self::SAFEPAY_PRODUCTION_CONFIG, $storeScope);

        return [
            'key' => 'safepaymod',
            'safepay_sandbox_key' => $safepaySandbox,
            'safepay_production_key' => $safepayProduction,
            'safepay_test' => $safepayTest
        ];
    }
}
