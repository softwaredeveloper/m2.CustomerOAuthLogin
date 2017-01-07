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
namespace Faonni\CustomerOAuthLogin\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Profile Model
 */
class Profile extends AbstractModel implements IdentityInterface
{
    /**
     * Cache tag
     */	
	const CACHE_TAG = 'FAONNI_CUSTOMER_OAUTH_PROFILE';
	
    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'faonni_customer_oauth_profile';

    /**
     * Parameter name in event
     *
     * In observe method you can use $observer->getEvent()->getObject() in this case
     *
     * @var string
     */
    protected $_eventObject = 'profile';
	
    /**
     * Model cache tag for clear cache in after save and after delete
     *
     * When you use true - all cache will be clean
     *
     * @var string|array|bool
     */
    protected $_cacheTag = self::CACHE_TAG;
	
    /**
     * Model construct that should be used for object initialization
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
		
        $this->_init('Faonni\CustomerOAuthLogin\Model\ResourceModel\Profile');
    }
	
    /**
     * Return unique ID(s) for each object in system
     *
     * @return string[]
     */
    public function getIdentities()
    {
        $tags = [];
        if ($this->getId()) {
            $tags[] = self::CACHE_TAG . '_' . $this->getId();
        }
        return $tags;        
    }
    
    /**
     * Load an object by multiple fields
	 *
     * @param string $fields should be ['column_name_1'=>'value', 'colum_name_2'=>'value']
     * @return Magento\Framework\Model\AbstractModel
     */	
	public function loadByFields($fields)
    {
        $this->_beforeLoadByFields($fields);       
        $this->_getResource()->loadByFields($this, $fields);
        
        $this->_afterLoad();
        $this->setOrigData();
        $this->_hasDataChanges = false;
        $this->updateStoredData();
                
		return $this;
    }
    
    /**
     * Processing object before load data
     *
     * @param string $fields should be ['column_name_1'=>'value', 'colum_name_2'=>'value']
     * @return $this
     */
    protected function _beforeLoadByFields($fields=[])
    {
        $params = ['object' => $this, 'fields' => $fields];
        $this->_eventManager->dispatch('model_load_before', $params);
        
        $params = array_merge($params, $this->_getEventData());
        $this->_eventManager->dispatch($this->_eventPrefix . '_load_before', $params);
        
        return $this;
    }    	    
}
