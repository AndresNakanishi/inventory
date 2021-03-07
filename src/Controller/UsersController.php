<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
  private $errorMessage = "Ups hubo un problema. Intente más tarde";

  public function initialize()
  {
    parent::initialize();
    $this->Auth->allow(['login','add','createFirstUser']);
  }

  /**
   * Logout method
   *
   * @return auth
   */
  public function login()
  {
    $this->viewBuilder()->setLayout('auth');
    if ($this->request->is('post')) {
      $user = $this->Auth->identify();
      if ($user) {
        $this->Auth->setUser($user);
        return $this->redirect($this->Auth->redirectUrl());
      }
      $this->Flash->error(__('Usuario o Password inválido.'));
    }
  }

  /**
   * Logout method
   *
   * @return auth
   */
  public function logout()
  {
    return $this->redirect($this->Auth->logout());
  }

  /**
   * Dashboard method
   *
   * @return \Cake\Http\Response|null
   */
  public function dashboard()
  {
    $this->set('title', "Dashboard");
  }

  /**
   * Index method
   *
   * @return \Cake\Http\Response|null
   */
  public function index()
  {
    $users = $this->Users->find('all', ['contain' => ['Profiles']]);

    $this->set('title', 'Usuarios');
    $this->set(compact('users'));
  }

  /**
   * View method
   *
   * @param string|null $id User id.
   * @return \Cake\Http\Response|null
   * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
   */
  public function view($id = null)
  {
    $user = $this->Users->get($id, [
      'contain' => ['Profiles'],
    ]);

    $this->set('user', $user);
    $this->set('title', "Ver perfil de $user->name $user->surname");
  }

  /**
   * Add method
   *
   * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
   */
  public function add()
  {
    $user = $this->Users->newEntity();
    if ($this->request->is('post')) {
      $user = $this->Users->patchEntity($user, $this->request->getData());
      $user->avatar = "https://ui-avatars.com/api/?size=256&font-size=0.33&background=FF4E00&color=fff&name=" . $user->name . "%20" . $user->surname;
      if ($this->Users->save($user)) {
        $this->Flash->success(__('Usuario agregado exitosamente.'));
        return $this->redirect(['action' => 'index']);
      }
      $this->Flash->error(__($errorMessage));
    }
    $profiles = $this->Users->Profiles->find('list', ['limit' => 200]);
    $this->set(compact('user', 'profiles'));
    $this->set('title', "Agregar un nuevo usuario");
  }

  /**
   * Edit method
   *
   * @param string|null $id User id.
   * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
   * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
   */
  public function edit($id = null)
  {
    $user = $this->Users->get($id, [
      'contain' => [],
    ]);
    if ($this->request->is(['patch', 'post', 'put'])) {
      $user = $this->Users->patchEntity($user, $this->request->getData());
      $user->avatar = "https://ui-avatars.com/api/?size=256&font-size=0.33&background=FF4E00&color=fff&name=" . $user->name . "%20" . $user->surname;
      if ($this->Users->save($user)) {
        $this->Flash->success(__("El perfil de $user->name $user->surname fue guardado éxitosamente."));
        return $this->redirect(['action' => 'index']);
      }
      $this->Flash->error(__($errorMessage));
    }
    $profiles = $this->Users->Profiles->find('list');
    $this->set(compact('user', 'profiles'));
    $this->set('title', "Editar el perfil de $user->name $user->surname");
  }

  public function profile($id = null)
  {
    $user_id = $_SESSION['Auth']['User']['id'];

    if (strval($user_id) !== $id) {
      $this->Flash->warning(__('No podes ver los datos de otro <b>mostri</b>.'));
      return $this->redirect(['action' => 'profile', $user_id]);
    }
    
    $user = $this->Users->get($id, [
      'contain' => [],
    ]);
    
    $this->set('title', 'Mi Perfil');
    $this->set(compact('user'));
    $this->set('id', $id);
  }

  /**
   * Delete method
   *
   * @param string|null $id User id.
   * @return \Cake\Http\Response|null Redirects to index.
   * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
   */
  public function delete($id = null)
  {
    $this->request->allowMethod(['post', 'delete']);
    $user = $this->Users->get($id);
    if ($this->Users->delete($user)) {
      $this->Flash->success(__('The user has been deleted.'));
    } else {
      $this->Flash->error(__('The user could not be deleted. Please, try again.'));
    }

    return $this->redirect(['action' => 'index']);
  }

  public function createFirstUser()
  {
    $this->autoRender = false;
    $users = $this->Users->find('all')->count();

    if($users == 0){
      $user = $this->Users->newEntity();
      $user->profile_id = 1;
      $user->name = "Ricardo Andres";
      $user->surname = "Nakanishi";
      $user->dni = "40882532";
      $user->email = "andresnakanishi@gmail.com";
      $user->password = $user->dni;
      if ($this->Users->save($user)) {
        return $this->redirect(['action' => 'login']);
      }
    }
    return $this->redirect(['controller' => 'Pages','action' => 'home']);
  }


  public function changePassword($id = null)
  {    
    $user_id = $_SESSION['Auth']['User']['id'];
    
    if (strval($user_id) !== $id) {
        $this->Flash->warning(__('No podes cambiar la pass de otro <b>mostri</b>.'));
        return $this->redirect(['action' => 'changePassword', $user_id]);
    }

    $user = $this->Users->get($id, [
        'contain' => [],
    ]);
    
    if ($this->request->is(['patch', 'post', 'put'])) {
        $data = $this->request->getData();
        $password = $data['new_password'];
        $new_password_confirm = $data['new_password_confirm'];
        $new_password = [
            'password' => $password
        ];
        if ($password !== $new_password_confirm){
            $this->Flash->error(__('Las contraseñas nuevas no coinciden.'));
            return $this->redirect(['action' => 'changePassword', $user_id]);
        }
        
        if  (!(new DefaultPasswordHasher())->check($data['old_password'], $user->password)) {
        
            $this->Flash->error(__('La contraseña anterior es errónea.'));
            return $this->redirect(['action' => 'changePassword', $user_id]);
            
        }
        
        $user = $this->Users->patchEntity($user, $new_password);
        if ($this->Users->save($user)) {
            $this->Flash->success(__('Se ha cambiado la contraseña correctamente.'));
            return $this->redirect(['action' => 'profile', $user_id]);
        } else {
            $this->Flash->error(__('No se ha podido cambiar la contraseña. Por favor conáctese con el administrador del sistema'));
        }
    }

    $this->set('title', 'Cambiar Contraseña');
    $this->set(compact('user'));
    $this->set('id', $id);
  }
}
