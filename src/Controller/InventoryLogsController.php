<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * InventoryLogs Controller
 *
 *
 * @method \App\Model\Entity\InventoryLog[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InventoryLogsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow('createInventoryLog');
    }

    public static function createInventoryLog($product, $user, $sale, $actualValue, $previousValue, $type, $action)
    {
        $stockTable = TableRegistry::get('inventory_log');
        $insert = $stockTable->query();
        $insert->insert(['secondary_product_id','user_id','sale_id', 'previous_value', 'delta', 'type', 'action']);
        $insert->values([
            'secondary_product_id' => $product,
            'user_id' => $user,
            'sale_id' => $sale,
            'previous_value' => $previousValue,
            'delta' => $actualValue - $previousValue,
            'type' => $type,
            'action' => $action,
        ]);
        $inserted = $insert->execute();
        if ($inserted) {
            return true;
        } else {
            $this->Flash->danger(__('Hubo errores en la DB!'));
            return false;
        }
    }

    public static function getPriceActionsInventoryLog($product){
        $inventoryLogs = TableRegistry::get('inventory_log')
        ->find('all',
        [
            'conditions' => [
                'secondary_product_id' => $product,
                'type' => "PRICE"
                ]
        ])
        ->contain(['Users'])
        ->all();
        return $inventoryLogs;
    }

    public static function getStockActionsInventoryLog($product){
        $inventoryLogs = TableRegistry::get('inventory_log')
        ->find('all',
        [
            'conditions' => [
                'secondary_product_id' => $product,
                'type' => "STOCK"
            ]
        ])
        ->contain(['Users'])
        ->all();
        return $inventoryLogs;
    }

}
