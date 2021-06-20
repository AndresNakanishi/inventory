<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * InventoryLogFixture
 */
class InventoryLogFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'inventory_log';
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'secondary_product_id' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'user_id' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'sale_id' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'previous_value' => ['type' => 'decimal', 'length' => 10, 'precision' => 8, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'delta' => ['type' => 'decimal', 'length' => 10, 'precision' => 8, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'type' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'action' => ['type' => 'string', 'length' => 20, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'changed_at' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => 'current_timestamp()', 'comment' => '', 'precision' => null],
        '_indexes' => [
            'fk_invlog_secprod_idx' => ['type' => 'index', 'columns' => ['secondary_product_id'], 'length' => []],
            'fk_invlog_user_idx' => ['type' => 'index', 'columns' => ['user_id'], 'length' => []],
            'fk_invlog_sale_idx' => ['type' => 'index', 'columns' => ['sale_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_invlog_sale' => ['type' => 'foreign', 'columns' => ['sale_id'], 'references' => ['sales', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_invlog_secprod' => ['type' => 'foreign', 'columns' => ['secondary_product_id'], 'references' => ['secondary_products', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_invlog_user' => ['type' => 'foreign', 'columns' => ['user_id'], 'references' => ['users', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd
    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'secondary_product_id' => 1,
                'user_id' => 1,
                'sale_id' => 1,
                'previous_value' => 1.5,
                'delta' => 1.5,
                'type' => 'Lorem ip',
                'action' => 'Lorem ipsum dolor ',
                'changed_at' => '2021-06-19 23:48:18',
            ],
        ];
        parent::init();
    }
}
