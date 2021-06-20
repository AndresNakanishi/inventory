<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InventoryLog Entity
 *
 * @property int $id
 * @property int $secondary_product_id
 * @property int $user_id
 * @property int|null $sale_id
 * @property float $previous_value
 * @property float $delta
 * @property string|null $type
 * @property string|null $action
 * @property \Cake\I18n\FrozenTime|null $changed_at
 *
 * @property \App\Model\Entity\SecondaryProduct $secondary_product
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Sale $sale
 */
class InventoryLog extends Entity
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
        'secondary_product_id' => true,
        'user_id' => true,
        'sale_id' => true,
        'previous_value' => true,
        'delta' => true,
        'type' => true,
        'action' => true,
        'changed_at' => true,
        'secondary_product' => true,
        'user' => true,
        'sale' => true,
    ];
}
