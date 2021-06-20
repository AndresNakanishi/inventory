<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Product Entity
 *
 * @property int $id
 * @property string $name
 * @property float|null $kilos
 * @property int|null $active
 * @property int $brand_id
 * @property int $category_id
 *
 * @property \App\Model\Entity\Brand $brand
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\PricelistDetail[] $pricelist_details
 * @property \App\Model\Entity\Sale[] $sales
 * @property \App\Model\Entity\SecondaryProduct[] $secondary_products
 * @property \App\Model\Entity\StockDetail[] $stock_details
 */
class Product extends Entity
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
        'kilos' => true,
        'active' => true,
        'brand_id' => true,
        'category_id' => true,
        'brand' => true,
        'category' => true,
        'pricelist_details' => true,
        'sales' => true,
        'secondary_products' => true,
        'stock_details' => true,
    ];

    protected function _getDisplayProduct()
    {
        return 'Producto: ' . $this->name . ' | Kilos: '. $this->kilos . ' | Marca: '.$this->brand->name;
    }
}
