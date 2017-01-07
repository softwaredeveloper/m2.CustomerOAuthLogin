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
namespace Faonni\CustomerOAuthLogin\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Faonni\CustomerOAuthLogin\Helper\Data as CustomerOAuthLoginHelper;
use Faonni\CustomerOAuth\Model\ResourceModel\Provider\Collection as ProviderCollection;

/**
 * CustomerOAuthLogin Block Button
 */
class Button extends Template
{
    /**
     * Helper instance
     *
     * @var \Faonni\CustomerOAuthLogin\Helper\Data
     */
    protected $_helper;
    
    /**
     * Provider collection model
	 *
     * @var Faonni\CustomerOAuth\Model\ResourceModel\Provider\Collection
     */
    protected $_providerCollection;    
    
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Faonni\CustomerOAuthLogin\Helper\Data $helper
     * @param \Faonni\CustomerOAuth\Model\ResourceModel\Provider\Collection $providerCollection
     * @param array $data
     * 
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
		Context $context, 
		CustomerOAuthLoginHelper $helper,
		ProviderCollection $providerCollection,
		array $data = []
	) {
        $this->_helper = $helper;
        $this->_providerCollection = $providerCollection;
        parent::__construct($context, $data);
    }

	/**
	 * Check Popup mode	
	 * 
	 * @return bool
	 */	
 	public function isPopupMode()
	{
		return $this->_helper->isPopupMode();
	}    
}
