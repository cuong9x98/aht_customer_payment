<?php
namespace AHT\CustomerPayment\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Customer\Model\GroupFactory;
class DisabledPgByCustomergroup implements ObserverInterface
{
    protected $_groupFactory;

    public function __construct(\Psr\Log\LoggerInterface $logger,GroupFactory $groupFactory)
    {
        $this->_logger = $logger;
        $this->_groupFactory = $groupFactory;
    }
    /**
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $result          = $observer->getEvent()->getResult();
        $method_instance = $observer->getEvent()->getMethodInstance();
        $quote           = $observer->getEvent()->getQuote();
        $group = $this->_groupFactory->create();

        $this->_logger->info($method_instance->getCode());
        /* If Cusomer  group is match then work */
        if (null !== $quote) {
            /* Disable All payment gateway  exclude Your payment Gateway*/
            $module = $group->load($quote->getCustomerGroupId());
            if ($method_instance->getCode() == $module->getData('customer_payment')) {
                $result->setData('is_available', true);
            }else {
                $result->setData('is_available', false);
            }
        }


    }
}
