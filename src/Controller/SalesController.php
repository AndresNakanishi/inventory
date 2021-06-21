<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;

/**
 * Sales Controller
 *
 * @property \App\Model\Table\SalesTable $Sales
 *
 * @method \App\Model\Entity\Sale[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SalesController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['getprice', 'totalDailyIncome', 'allBranchesDailyIncome', 'allDailyIncomes', 'getProducts', 'report']);
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
        $branch = $this->Auth->user('branch_id');

        $sales = $this->Sales->find();
        $sales = $sales->select([
            'Sales.id',
            'Sales.status',
            'Sales.amount',
            'Sales.saled_at',
            'products.name',
            'branches.name'
        ]);
        if ($branch) {
            $sales = $sales->where(['branch_id' => $branch]);
        }
        $sales = $sales->innerJoin('products', 'Sales.product_id = products.id');
        $sales = $sales->innerJoin('branches', 'Sales.branch_id = branches.id');
        $sales = $sales->all();

        $this->set(compact('sales'));
        $this->set('title', "Ventas");
    }

    /**
     * todaySales method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function salesToday()
    {
        $branch = $this->Auth->user('branch_id');

        $sales = $this->Sales->find();
        $sales = $sales->select([
            'Sales.id',
            'Sales.amount',
            'Sales.status',
            'products.name',
        ]);
        if ($branch) {
            $sales = $sales->where(['branch_id' => $branch]);
        }
        $sales = $sales->where(['DATE(saled_at)' => date('Y-m-d')]);
        $sales = $sales->innerJoin('products', 'Sales.product_id = products.id');
        $sales = $sales->all();

        $this->set(compact('sales'));
        $this->set('title', "Ventas del " . date('d-m-y'));
    }

    /**
     * View method
     *
     * @param string|null $id Sale id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $branch = $this->Auth->user('branch_id');
        $profile = $this->Auth->user('profile_id');
        $redirect = $this->referer();
        $salesTable = TableRegistry::get('sales');

        /* Usuarios a Listarse */
        $saleQuery = $salesTable->find();
        $saleQuery->select([
            'sales.id',
            'sales.amount',
            'sales.discount',
            'sales.saled_at',
            'sales.updated_at',
            'sales.status',
            'sales.comment',
            'sales.quantity',
            'sales.reason_for_cancelling',
            's.name',
            's.surname',
            'u.name',
            'u.surname',
            'p.name',
            'b.name',
            'c.name',
            'br.name',
            'br.id',
        ])
        ->join([[
            'table' => 'users',
            'alias' => 's',
            'type' => 'LEFT',
            'conditions' => ['sales.saled_by=s.id'],
        ]])
        ->join([[
            'table' => 'users',
            'alias' => 'u',
            'type' => 'LEFT',
            'conditions' => ['sales.updated_by=u.id'],
        ]])
        ->join([[
            'table' => 'products',
            'alias' => 'p',
            'type' => 'LEFT',
            'conditions' => ['sales.product_id=p.id'],
        ]])
        ->join([[
            'table' => 'branches',
            'alias' => 'br',
            'type' => 'LEFT',
            'conditions' => ['sales.branch_id=br.id'],
        ]])
        ->join([[
            'table' => 'brands',
            'alias' => 'b',
            'type' => 'LEFT',
            'conditions' => ['p.brand_id=b.id'],
        ]])
        ->join([[
            'table' => 'categories',
            'alias' => 'c',
            'type' => 'LEFT',
            'conditions' => ['p.category_id=c.id'],
        ]])
        ->where([
        'sales.id' => $id
        ]);

        $sale = $saleQuery->first();

        if($profile !== 1 && $branch !== intval($sale->br['id'])){
        $this->Flash->error(__('Error'));
        return $this->redirect($redirect);
        }

        $this->set('sale', $sale);
    }

    /**
     * sale method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function sale()
    {
        $user_id = $this->Auth->user('id');
        $branch = $this->Auth->user('branch_id');
        $profile = $this->Auth->user('profile_id');
        $redirect = $this->referer();
        $sale = $this->Sales->newEntity();

        if ($this->request->is('post')) {
            $sale = $this->Sales->patchEntity($sale, $this->request->getData());
            $secProd = TableRegistry::get('secondary_products')->find('all', ['conditions' => ['product_id' => $sale->product_id]])->first();
            $total = $secProd->price * $sale->quantity;
            $sale->discount_amount = $total * ($sale->discount / 100);
            $sale->saled_at = date('Y-m-d H:i:s');
            $sale->updated_at = date('Y-m-d H:i:s');
            $sale->saled_by = $user_id;
            $sale->updated_by = $user_id;
            $sale->amount = $total - $sale->discount_amount;
            if($branch) {
                $sale->branch_id = $branch;
            }
            $sale->status = 1;
            if ($this->Sales->save($sale)) {
                $actualValue = $secProd->stock - $sale->quantity;
                $deduceStock = SecondaryProductsController::deduceStock($secProd->id, $actualValue);
                $stockInventoryLog = InventoryLogsController::createInventoryLog($secProd->id, $user_id, $sale->id, $actualValue, $secProd->stock, "STOCK", "SALE");
                $this->Flash->success(__('Venta realizada!'));

                return $this->redirect(['action' => 'salesToday']);
            }
            $this->Flash->error(__('Ups, no se ha podido realizar la venta.'));
        }

        $products = $this->Sales->Products->find('list')->contain(['Brands'])
        ->leftJoin(
            ['SecondaryProducts' => 'secondary_products'],
            [
                'SecondaryProducts.product_id = Products.id',
            ]);
        $paymentMethods = $this->Sales->PaymentMethods->find('list');
        if(!$branch){
            $branches = $this->Sales->Branches->find('list');
            $this->set(compact('branches'));
        }
        $this->set(compact('sale', 'products', 'paymentMethods','redirect'));
        $this->set('title', "Vender");
    }

    /**
     * Cancel Method
     *
     * @param string|null $id Sale id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function cancel($id = null)
    {
        $user_id = $this->Auth->user('id');
        $branch = $this->Auth->user('branch_id');
        $profile = $this->Auth->user('profile_id');
        $redirect = $this->referer();
        $sale = $this->Sales->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sale = $this->Sales->patchEntity($sale, $this->request->getData());
            $secProd = TableRegistry::get('secondary_products')->find('all', ['conditions' => ['product_id' => $sale->product_id]])->first();
            $sale->updated_by = $user_id;
            $sale->updated_at = date('Y-m-d H:i:s');
            $sale->status = 0;
            if ($this->Sales->save($sale)) {
                $actualValue = $secProd->stock + $sale->quantity;
                $deduceStock = SecondaryProductsController::deduceStock($secProd->id, $actualValue);
                $stockInventoryLog = InventoryLogsController::createInventoryLog($secProd->id, $user_id, $sale->id, $actualValue, $secProd->stock, "STOCK", "CANCEL");
                $this->Flash->success(__('Venta cancelada correctamente.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Ups, no se ha podido modificar la venta.'));
        }

        if($profile !== 1 && $branch !== $sale->branch_id){
            $this->Flash->error(__('No podes cancelar la venta de otra sucursal o una venta que no existe'));
            return $this->redirect($redirect);
        }

        $this->set(compact('sale'));
        $this->set('title', "Editar venta");
    }

    public static function totalDailyIncome($branch = null)
    {
        $today = date('Y-m-d');
        $sales = TableRegistry::get('sales')->find();
        $sales = $sales->select([
            'sales.amount',
        ]);
        $sales = $sales->where(['DATE(sales.saled_at)' => $today, 'sales.status' => 1]);
        if($branch !== null){
            $sales = $sales->where(['sales.branch_id' => $branch]);
        }
        $allDayTotal = $sales->sumOf('amount');

        return $allDayTotal;
    }

    public static function allBranchesDailyIncome()
    {
        $today = date('Y-m-d');
        $sales = TableRegistry::get('sales')->find();
        $sales = $sales->select([
            'total' => 'SUM(sales.amount)',
            'branch_name' => 'br.name',
            'branch_id' => 'br.id']
        );
        $sales = $sales->join([[
            'table' => 'branches',
            'alias' => 'br',
            'type' => 'LEFT',
            'conditions' => ['sales.branch_id=br.id'],
        ]]);
        $sales = $sales->where(['DATE(sales.saled_at)' => $today, 'sales.status' => 1]);
        $sales = $sales->group(['sales.branch_id'])->all();

        return $sales;
    }

    public static function allDailyIncomes($branch = null)
    {
        $sales = TableRegistry::get('sales')->find();
        $sales = $sales->select([
            'total' => 'SUM(sales.amount)',
            'sales_amount' => 'COUNT(sales.id)',
            'date' => 'DATE(sales.saled_at)',
            'branch_name' => 'br.name',
            'branch_id' => 'br.id']
        );
        $sales = $sales->join([[
            'table' => 'branches',
            'alias' => 'br',
            'type' => 'LEFT',
            'conditions' => ['sales.branch_id=br.id'],
        ]]);
        $sales = $sales->where(['sales.status' => 1]);
        if($branch !== null){
            $sales = $sales->where(['sales.branch_id' => $branch]);
        }
        $sales = $sales->group(['DATE(sales.saled_at)', 'sales.branch_id'])->all();

        return $sales;
    }

    private static function getProducts($branch = null, $date = null)
    {
        $from = date('Y-m-d', strtotime('01-' . $date));
        $to = date('Y-m-t', strtotime('01-' . $date));
        $sales = TableRegistry::get('sales')->find();
        $sales = $sales->select([
            'product_name' => 'p.name',
            'product_total' => 'SUM(sales.amount)',
            'product_total_quantities' => 'SUM(sales.quantity)',
            'product_total_kilos' => "p.kilos * SUM(sales.quantity)",
            'brand' => 'b.name',
            'sales_total' => 'COUNT(sales.id)',
            'branch_name' => 'br.name',
            'category' => 'c.name',
            'payment_method' => 'pm.name',
        ]);
        $sales = $sales->join([[
            'table' => 'branches',
            'alias' => 'br',
            'type' => 'LEFT',
            'conditions' => ['sales.branch_id = br.id'],
        ]]);
        $sales = $sales->join([[
            'table' => 'products',
            'alias' => 'p',
            'type' => 'LEFT',
            'conditions' => ['sales.product_id = p.id'],
        ]]);
        $sales = $sales->join([[
            'table' => 'brands',
            'alias' => 'b',
            'type' => 'LEFT',
            'conditions' => ['p.brand_id = b.id'],
        ]]);
        $sales = $sales->join([[
            'table' => 'categories',
            'alias' => 'c',
            'type' => 'LEFT',
            'conditions' => ['p.category_id = c.id'],
        ]]);
        $sales = $sales->join([[
            'table' => 'payment_methods',
            'alias' => 'pm',
            'type' => 'LEFT',
            'conditions' => ['sales.payment_method_id = pm.id'],
        ]]);
        $sales = $sales->where(['sales.status' => 1])->where(['sales.saled_at >=' => $from])
        ->where(['sales.saled_at <=' => $to]);
        if($branch !== null){
            $sales = $sales->where(['sales.branch_id' => $branch]);
        }
        $sales = $sales->group(['sales.product_id', 'sales.branch_id'])->order(['brand'])->all();

        return $sales;
    }

    public static function report($branch = null, $date = null)
    {
        $branch = (int) $branch;
        $tabIndex = 0;
        // Empieza Querie de los datos necesarios

        $thisBranch = BranchesController::getBranch($branch);
        $sales = SalesController::getProducts($branch, $date);

        // Termina Query de los datos necesarios

        // Instancio el objeto para el excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        // Armo el archivo
        $spreadsheet->getProperties()->setCreator('Ricardo Andrés Nakanishi')->setTitle('Informes del '. $date . ' de '. $thisBranch->name);

        /**
        * Confección del Archivo
        **/

        $spreadsheet->setActiveSheetIndex($tabIndex);
        $spreadsheet->getActiveSheet()->setTitle('Período del '. $date);


        // HEADERS
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);

        $sheet->setCellValue('A1', 'Nombre del Producto');
        $sheet->setCellValue('B1', 'Total Vendido ($)');
        $sheet->setCellValue('C1', 'Total Vendido (KG)');
        $sheet->setCellValue('D1', 'Total Vendido (Cantidad)');
        $sheet->setCellValue('E1', 'Marca');
        $sheet->setCellValue('F1', 'Categoría');
        $sheet->setCellValue('G1', 'Método de Pago');
        $sheet->setCellValue('H1', 'Sucursal');

        $i = 2;

        foreach ($sales as $ad):
        $sheet->setCellValue('A' . $i, $ad->product_name)
            ->setCellValue('B' . $i, $ad->product_total)
            ->setCellValue('C' . $i, $ad->product_total_kilos)
            ->setCellValue('D' . $i, $ad->product_total_quantities)
            ->setCellValue('E' . $i, $ad->brand)
            ->setCellValue('F' . $i, $ad->category)
            ->setCellValue('G' . $i, $ad->payment_method)
            ->setCellValue('H' . $i, $ad->branch_name);
        $i++;
        endforeach;

        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xls)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Reporte del '. $date . ' - '. $thisBranch->name.'.xls"');

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
}
