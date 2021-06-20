<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Branch $branch
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Branch'), ['action' => 'edit', $branch->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Branch'), ['action' => 'delete', $branch->id], ['confirm' => __('Are you sure you want to delete # {0}?', $branch->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Branches'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Branch'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Pricelists'), ['controller' => 'Pricelists', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pricelist'), ['controller' => 'Pricelists', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sales'), ['controller' => 'Sales', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sale'), ['controller' => 'Sales', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="branches view large-9 medium-8 columns content">
    <h3><?= h($branch->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($branch->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Location') ?></th>
            <td><?= h($branch->location) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($branch->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Pricelists') ?></h4>
        <?php if (!empty($branch->pricelists)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Branch Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Valid From') ?></th>
                <th scope="col"><?= __('Valid To') ?></th>
                <th scope="col"><?= __('Created At') ?></th>
                <th scope="col"><?= __('Updated At') ?></th>
                <th scope="col"><?= __('Created By') ?></th>
                <th scope="col"><?= __('Updated By') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($branch->pricelists as $pricelists): ?>
            <tr>
                <td><?= h($pricelists->id) ?></td>
                <td><?= h($pricelists->branch_id) ?></td>
                <td><?= h($pricelists->name) ?></td>
                <td><?= h($pricelists->valid_from) ?></td>
                <td><?= h($pricelists->valid_to) ?></td>
                <td><?= h($pricelists->created_at) ?></td>
                <td><?= h($pricelists->updated_at) ?></td>
                <td><?= h($pricelists->created_by) ?></td>
                <td><?= h($pricelists->updated_by) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Pricelists', 'action' => 'view', $pricelists->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Pricelists', 'action' => 'edit', $pricelists->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Pricelists', 'action' => 'delete', $pricelists->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pricelists->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Sales') ?></h4>
        <?php if (!empty($branch->sales)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Product Id') ?></th>
                <th scope="col"><?= __('Amount') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col"><?= __('Saled By') ?></th>
                <th scope="col"><?= __('Saled At') ?></th>
                <th scope="col"><?= __('Updated By') ?></th>
                <th scope="col"><?= __('Updated At') ?></th>
                <th scope="col"><?= __('Branch Id') ?></th>
                <th scope="col"><?= __('Comment') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($branch->sales as $sales): ?>
            <tr>
                <td><?= h($sales->id) ?></td>
                <td><?= h($sales->product_id) ?></td>
                <td><?= h($sales->amount) ?></td>
                <td><?= h($sales->status) ?></td>
                <td><?= h($sales->saled_by) ?></td>
                <td><?= h($sales->saled_at) ?></td>
                <td><?= h($sales->updated_by) ?></td>
                <td><?= h($sales->updated_at) ?></td>
                <td><?= h($sales->branch_id) ?></td>
                <td><?= h($sales->comment) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Sales', 'action' => 'view', $sales->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Sales', 'action' => 'edit', $sales->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Sales', 'action' => 'delete', $sales->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sales->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Users') ?></h4>
        <?php if (!empty($branch->users)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Profile Id') ?></th>
                <th scope="col"><?= __('Branch Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Surname') ?></th>
                <th scope="col"><?= __('Email') ?></th>
                <th scope="col"><?= __('Dni') ?></th>
                <th scope="col"><?= __('Password') ?></th>
                <th scope="col"><?= __('Cellphone') ?></th>
                <th scope="col"><?= __('Address') ?></th>
                <th scope="col"><?= __('Avatar') ?></th>
                <th scope="col"><?= __('Active') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($branch->users as $users): ?>
            <tr>
                <td><?= h($users->id) ?></td>
                <td><?= h($users->profile_id) ?></td>
                <td><?= h($users->branch_id) ?></td>
                <td><?= h($users->name) ?></td>
                <td><?= h($users->surname) ?></td>
                <td><?= h($users->email) ?></td>
                <td><?= h($users->dni) ?></td>
                <td><?= h($users->password) ?></td>
                <td><?= h($users->cellphone) ?></td>
                <td><?= h($users->address) ?></td>
                <td><?= h($users->avatar) ?></td>
                <td><?= h($users->active) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Users', 'action' => 'view', $users->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Users', 'action' => 'edit', $users->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Users', 'action' => 'delete', $users->id], ['confirm' => __('Are you sure you want to delete # {0}?', $users->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
