<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Auth\DefaultPasswordHasher;
use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['login', 'logout', 'createFirstUser']);
    }

    public function isAuthorized($user)
    {
        return parent::isAuthorized($user);
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
        $profile = $this->Auth->user('profile_id');
        $branch = $this->Auth->user('branch_id');
        $active = $this->Auth->user('active');

        if($active !== 1){
            $this->Flash->error(__('El usuario está deshabilitado.'));
            return $this->redirect($this->Auth->logout());
        }

        if($profile === 1){
            return $this->redirect(['action' => 'dashboardAdmin']);
        } elseif ($profile === 2){
            return $this->redirect(['action' => 'dashboardPartners']);
        }

        $allTotalDay = SalesController::totalDailyIncome($branch);
        $products = ProductsController::getProductsWithStockAndPrice($branch);

        $this->set(compact('allTotalDay', 'products'));
        $this->set('title', "Dashboard");
    }

    /**
     * Dashboard method
     *
     * @return \Cake\Http\Response|null
     */
    public function dashboardPartners()
    {
        $branch = $this->Auth->user('branch_id');
        $allTotalDay = SalesController::totalDailyIncome($branch);
        $allDays = SalesController::allDailyIncomes($branch);

        $this->set(compact('allTotalDay', 'allDays'));
        $this->set('title', "Dashboard Socios");
    }

    /**
     * Dashboard method
     *
     * @return \Cake\Http\Response|null
     */
    public function dashboardAdmin()
    {
        $totalDailyIncome = SalesController::totalDailyIncome();
        $branches = SalesController::allBranchesDailyIncome();
        $allDays = SalesController::allDailyIncomes();

        $this->set(compact('totalDailyIncome', 'branches','allDays'));
        $this->set('title', "Dashboard Administrador");
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $branch = $this->Auth->user('branch_id');
        if($branch !== null){
            $users = $this->Users->find('all', ['contain' => ['Profiles', 'Branches']])->where(['branch_id' => $branch]);
        } else {
            $users = $this->Users->find('all', ['contain' => ['Profiles', 'Branches']]);
        }

        $this->set('title', 'Usuarios');
        $this->set(compact('users'));
    }


    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function reports()
    {
        $branch = $this->Auth->user('branch_id');
        $profile = $this->Auth->user('profile_id');
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $date = $data['date'];
            if(isset($data['branch_id']) && $data['branch_id'] !== null){
                $branch = $data['branch_id'];
            }
            $reports = SalesController::report($branch, $date);
        }

        // Ser variables
        if(($branch == null && $profile == 1) || $profile == 1){
            $branches = $this->Users->Branches->find('list');
            $this->set('branches', $branches);
        }
        $this->set('title', 'Reportes');
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
        $branch = $this->Auth->user('branch_id');
        $redirect = $this->referer();

        $user = $this->Users->get($id, [
            'contain' => ['Profiles', 'Branches'],
        ]);

        if($branch !== $user->branch_id){
            $this->Flash->error(__('Error'));
            return $this->redirect($redirect);
        }

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
        $branch = $this->Auth->user('branch_id');
        $profile = $this->Auth->user('profile_id');
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $user->avatar = "https://ui-avatars.com/api/?size=256&font-size=0.33&background=6f42c1&color=fff&name=" . $user->name . "%20" . $user->surname;
            $user->active = 1;
            $user->password = $user->dni;
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Usuario agregado exitosamente.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__("No se pudo guardar."));
        }
        if($profile === 1){
            $profiles = $this->Users->Profiles->find('list');
        } else {
            $profiles = $this->Users->Profiles->find('list')->where(['id !=' => 1]);
        }
        if($profile === 1){
            $branches = $this->Users->Branches->find('list');
        } else {
            $branches = $this->Users->Branches->find('list')->where(['id' => $branch]);
        }
        $this->set(compact('user', 'profiles', 'branches'));
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
        $branch = $this->Auth->user('branch_id');
        $profile = $this->Auth->user('profile_id');
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $user->avatar = "https://ui-avatars.com/api/?size=256&font-size=0.33&background=6f42c1&color=fff&name=" . $user->name . "%20" . $user->surname;
            if ($this->Users->save($user)) {
                $this->Flash->success(__("El perfil de $user->name $user->surname fue guardado éxitosamente."));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__("Ups... Hubo un error."));
        }
        if($profile === 1){
            $profiles = $this->Users->Profiles->find('list');
        } else {
            $profiles = $this->Users->Profiles->find('list')->where(['id !=' => 1]);
        }
        if($profile === 1){
            $branches = $this->Users->Branches->find('list');
        } else {
            $branches = $this->Users->Branches->find('list')->where(['id' => $branch]);
        }
        $this->set(compact('user', 'profiles', 'branches'));
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
        $deleted = false;

        if ($user->active == 0) {
            $user->active = 1;
        } else {
            $user->active = 0;
        }

        try {
            $deleted = $this->Users->save($user);
        } catch(\Exception $e) {

        }

        if ($deleted) {
            if ($user->active == 0) {
                $this->Flash->success(__('El usuario ha sido deshabilitado.'));
            } else {
                $this->Flash->success(__('El usuario ha sido habilitado.'));
            }
        } else {
            if ($user->active == 0) {
                $this->Flash->error(__('El usuario no ha podido ser habilitado. Por favor, intente nuevamente.'));
            } else {
                $this->Flash->error(__('El usuario no ha podido ser deshabilitado. Por favor, intente nuevamente.'));
            }
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
            $user->active = 1;
            $user->dni = "40882532";
            $user->email = "andresnakanishi@gmail.com";
            $user->avatar = "https://ui-avatars.com/api/?size=256&font-size=0.33&background=6f42c1&color=fff&name=" . $user->name . "%20" . $user->surname;
            $user->password = $user->dni;
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Usuario administrador creado!'));
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
