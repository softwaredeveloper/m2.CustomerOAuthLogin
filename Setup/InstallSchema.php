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
namespace Faonni\CustomerOAuthLogin\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;

/**
 * Faonni_CustomerOAuthLogin InstallSchema
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * Installs DB schema for a module Faonni_Browser
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $connection = $installer->getConnection();
		
        /**
         * Create table 'faonni_customer_oauth_profile'
         */		
        if (!$installer->tableExists('faonni_customer_oauth_profile')) {
            $table = $connection->newTable(
					$installer->getTable('faonni_customer_oauth_profile')
				)
				->addColumn(
                    'profile_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['unsigned' => true, 'identity' => true, 'nullable' => false, 'primary' => true],
                    'Profile Id'
                )
				->addColumn(
                    'provider_id',
                    Table::TYPE_TEXT,
                    50,
                    ['nullable' => false],
                    'Provider'
                )
				->addColumn(
                    'provider_uid',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Provider UID'
                )
				->addColumn(
                    'customer_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['unsigned' => true],
                    'Customer Id'
                )				
				->addColumn(
					'created_at',
					Table::TYPE_TIMESTAMP,
					null,
					['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
					'Creation Time'
				)
				->addColumn(
					'updated_at',
					Table::TYPE_TIMESTAMP,
					null,
					['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
					'Update Time'
				)
				->addIndex(
					$installer->getIdxName('faonni_customer_oauth_profile', ['provider_id']),
					['provider_id']
				)	
				->addIndex(
					$installer->getIdxName('faonni_customer_oauth_profile', ['provider_uid']),
					['provider_uid']
				)									
				->addIndex(
					$installer->getIdxName('faonni_customer_oauth_profile', ['customer_id']),
					['customer_id']
				)					
				->addIndex(
					$installer->getIdxName(
						'faonni_customer_oauth_profile', ['provider_id', 'provider_uid'], AdapterInterface::INDEX_TYPE_UNIQUE),
						['provider_id', 'provider_uid'], ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
				)				
				->addForeignKey(
					$installer->getFkName('faonni_customer_oauth_profile', 'customer_id', 'customer_entity', 'entity_id'),
					'customer_id', $installer->getTable('customer_entity'), 'entity_id', Table::ACTION_CASCADE
				)									
				->setComment(
                    'Faonni Customer Oauth Profile Table'
                );				
            $connection->createTable($table);
		}	                                           
        $installer->endSetup();
    }
}
