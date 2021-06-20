<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use App\Model\Entity\User;
use Cake\ORM\TableRegistry;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
  /**
   * Initialization hook method.
   *
   * Use this method to add common initialization code like loading components.
   *
   * e.g. `$this->loadComponent('Security');`
   *
   * @return void
   */
  public function initialize()
  {
    parent::initialize();

    $this->loadComponent('RequestHandler', [
        'enableBeforeRedirect' => false,
    ]);
    $this->loadComponent('Flash');
    $this->loadComponent('Auth', [
      'authorize' => 'Controller',
      'authenticate' => [
        'Form' => [
          'fields' => [
            'username' => 'dni',
            'password' => 'password'
          ]
        ]
      ],
      'loginAction' => [
        'controller' => 'Users',
        'action' => 'login'
      ],
      'loginRedirect' => [
        'controller' => 'Users',
        'action' => 'dashboard',
      ],
      'logoutRedirect' => [
        'controller' => 'Users',
        'action' => 'login',
      ],
      'authError' => 'No tiene permiso para acceder a la página solicitada.',
    ]);

    /*
      * Enable the following component for recommended CakePHP security settings.
      * see https://book.cakephp.org/3/en/controllers/components/security.html
      */
    //$this->loadComponent('Security');
  }

  public function isAuthorized($user)
  {
    $userProfileID = $this->Auth->user('profile_id');
    $action = $this->request->getParam('action');
    $controller = $this->request->getParam('controller');
    $isAllowed = PermissionsController::isAllowed($userProfileID, $action, $controller);
    if ($isAllowed == true) {
        return true;
    }
    // By default deny access.
    return false;
  }

  public function beforeFilter(Event $event)
  {
    parent::beforeFilter($event);
    if (!is_null($this->Auth->user('id'))) {
      $user = User::get_user($this->Auth->user('id'));
      $userProfileCode = $user->profile->code;
      $this->set('Auth', $this->Auth);
      $this->set('userProfileCode', $userProfileCode);
    }
  }
}
