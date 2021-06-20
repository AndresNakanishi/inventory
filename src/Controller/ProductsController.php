<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

/**
 * Products Controller
 *
 * @property \App\Model\Table\ProductsTable $Products
 *
 * @method \App\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['downloadImportTemplate', 'downloadUpdateTemplate','bulkUpdate', 'bulkImport', 'getProductsWithStockAndPrice']);
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
        $products = $this->Products->find('all', ['contain' => ['Brands', 'Categories']]);

        $this->set(compact('products'));
        $this->set('title', "Productos");
    }

    /**
     * View method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $product = $this->Products->get($id, [
            'contain' => ['Brands', 'Categories', 'PricelistDetails', 'Sales'],
        ]);

        $this->set('product', $product);
        $this->set('title', $product->name);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $product = $this->Products->newEntity();
        if ($this->request->is('post')) {
            $product = $this->Products->patchEntity($product, $this->request->getData());
            if ($this->Products->save($product)) {
                $this->Flash->success(__('Todo correcto'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__("Hubo un error. Intente más tarde."));
        }
        $brands = $this->Products->Brands->find('list', ['limit' => 200]);
        $categories = $this->Products->Categories->find('list', ['limit' => 200]);
        $this->set(compact('product', 'brands', 'categories'));
        $this->set('title', "Agregar Nuevo Producto");
    }

    /**
     * Edit method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $product = $this->Products->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $product = $this->Products->patchEntity($product, $this->request->getData());
            if ($this->Products->save($product)) {
                $this->Flash->success(__('Todo correcto'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__("Hubo un error. Intente más tarde."));
        }
        $brands = $this->Products->Brands->find('list', ['limit' => 200]);
        $categories = $this->Products->Categories->find('list', ['limit' => 200]);
        $this->set(compact('product', 'brands', 'categories'));
        $this->set('title', "Editar $product->name");
    }

    /**
     * Delete method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $product = $this->Products->get($id);
        $deleted = false;

        try {
        $deleted = $this->Products->delete($product);
        } catch(\Exception $e) {

        }

        if ($deleted) {
            $this->Flash->success(__('El producto ha sido eliminado.'));
        } else {
            $this->Flash->error(__('El producto no ha podido ser eliminada. Ya fue usado en alguna venta y tiene que quedar en los registros.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /* Bulk Import */
    public function bulkImport()
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $file = $data['file'];

            // Get Sheet Data
            $sheetData = $this->getSheetDataForImport($file['tmp_name']);

            $conn = ConnectionManager::get('default');
            $conn->begin();

            // Insert Stock Details
            $saveProducts = $this->saveProducts($sheetData);

            if($saveProducts === true){
                $conn->commit();
                $this->Flash->success(__('El stock fue actualizado correctamente.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $conn->rollback();
                $this->Flash->error(__('Hubo un problema en tratando de actualizar el stock.'));
            }
        }

        $this->set('title', "Importador Masivo de Productos");
    }

    /* Bulk Import */
    public function bulkUpdate()
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $file = $data['file'];

            // Get Sheet Data
            $sheetData = $this->getSheetDataForUpdate($file['tmp_name']);

            $conn = ConnectionManager::get('default');
            $conn->begin();

            // Insert Stock Details
            $saveProducts = $this->saveProducts($sheetData);

            if($saveProducts === true){
                $conn->commit();
                $this->Flash->success(__('El stock fue actualizado correctamente.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $conn->rollback();
                $this->Flash->error(__('Hubo un problema en tratando de actualizar el stock.'));
            }
        }

        $this->set('title', "Actualizador Masivo de Productos");
    }

    /* Download Import Template */
    public static function downloadImportTemplate()
    {
        $tabIndex = 0;

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
        $spreadsheet->getActiveSheet()->setTitle('Productos');


        // HEADERS
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);
        $sheet->getDefaultColumnDimension()->setWidth(12);
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);

        $sheet->setCellValue('A1', 'Nombre del Producto');
        $sheet->setCellValue('B1', 'Kilos');
        $sheet->setCellValue('C1', 'Código de Marca');
        $sheet->setCellValue('D1', 'Código de Categoría');

        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xls)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Plantilla para Importar Productos.xls"');

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

    /* Download Update Template */

    public static function downloadUpdateTemplate()
    {
        $tabIndex = 0;
        // Empieza Querie de los datos necesarios

        $products = TableRegistry::get('products')->find('all')->all();

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
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);
        $sheet->getDefaultColumnDimension()->setWidth(12);

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nombre del Producto');
        $sheet->setCellValue('C1', 'Kilos');
        $sheet->setCellValue('D1', 'Código de Marca');
        $sheet->setCellValue('E1', 'Código de Categoría');

        $i = 2;
        foreach ($products as $p):
        $sheet->setCellValue('A' . $i, $p->id)
            ->setCellValue('B' . $i, $p->name)
            ->setCellValue('C' . $i, $p->kilos)
            ->setCellValue('D' . $i, $p->brand_id)
            ->setCellValue('E' . $i, $p->category_id);
        $i++;
        endforeach;

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xls)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Plantilla para Actualizar Productos.xls"');

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

    /* NO NEED FOR PERMITIONS */

    /* Get Product With Stocks and Price */

    public static function getProductsWithStockAndPrice($branch = null, $user = null)
    {
        $productsTable = TableRegistry::get('products');

        $products = $productsTable->find();
        $products = $products->select([
            "id" => "products.id",
            "name" => "products.name",
            "kilos" => "products.kilos",
            "brand" => "b.name",
            "category" => "c.name",
            "stock" => "IFNULL(sp.stock, 0)",
            "price" => "IFNULL(sp.price, 0)",
            "sp_id" => "IFNULL(sp.id, 0)",
        ])->join([[
            'table' => 'brands',
            'alias' => 'b',
            'type' => 'LEFT',
            'conditions' => ['products.brand_id=b.id'],
        ]])->join([[
            'table' => 'categories',
            'alias' => 'c',
            'type' => 'LEFT',
            'conditions' => ['products.category_id=c.id'],
        ]])->join([[
            'table' => 'secondary_products',
            'alias' => 'sp',
            'type' => 'LEFT',
            'conditions' => ['sp.branch_id' => intval($branch), 'sp.product_id = products.id'],
        ]]);
        $products = $products->all();
        return $products;
    }

    /* Get Sheet Data to Import */
    private function getSheetDataForImport($filePath){
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

            if (isset($sheetData[$key]['A'])) {
                $sheetData[$key]['name'] = $sheetData[$key]['A'];
                unset($sheetData[$key]['A']);
            } else {
                $stop = true;
            }

            if (isset($sheetData[$key]['B'])) {
                $sheetData[$key]['kilos'] = $sheetData[$key]['B'];
                unset($sheetData[$key]['B']);
            } else {
                $stop = true;
            }

            if (isset($sheetData[$key]['C'])) {
                $sheetData[$key]['brand_id'] = $sheetData[$key]['C'];
                unset($sheetData[$key]['C']);
            } else {
                $stop = true;
            }
            if (isset($sheetData[$key]['D'])) {
                $sheetData[$key]['category_id'] = $sheetData[$key]['D'];
                unset($sheetData[$key]['D']);
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

    /* Get Sheet Data to Update */
    private function getSheetDataForUpdate($filePath){
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

            if (isset($sheetData[$key]['A'])) {
                $sheetData[$key]['id'] = $sheetData[$key]['A'];
                unset($sheetData[$key]['A']);
            } else {
                $stop = true;
            }

            if (isset($sheetData[$key]['B'])) {
                $sheetData[$key]['name'] = $sheetData[$key]['B'];
                unset($sheetData[$key]['B']);
            } else {
                $stop = true;
            }

            if (isset($sheetData[$key]['C'])) {
                $sheetData[$key]['kilos'] = $sheetData[$key]['C'];
                unset($sheetData[$key]['C']);
            } else {
                $stop = true;
            }
            if (isset($sheetData[$key]['D'])) {
                $sheetData[$key]['brand_id'] = $sheetData[$key]['D'];
                unset($sheetData[$key]['D']);
            } else {
                $stop = true;
            }
            if (isset($sheetData[$key]['E'])) {
                $sheetData[$key]['category_id'] = $sheetData[$key]['E'];
                unset($sheetData[$key]['E']);
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

    /* Save Products */
    private function saveProducts($products){
        foreach ($products as $key => $row) {
            if (!isset($row['id'])) {
                // IMPORT CASE
                $insertProduct = $this->insertProducts($row['name'], $row['kilos'], $row['brand_id'], $row['category_id']);
            } else {
                // UPDATE CASE
                $product = $this->Products->find('all')->where(['id' => $row['id']])->first();
                $updateProduct = $this->updateProducts($product, $row);
            }
        }
        return true;
    }

    /* Insert Products */
    private function insertProducts($name, $kilos, $brand, $category)
    {
        $newProduct = $this->Products->newEntity();
        $newProduct->name = $name;
        $newProduct->kilos = $kilos;
        $newProduct->brand_id = $brand;
        $newProduct->category_id = $category;
        $newProductSaved = $this->Products->save($newProduct);
        if ($newProductSaved) {
            return true;
        } else {
            $this->Flash->danger(__('Hubo errores en la DB!'));
            return false;
        }
    }

    /* Update Products */
    private function updateProducts($product, $row){
        $product->name = $row['name'];
        $product->kilos = $row['kilos'];
        $product->brand_id = $row['brand_id'];
        $product->category_id = $row['category_id'];
        $productSaved = $this->Products->save($product);
        if ($productSaved) {
            return true;
        } else {
            $this->Flash->danger(__('Hubo errores en la DB!'));
            return false;
        }
    }
}
