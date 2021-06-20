<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SecondaryProductsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SecondaryProductsTable Test Case
 */
class SecondaryProductsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SecondaryProductsTable
     */
    public $SecondaryProducts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.SecondaryProducts',
        'app.Products',
        'app.Branches',
        'app.InventoryLog',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('SecondaryProducts') ? [] : ['className' => SecondaryProductsTable::class];
        $this->SecondaryProducts = TableRegistry::getTableLocator()->get('SecondaryProducts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SecondaryProducts);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
