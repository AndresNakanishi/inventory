<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InventoryLogTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InventoryLogTable Test Case
 */
class InventoryLogTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\InventoryLogTable
     */
    public $InventoryLog;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.InventoryLog',
        'app.SecondaryProducts',
        'app.Users',
        'app.Sales',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('InventoryLog') ? [] : ['className' => InventoryLogTable::class];
        $this->InventoryLog = TableRegistry::getTableLocator()->get('InventoryLog', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->InventoryLog);

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
