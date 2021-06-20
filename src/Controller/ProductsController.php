<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

/**
 * Products Controller
 *
 * @property \App\Model\Table\ProductsTable $Products
 *
 * @method \App\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductsController extends AppController
{
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

  public static function getProductsWithStock($branch = null, $user = null)
  {
    // Start
    $productsTable = TableRegistry::get('products');
    $stock = TableRegistry::get('stock')->find('all', ['conditions' => ['branch_id' => $branch, 'valid_to is null', 'valid_from <=' => date('Y-m-d H:i:s')]])->first();

    if ($stock === true){
      $stock = StockController::createBranch($branch, $user);
    }

    $products = $productsTable->find();
    $products = $products->select([
      "id" => "products.id",
      "name" => "products.name",
      "brand" => "b.name",
      "category" => "c.name",
      "quantity" => "IFNULL(sd.quantity, 0)",
      "sd_id" => "IFNULL(sd.id, 0)",
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
      'table' => 'stock',
      'alias' => 's',
      'type' => 'LEFT',
      'conditions' => ['s.branch_id' => intval($branch), 's.valid_to is null', 's.valid_from <=' => date('Y-m-d H:i:s')],
    ]])->join([[
      'table' => 'stock_details',
      'alias' => 'sd',
      'type' => 'LEFT',
      'conditions' => ["s.id=sd.stock_id", "products.id = sd.product_id"],
    ]]);
    $products = $products->all();
    return $products;
  }

    public static function getProductsWithPrice($branch = null, $user = null)
    {
        // Start
        $productsTable = TableRegistry::get('products');
        $priceList = TableRegistry::get('pricelists')->find('all', ['conditions' => ['branch_id' => $branch, 'valid_to is null', 'valid_from <=' => date('Y-m-d H:i:s')]])->first();

        if ($priceList === true){
        $priceList = PriceListsController::createBranch($branch, $user);
        }

        $products = $productsTable->find();
        $products = $products->select([
        "id" => "products.id",
        "name" => "products.name",
        "brand" => "b.name",
        "category" => "c.name",
        "price" => "IFNULL(pd.price, 0)",
        "pd_id" => "IFNULL(pd.id, 0)",
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
        'table' => 'pricelists',
        'alias' => 'pl',
        'type' => 'LEFT',
        'conditions' => ['pl.branch_id' => intval($branch), 'pl.valid_to is null', 'pl.valid_from <=' => date('Y-m-d H:i:s')],
        ]])->join([[
        'table' => 'pricelist_details',
        'alias' => 'pd',
        'type' => 'LEFT',
        'conditions' => ["pl.id=pd.pricelist_id", "products.id = pd.product_id"],
        ]]);
        $products = $products->all();
        return $products;
    }

    public static function getProductsWithStockAndPrice($branch = null, $user = null)
    {
        $productsTable = TableRegistry::get('products');

        $products = $productsTable->find();
        $products = $products->select([
            "id" => "products.id",
            "name" => "products.name",
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
}
