<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Method Entity
 *
 * @property int $id
 * @property string $name
 * @property string $controller
 * @property string $method
 *
 * @property \App\Model\Entity\PermissionMethod[] $permission_methods
 */
class Method extends Entity
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
        'name' => true,
        'controller' => true,
        'method' => true,
        'permission_methods' => true,
    ];
}
