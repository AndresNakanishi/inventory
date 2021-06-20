<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InventoryLog Model
 *
 * @property \App\Model\Table\SecondaryProductsTable&\Cake\ORM\Association\BelongsTo $SecondaryProducts
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\SalesTable&\Cake\ORM\Association\BelongsTo $Sales
 *
 * @method \App\Model\Entity\InventoryLog get($primaryKey, $options = [])
 * @method \App\Model\Entity\InventoryLog newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\InventoryLog[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\InventoryLog|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InventoryLog saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InventoryLog patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\InventoryLog[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\InventoryLog findOrCreate($search, callable $callback = null, $options = [])
 */
class InventoryLogTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('inventory_log');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('SecondaryProducts', [
            'foreignKey' => 'secondary_product_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Sales', [
            'foreignKey' => 'sale_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->decimal('previous_value')
            ->requirePresence('previous_value', 'create')
            ->notEmptyString('previous_value');

        $validator
            ->decimal('delta')
            ->requirePresence('delta', 'create')
            ->notEmptyString('delta');

        $validator
            ->scalar('type')
            ->maxLength('type', 10)
            ->allowEmptyString('type');

        $validator
            ->scalar('action')
            ->maxLength('action', 20)
            ->allowEmptyString('action');

        $validator
            ->dateTime('changed_at')
            ->allowEmptyDateTime('changed_at');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['secondary_product_id'], 'SecondaryProducts'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['sale_id'], 'Sales'));

        return $rules;
    }
}
