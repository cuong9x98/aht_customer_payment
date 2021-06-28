<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AHT\CustomerPayment\Plugin;

use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Customer\Model\GroupFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\FilterBuilder;

class SavePlugin {

  protected $_filterBuilder;
  protected $_groupFactory;
  protected $_groupRepository;
  protected $_searchCriteriaBuilder;

  public function __construct(FilterBuilder $filterBuilder,GroupRepositoryInterface $groupRepository, SearchCriteriaBuilder $searchCriteriaBuilder, GroupFactory $groupFactory)
  {
    $this->_filterBuilder = $filterBuilder;
    $this->_groupRepository = $groupRepository;
    $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
    $this->_groupFactory = $groupFactory;
  }

  public function afterexecute(\Magento\Customer\Controller\Adminhtml\Group\Save $save, $result)
  {
    $active = $save->getRequest()->getParam('customer_payment');
    $code = $save->getRequest()->getParam('code');
    if(empty($code))
      $code = 'NOT LOGGED IN';
    $_filter = [ $this->_filterBuilder->setField('customer_group_code')->setConditionType('eq')->setValue($code)->create() ];
    $customerGroups = $this->_groupRepository->getList($this->_searchCriteriaBuilder->addFilters($_filter)->create())->getItems();
    $customerGroup = array_shift($customerGroups);
    if($customerGroup){
     $group = $this->_groupFactory->create();
     $group->load($customerGroup->getId());
     $group->setCode($customerGroup->getCode());
     $group->setData('customer_payment',$active);
     $group->save();
    }
    return $result;
  }
}
