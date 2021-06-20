<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Branches Controller
 *
 * @property \App\Model\Table\BranchesTable $Branches
 *
 * @method \App\Model\Entity\Branch[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BranchesController extends AppController
{

    // Para inicializar defaults + Load Components
    public function initialize()
    {
      parent::initialize();
    }

    public function isAuthorized($user)
    {
      return parent::isAuthorized($user);
    }

    public static function getBranch($id = null)
    {
      if($id){
        $branch = TableRegistry::get('branches')->find('all', ['where' => ['id' => $id]])->first();
      } else {
        $branch = TableRegistry::get('branches')->find('all');
      }

      return $branch;
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {

      $branches = $this->Branches->find('all');
      $this->set(compact('branches'));
      $this->set('title', "Sucursales");
    }

    /**
     * View method
     *
     * @param string|null $id Branch id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $branch = $this->Branches->get($id, [
            'contain' => ['Pricelists', 'Sales', 'Users'],
        ]);

        $this->set('branch', $branch);

        $this->set('title', "Ver Sucursal");
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
      $branch = $this->Branches->newEntity();
      if ($this->request->is('post')) {
          $branch = $this->Branches->patchEntity($branch, $this->request->getData());
          if ($this->Branches->save($branch)) {
              $this->Flash->success(__("Todo correcto."));

              return $this->redirect(['action' => 'index']);
          }
          $this->Flash->error(__("Ups... Hubo un error!"));
      }
      $this->set(compact('branch'));
      $this->set('title', "Agregar Sucursal");
    }

    /**
     * Edit method
     *
     * @param string|null $id Branch id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $branch = $this->Branches->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $branch = $this->Branches->patchEntity($branch, $this->request->getData());
            if ($this->Branches->save($branch)) {
                $this->Flash->success(__("Todo correcto."));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__("Ups... Hubo un error!"));
        }
        $this->set(compact('branch'));
        $this->set('title', "Editar Sucursal");
    }

    /**
     * Delete method
     *
     * @param string|null $id Branch id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
      $this->request->allowMethod(['post', 'delete']);

      $branch = $this->Branches->get($id);
      $deleted = false;

      try {
        $deleted = $this->Branches->delete($branch);
      } catch(\Exception $e) {

      }

      if ($deleted) {
        $this->Flash->success(__('La sucursal ha sido eliminada.'));
      } else {
        $this->Flash->error(__('La sucursal no ha podido ser eliminada. Ya fue usado en alguna venta y / o tiene algún empleado asociado, tiene que quedar en los registros.'));
      }

      return $this->redirect(['action' => 'index']);
    }
}
