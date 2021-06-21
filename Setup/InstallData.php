<?php
namespace AHT\CustomerPayment\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    protected $_postFactory;

    public function __construct(\Magento\Customer\Model\GroupFactory $postFactory)
    {
        $this->_postFactory = $postFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {

         $data = [
             'customer_group_code' => "Group A",
             'tax_class_id' => 3,
             'customer_payment'      =>'checkmo'
         ];


         $post = $this->_postFactory->create();
         $post->addData($data)->save();

         $dataa = [
             'customer_group_code' => "Group B",
             'tax_class_id' => 3,
             'customer_payment'      =>'purchaseorder'
         ];


         $post = $this->_postFactory->create();
         $post->addData($dataa)->save();
    }
}
?>
