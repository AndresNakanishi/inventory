<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PermissionProfiles Model
 *
 * @property \App\Model\Table\ProfilesTable&\Cake\ORM\Association\BelongsTo $Profiles
 * @property \App\Model\Table\PermissionsTable&\Cake\ORM\Association\BelongsTo $Permissions
 *
 * @method \App\Model\Entity\PermissionProfile get($primaryKey, $options = [])
 * @method \App\Model\Entity\PermissionProfile newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PermissionProfile[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PermissionProfile|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PermissionProfile saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PermissionProfile patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PermissionProfile[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PermissionProfile findOrCreate($search, callable $callback = null, $options = [])
 */
class PermissionProfilesTable extends Table
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

        $this->setTable('permission_profiles');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Profiles', [
            'foreignKey' => 'profiles_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Permissions', [
            'foreignKey' => 'permission_id',
            'joinType' => 'INNER',
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
        $rules->add($rules->existsIn(['profiles_id'], 'Profiles'));
        $rules->add($rules->existsIn(['permission_id'], 'Permissions'));

        return $rules;
    }
}
