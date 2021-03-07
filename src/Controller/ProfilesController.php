<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Profiles Controller
 *
 * @property \App\Model\Table\ProfilesTable $Profiles
 *
 * @method \App\Model\Entity\Profile[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProfilesController extends AppController
{
  
  private $errorMessage = "Ups hubo un problema. Intente más tarde";

  /**
   * Index method
   *
   * @return \Cake\Http\Response|null
   */
  public function index()
  {
    $profiles = $this->Profiles->find('all');

    $this->set('title', 'Perfiles');
    $this->set(compact('profiles'));
  }

  /**
   * Add method
   *
   * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
   */
  public function add()
  {
    $profile = $this->Profiles->newEntity();
    if ($this->request->is('post')) {
      $profile = $this->Profiles->patchEntity($profile, $this->request->getData());
      if ($this->Profiles->save($profile)) {
        $this->Flash->success(__('El perfil fue guardado correctamente.'));

        return $this->redirect(['action' => 'index']);
      }
      $this->Flash->error(__($errorMessage));
    }
    $this->set(compact('profile'));
    $this->set('title', 'Agregar Perfil');
  }

  /**
   * Edit method
   *
   * @param string|null $id Profile id.
   * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
   * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
   */
  public function edit($id = null)
  {
    $profile = $this->Profiles->get($id, [
      'contain' => [],
    ]);
    if ($this->request->is(['patch', 'post', 'put'])) {
      $profile = $this->Profiles->patchEntity($profile, $this->request->getData());
      if ($this->Profiles->save($profile)) {
        $this->Flash->success(__('El perfil fue guardado correctamente.'));

        return $this->redirect(['action' => 'index']);
      }
      $this->Flash->error(__($errorMessage));
    }
    $this->set(compact('profile'));
    $this->set('title', "Editar perfil: $profile->name");
  }

  /**
   * Delete method
   *
   * @param string|null $id Profile id.
   * @return \Cake\Http\Response|null Redirects to index.
   * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
   */
  public function delete($id = null)
  {
    $this->request->allowMethod(['post', 'delete']);
    $profile = $this->Profiles->get($id);
    if ($this->Profiles->delete($profile)) {
      $this->Flash->success(__('El perfil fue eliminado correctamente.'));
    } else {
      $this->Flash->error(__($errorMessage));
    }

    return $this->redirect(['action' => 'index']);
  }
}
