<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

/**
 * SecondaryProducts Controller
 *
 * @property \App\Model\Table\SecondaryProductsTable $SecondaryProducts
 *
 * @method \App\Model\Entity\SecondaryProduct[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SecondaryProductsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['makeTemplate']);
    }

    public function isAuthorized($user)
    {
        return parent::isAuthorized($user);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $profile = $this->Auth->user('profile_id');
        $branch = $this->Auth->user('branch_id');
        $user = $this->Auth->user('id');
        $session = $this->request->getSession();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $searchBranch = intval($data['branch_id']);
            $session->write('is_search','1');
            $session->write('searchedBranch', $searchBranch);
        } else {
            $products = ProductsController::getProductsWithStockAndPrice($branch, $user);
        }

        // Leemos si hay en sesión
        if ($session->read('is_search') == '1') {
            $searchBranch = $session->read('searchedBranch');
            $products = ProductsController::getProductsWithStockAndPrice($searchBranch, $user);
            $this->set('searchedBranch', $searchBranch);
        }


        if($profile !== 1){
            $branches = $this->SecondaryProducts->Branches->find('list', ['conditions' => ['id' => $branch]]);
        } else {
            $branches = $this->SecondaryProducts->Branches->find('list');
        }
        $this->set(compact('branches', 'products'));
        $this->set('title', "Stock y Precios");
    }

    /**
     * View method
     *
     * @param string|null $id Secondary Product id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $branch = $this->Auth->user('branch_id');

        $secondaryProduct = TableRegistry::get('secondary_products')->find()
        ->select([
            "name" => "p.name",
            "branch_id" => "b.id",
            "stock" => "IFNULL(secondary_products.stock, 0)",
            "price" => "IFNULL(secondary_products.price, 0)",
        ])
        ->join([[
            'table' => 'branches',
            'alias' => 'b',
            'type' => 'LEFT',
            'conditions' => ['secondary_products.branch_id=b.id'],
        ]])
        ->join([[
            'table' => 'products',
            'alias' => 'p',
            'type' => 'LEFT',
            'conditions' => ['secondary_products.product_id=p.id'],
        ]])
        ->where(['secondary_products.id' => $id])
        ->first();

        $inventoryLogStock = $this->getInventoryLog($id, "STOCK");
        $inventoryLogPrices = $this->getInventoryLog($id, "PRICE");

        if($branch !== null && $branch !== $secondaryProduct->branch_id){
            $this->Flash->error(__('Denegado'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('secondaryProduct', 'inventoryLogStock', 'inventoryLogPrices'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Secondary Product id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Auth->user('id');

        $secondaryProduct = $this->SecondaryProducts->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $conn = ConnectionManager::get('default');
            $conn->begin();
            $previousPrice = $secondaryProduct->price;
            $previousStock = $secondaryProduct->stock;
            $secondaryProduct = $this->SecondaryProducts->patchEntity($secondaryProduct, $this->request->getData());
            if ($this->SecondaryProducts->save($secondaryProduct)) {
                // Case stock is updated
                if($secondaryProduct->stock != $previousStock){
                    $stockInventoryLog = InventoryLogsController::createInventoryLog($secondaryProduct->id, $user, null, $secondaryProduct->stock, $previousStock, "STOCK", "UPDATE_SINGLE");
                }
                // Case price is updated
                if($secondaryProduct->price != $previousPrice){
                    $priceInventoryLog = InventoryLogsController::createInventoryLog($secondaryProduct->id, $user, null, $secondaryProduct->price, $previousPrice, "PRICE", "UPDATE_SINGLE");
                }
                $conn->commit();
                $this->Flash->success(__('Actualizado correctamente.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Oops... Hubo un problema.'));
        }
        $products = $this->SecondaryProducts->Products->find('list', ['contain' => 'Brands']);
        $this->set(compact('secondaryProduct', 'products'));
        $this->set('title', "Cambio de Precios / Stock Manual");
    }


    /* Download Templates */
    public function downloadTemplate()
    {
        $profile = $this->Auth->user('profile_id');
        $branch = $this->Auth->user('branch_id');
        $user_id = $this->Auth->user('id');

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $detailBranch = intval($data['branch_id']);
            SecondaryProductsController::makeTemplate($detailBranch, $user_id);
        }

        if($profile !== 1){
            $branches = $this->SecondaryProducts->Branches->find('list', ['conditions' => ['id' => $branch]]);
        } else {
            $branches = $this->SecondaryProducts->Branches->find('list');
        }
        $this->set(compact('branches'));
        $this->set('title', "Descargar plantillas de actualización de stock y precio");
    }

    /* Import & Update*/

    public function bulkUpdate()
    {
        $profile = $this->Auth->user('profile_id');
        $branch = $this->Auth->user('branch_id');
        $user = $this->Auth->user('id');

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            if ($branch === null){
                $branch = intval($data['branch_id']);
            }

            $file = $data['file'];

            // Get Sheet Data
            $sheetData = $this->getSheetData($file['tmp_name']);
            $conn = ConnectionManager::get('default');
            $conn->begin();

            // Insert Stock Details
            $saveDetails = $this->saveDetails($sheetData, $branch, $user);

            if($saveDetails === true){
                $conn->commit();
                $this->Flash->success(__('El stock fue actualizado correctamente.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $conn->rollback();
                $this->Flash->error(__('Hubo un problema en tratando de actualizar el stock.'));
            }
        }



        if($profile !== 1){
            $branches = $this->SecondaryProducts->Branches->find('list', ['conditions' => ['id' => $branch]]);
        } else {
            $branches = $this->SecondaryProducts->Branches->find('list');
        }
        $this->set(compact('branches'));
        $this->set('title', "Actualizar Masivamente");
    }

    /** Make Template */

    public static function makeTemplate($branch = null, $user_id = null)
    {
        $tabIndex = 0;
        // Empieza Querie de los datos necesarios

        $products = ProductsController::getProductsWithStockAndPrice($branch, $user_id);

        // Termina Query de los datos necesarios
        // Instancio el objeto para el excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        // Armo el archivo
        $spreadsheet->getProperties()->setCreator('Ricardo Andrés Nakanishi')
        ->setTitle('Plantilla para actualizar el stock');

        /**
         * Confección del Archivo
         **/

        $spreadsheet->setActiveSheetIndex($tabIndex);
        $spreadsheet->getActiveSheet()->setTitle('Stock & Prices');


        // HEADERS
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);
        $sheet->getDefaultColumnDimension()->setWidth(12);
        $sheet->getColumnDimension('B')->setAutoSize(true);

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nombre del Producto');
        $sheet->setCellValue('C1', 'Marca');
        $sheet->setCellValue('D1', 'Categoría');
        $sheet->setCellValue('E1', 'Stock Actual');
        $sheet->setCellValue('F1', 'Precio Unitario Actual');

        $i = 2;
        foreach ($products as $p):
        $sheet->setCellValue('A' . $i, $p->id)
            ->setCellValue('B' . $i, $p->name)
            ->setCellValue('C' . $i, $p->brand)
            ->setCellValue('D' . $i, $p->category)
            ->setCellValue('E' . $i, $p->stock)
            ->setCellValue('F' . $i, $p->price);
        $i++;
        endforeach;

        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xls)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Plantilla para actualizar el stock y los precios del '.date('d-m-Y').'.xls"');

        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }

    /* Save Details */

    private function saveDetails($sheetData, $branch, $user) {
        foreach ($sheetData as $key => $row) {
            $product = $this->SecondaryProducts->find('all')->where(['branch_id' => $branch, 'product_id' => $row['product_id']])->first();
            // IMPORT CASE
            if (!$product) {
                $newProduct = $this->createDetail($row['product_id'], $branch, $row['stock'], $row['price'], $user);
                if($newProduct){
                    $product = $this->SecondaryProducts->find('all')->where(['branch_id' => $branch, 'product_id' => $row['product_id']])->first();
                    // Created by BULK IMPORT || secondary_product_id, user_id, sale_id, actualvalue, previousvalue, type, action
                    $inventoryLog = InventoryLogsController::createInventoryLog($product->id, $user, null, $row['stock'], 0, "STOCK", "BULK_IMPORT");
                    $inventoryLog = InventoryLogsController::createInventoryLog($product->id, $user, null, $row['price'], 0, "PRICE", "BULK_IMPORT");
                }
            } else {
                // PRICE UPDATE CASE
                if($product->price != $row['price']){
                    $updatedProduct = $this->updateDetail($product, $row, $user);
                    $inventoryLog = InventoryLogsController::createInventoryLog($product->id, $user, null, $row['price'], $product->price, "PRICE", "BULK_UPDATE");
                }
                // STOCK UPDATE CASE
                if($product->stock != $row['stock']){
                    $updatedProduct = $this->updateDetail($product, $row, $user);
                    $inventoryLog = InventoryLogsController::createInventoryLog($product->id, $user, null, $row['stock'], $product->stock, "STOCK", "BULK_UPDATE");
                }
            }
        }

        return true;
    }

    // Get Data
    private function getSheetData(string $filePath)
    {
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($filePath);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($filePath);

        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        foreach ($sheetData as $key => $value) {
            //Saltea la cabecera
            if ($key == 1) {
                unset($sheetData[$key]);
                continue;
            }

            if (is_int($sheetData[$key]['A']) or is_float($sheetData[$key]['A'])) {
                $sheetData[$key]['product_id'] = $sheetData[$key]['A'];
                unset($sheetData[$key]['A']);
            } else {
                $stop = true;
            }

            if (isset($sheetData[$key]['B'])) {
                unset($sheetData[$key]['B']);
            } else {
                $stop = true;
            }

            if (isset($sheetData[$key]['C'])) {
                unset($sheetData[$key]['C']);
            } else {
                $stop = true;
            }
            if (isset($sheetData[$key]['D'])) {
                unset($sheetData[$key]['D']);
            } else {
                $stop = true;
            }

            if (isset($sheetData[$key]['E']) and is_int($sheetData[$key]['E'])) {
                $sheetData[$key]['stock'] = $sheetData[$key]['E'];
                unset($sheetData[$key]['E']);
            } else {
                $stop = true;
            }

            if (isset($sheetData[$key]['F']) and is_int($sheetData[$key]['F'])) {
                $sheetData[$key]['price'] = $sheetData[$key]['F'];
                unset($sheetData[$key]['F']);
            } else {
                $stop = true;
            }
        }

        if (!isset($stop)) {
        return $sheetData;
        } else {
        return false;
        }
    }

    // Create Secondary Product
    private function createDetail($product, $branch, $stock, $price, $user)
    {
        $newProduct = $this->SecondaryProducts->newEntity();
        $newProduct->product_id = $product;
        $newProduct->branch_id = $branch;
        $newProduct->stock = $stock;
        $newProduct->price = $price;
        $newProduct->created_by = $user;
        $newProduct->updated_by = $user;
        $newProductSaved = $this->SecondaryProducts->save($newProduct);
        if ($newProductSaved) {
            return true;
        } else {
            $this->Flash->danger(__('Hubo errores en la DB!'));
            return false;
        }
    }

    // Update Secondary Product
    private function updateDetail($product, $row, $user){
        $product->stock = $row['stock'];
        $product->price = $row['price'];
        $product->updated_by = $user;
        $productSaved = $this->SecondaryProducts->save($product);
        if ($productSaved) {
            return true;
        } else {
            $this->Flash->danger(__('Hubo errores en la DB!'));
            return false;
        }
    }

    // Deduce Stock From Sale
    public function deduceStock($id, $stock){
        $stockTable = TableRegistry::get('secondary_products');
        $update = $stockTable->query();
        $update->update()->set(['stock' => $stock])
        ->where(['id' => $id]);
        $updated = $update->execute();
        if ($updated) {
            return true;
        }
        return false;
    }

    /* Get Inventory Log */
    private function getInventoryLog($id, $type){
        $inventoryLogs = TableRegistry::get('inventory_log')
        ->find('all',
        [
            'contain' => ['Users'],
            'conditions' => [
                'secondary_product_id' => $id,
                'type' => $type
            ]
        ])
        ->all();
        return $inventoryLogs;
    }
}
