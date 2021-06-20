<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Brands Controller
 *
 * @property \App\Model\Table\BrandsTable $Brands
 *
 * @method \App\Model\Entity\Brand[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BrandsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
      $brands = $this->Brands->find('all');

      $this->set(compact('brands'));
      $this->set('title', "Marcas");
    }

    public function isAuthorized($user)
    {
      return parent::isAuthorized($user);
    }

    /**
     * View method
     *
     * @param string|null $id Brand id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
      $brand = $this->Brands->get($id, [
        'contain' => ['Products'],
      ]);

      $this->set('brand', $brand);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
      $brand = $this->Brands->newEntity();
      if ($this->request->is('post')) {
        $brand = $this->Brands->patchEntity($brand, $this->request->getData());
        if ($this->Brands->save($brand)) {
          $this->Flash->success(__("Todo correcto"));

          return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__("Ups. Hubo un problema."));
      }
      $this->set(compact('brand'));
      $this->set('title', "Agregar Marca");
    }

    /**
     * Edit method
     *
     * @param string|null $id Brand id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
      $brand = $this->Brands->get($id, [
        'contain' => [],
      ]);
      if ($this->request->is(['patch', 'post', 'put'])) {
        $brand = $this->Brands->patchEntity($brand, $this->request->getData());
        if ($this->Brands->save($brand)) {
          $this->Flash->success(__("Todo correcto"));

          return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__("Ups. Hubo un problema."));
      }
      $this->set(compact('brand'));
      $this->set('title', "Editar Marca");
    }

    /**
     * Delete method
     *
     * @param string|null $id Brand id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
      $this->request->allowMethod(['post', 'delete']);

      $brand = $this->Brands->get($id);
      $deleted = false;

      try {
        $deleted = $this->Brands->delete($brand);
      } catch(\Exception $e) {

      }
      
      if ($deleted) {
        $this->Flash->success(__('La marca ha sido eliminada.'));
      } else {
        $this->Flash->error(__('La marca no ha podido ser eliminada. Ya fue usado en alguna venta y tiene que quedar en los registros.'));
      }

      return $this->redirect(['action' => 'index']);
    }
}
