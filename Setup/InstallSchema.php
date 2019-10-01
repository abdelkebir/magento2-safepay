<?php
namespace Godogi\Safepay\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
	public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
	{
		$setup->startSetup();
		if (!$setup->tableExists('godogi_safepay_entry')){
			$table = $setup->getConnection()->newTable($setup->getTable('godogi_safepay_entry'))
			->addColumn(
				'entry_id',
				Table::TYPE_INTEGER,
				null,
				['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
				'ACH Details')
			->addColumn(
				'order_id',
				Table::TYPE_INTEGER,
				null,
				['nullable' => false],
				'Order ID')
			->addColumn(
				'increment_id',
				Table::TYPE_TEXT,
				null,
				['nullable' => false],
				'Increment ID')
			->addColumn(
				'amount',
				Table::TYPE_TEXT,
				null,
				[],
				'Amount')
      ->addColumn(
				'client',
				Table::TYPE_TEXT,
				null,
				[],
				'Client')
      ->addColumn(
				'user',
				Table::TYPE_TEXT,
				null,
				[],
				'User')
      ->addColumn(
				'currency',
				Table::TYPE_TEXT,
				null,
				[],
				'Currency')
      ->addColumn(
				'fees',
				Table::TYPE_TEXT,
				null,
				[],
				'Fees')
      ->addColumn(
				'net',
				Table::TYPE_TEXT,
				null,
				[],
				'Net')
      ->addColumn(
        'reference',
        Table::TYPE_TEXT,
        null,
        [],
        'Reference')
      ->addColumn(
        'token',
        Table::TYPE_TEXT,
        null,
        [],
        'Token')
      ->addColumn(
        'tracker',
        Table::TYPE_TEXT,
        null,
        [],
        'Tracker')
			->addColumn(
				'created_at',
				Table::TYPE_TEXT,
				null,
				[],
				'Created At')
			->addColumn(
				'updated_at',
				Table::TYPE_TEXT,
				null,
				[],
				'Updated At')
			->setComment('Questions and Answers');
			$setup->getConnection()->createTable($table);
		}
		$setup->endSetup();
	}
}
