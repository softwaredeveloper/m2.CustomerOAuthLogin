<?php
/**
 * Faonni
 *  
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade module to newer
 * versions in the future.
 * 
 * @package     Faonni_CustomerOAuthLogin
 * @copyright   Copyright (c) 2017 Karliuka Vitalii(karliuka.vitalii@gmail.com) 
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Faonni\CustomerOAuthLogin\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Profile ResourceModel
 */
class Profile extends AbstractDb
{
    /**
     * Model Initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('faonni_customer_oauth_profile', 'profile_id');
    }
    
    /**
     * Load an object by multiple fields
	 *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @param string $fields should be ['column_name_1'=>'value', 'colum_name_2'=>'value']
     * @return $this
    */	
	public function loadByFields(\Magento\Framework\Model\AbstractModel $object, $fields=[])
    {
        $connection = $this->getConnection();
        
        if ($connection && is_array($fields)) {
            $select = $this->_getLoadByFieldsSelect($fields, $object);
            $data = $connection->fetchRow($select);

            if ($data) {
                $object->setData($data);
            }
        }
        $this->unserializeFields($object);
        $this->_afterLoad($object);

        return $this;        
    }	
        
    /**
     * Retrieve select object for load by fields object data
     *
     * @param array $fields
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return \Magento\Framework\DB\Select
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function _getLoadByFieldsSelect($fields=[], $object)
    {
        $select = $this->getConnection()
			->select()
			->from($this->getMainTable());
        
		foreach ($fields as $field => $value) {
			$field = $this->getConnection()->quoteIdentifier(
				sprintf('%s.%s', $this->getMainTable(), $field)
			);
			$select->where($field . '=?', $value);
		} 
		
        return $select;
    }    
}
