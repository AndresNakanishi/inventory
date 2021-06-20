<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SecondaryProduct Entity
 *
 * @property int $id
 * @property int $product_id
 * @property int $branch_id
 * @property int $stock
 * @property float $price
 * @property int $created_by
 * @property int $updated_by
 * @property \Cake\I18n\FrozenTime|null $created_at
 * @property \Cake\I18n\FrozenTime|null $updated_at
 *
 * @property \App\Model\Entity\Product $product
 * @property \App\Model\Entity\Branch $branch
 * @property \App\Model\Entity\InventoryLog[] $inventory_log
 */
class SecondaryProduct extends Entity
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
        'product_id' => true,
        'branch_id' => true,
        'stock' => true,
        'price' => true,
        'created_by' => true,
        'updated_by' => true,
        'created_at' => true,
        'updated_at' => true,
        'product' => true,
        'branch' => true,
        'inventory_log' => true,
    ];
}
