<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PaymentMethods Model
 *
 * @property \App\Model\Table\SalesTable&\Cake\ORM\Association\HasMany $Sales
 *
 * @method \App\Model\Entity\PaymentMethod get($primaryKey, $options = [])
 * @method \App\Model\Entity\PaymentMethod newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PaymentMethod[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PaymentMethod|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PaymentMethod saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PaymentMethod patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PaymentMethod[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PaymentMethod findOrCreate($search, callable $callback = null, $options = [])
 */
class PaymentMethodsTable extends Table
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

        $this->setTable('payment_methods');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Sales', [
            'foreignKey' => 'payment_method_id',
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
            ->scalar('name')
            ->maxLength('name', 50)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        return $validator;
    }
}
