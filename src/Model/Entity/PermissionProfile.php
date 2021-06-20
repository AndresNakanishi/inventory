<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PermissionProfile Entity
 *
 * @property int $id
 * @property int $profiles_id
 * @property int $permission_id
 *
 * @property \App\Model\Entity\Profile $profile
 * @property \App\Model\Entity\Permission $permission
 */
class PermissionProfile extends Entity
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
        'profiles_id' => true,
        'permission_id' => true,
        'profile' => true,
        'permission' => true,
    ];
}
