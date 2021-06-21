<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Sale Entity
 *
 * @property int $id
 * @property int $payment_method_id
 * @property int $product_id
 * @property int $branch_id
 * @property float $amount
 * @property int|null $discount
 * @property float|null $discount_amount
 * @property float|null $quantity
 * @property int|null $status
 * @property int $saled_by
 * @property \Cake\I18n\FrozenTime|null $saled_at
 * @property int|null $updated_by
 * @property \Cake\I18n\FrozenTime|null $updated_at
 * @property string|null $comment
 * @property string|null $reason_for_cancelling
 *
 * @property \App\Model\Entity\PaymentMethod $payment_method
 * @property \App\Model\Entity\Product $product
 * @property \App\Model\Entity\Branch $branch
 * @property \App\Model\Entity\InventoryLog[] $inventory_log
 */
class Sale extends Entity
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
        'payment_method_id' => true,
        'product_id' => true,
        'branch_id' => true,
        'amount' => true,
        'discount' => true,
        'discount_amount' => true,
        'quantity' => true,
        'status' => true,
        'saled_by' => true,
        'saled_at' => true,
        'updated_by' => true,
        'updated_at' => true,
        'comment' => true,
        'reason_for_cancelling' => true,
        'payment_method' => true,
        'product' => true,
        'branch' => true,
        'inventory_log' => true,
    ];

    protected function _getSaleStatus()
    {
        if($this->status === 1){
            return "<span class='badge badge-primary'>Venta</span>";
        } else {
            return "<span class='badge badge-danger'>Cancelada</span>";
        }
    }
}
