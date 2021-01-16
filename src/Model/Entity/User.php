<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher; 
use Cake\ORM\TableRegistry;

/**
 * User Entity
 *
 * @property int $id
 * @property int $profile_id
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property string $dni
 * @property string $password
 * @property string $cellphone
 * @property string $address
 *
 * @property \App\Model\Entity\Profile $profile
 */
class User extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'profile_id' => true,
        'name' => true,
        'surname' => true,
        'email' => true,
        'dni' => true,
        'password' => true,
        'cellphone' => true,
        'address' => true,
        'profile' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];

    protected function _setPassword($value)
    {
        if (strlen($value)) {
            $hasher = new DefaultPasswordHasher();
            return $hasher->hash($value);
        }
    }

    /**
     * Obtiene la instancia de un usuario a partir de su id.
     * 
     * @param int $id ID del usuario
     * 
     * @return App\Model\Entity\User Intancia del usuario con los datos del profile.
     */
    public static function get_user(int $id)
    {
        return TableRegistry::get('users')
            ->find('all')
            ->contain('Profiles')
            ->where([
                'users.id' => $id
            ])
            ->first();
    }
}
