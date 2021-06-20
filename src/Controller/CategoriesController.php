<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 *
 * @method \App\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CategoriesController extends AppController
{
    private $errorMessage = "Ups hubo un problema. Intente más tarde";

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $categories = $this->Categories->find('all');

        $this->set(compact('categories'));
        $this->set('title', "Categorías");
    }

    public function isAuthorized($user)
    {
      return parent::isAuthorized($user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $category = $this->Categories->newEntity();
        if ($this->request->is('post')) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('Todo correcto.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__("Ups... Hubo un error."));
        }
        $this->set(compact('category'));
        $this->set('title', "Agregar Categoría");
    }

    /**
     * Edit method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('Todo correcto.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__("Ups... Hubo un error."));
        }
        $this->set(compact('category'));
        $this->set('title', "Editar Categoría");
    }

    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
      $this->request->allowMethod(['post', 'delete']);

      $category = $this->Categories->get($id);
      $deleted = false;

      try {
        $deleted = $this->Categories->delete($category);
      } catch(\Exception $e) {

      }
      
      if ($deleted) {
        $this->Flash->success(__('La categoría ha sido eliminada.'));
      } else {
        $this->Flash->error(__('La categoría no ha podido ser eliminada. Ya fue usado en alguna venta y tiene que quedar en los registros.'));
      }

      return $this->redirect(['action' => 'index']);
    }
}
