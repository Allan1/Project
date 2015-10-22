<div class="users index table-responsive box">
    <h2 class="sub-header">User</h2>
    <?= $this->Html->link('Adicionar', ['action'=>'add'],['class'=>'btn btn-primary']);?>
    <table class="table table-striped">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id',$PT_LABELS['id']) ?></th>
            <th><?= $this->Paginator->sort('name',$PT_LABELS['name']) ?></th>
            <th><?= $this->Paginator->sort('email',$PT_LABELS['email']) ?></th>
            <th><?= $this->Paginator->sort('password',$PT_LABELS['password']) ?></th>
            <th><?= $this->Paginator->sort('isActive',$PT_LABELS['isActive']) ?></th>
            <th><?= $this->Paginator->sort('token',$PT_LABELS['token']) ?></th>
            <th class="actions"><?= __('Ações') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $this->Number->format($user->id) ?></td>
            <td><?= h($user->name) ?></td>
            <td><?= h($user->email) ?></td>
            <td><?= h($user->password) ?></td>
            <td><?= h($user->isActive) ?></td>
            <td><?= h($user->token) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('<i class="fa fa-eye"></i>'), ['action' => 'view', $user->id],['class'=>' btn btn-default','escape'=>false,'title'=>'Ver']) ?>
                <?= $this->Html->link(__('<i class="fa fa-pencil"></i>'), ['action' => 'edit', $user->id],['class'=>' btn btn-default','escape'=>false,'title'=>'Editar']) ?>
                <?= $this->Form->postLink(__('<i class="fa fa-remove"></i>'), ['action' => 'delete', $user->id], ['confirm' => __('Tem certeza que deseja apagar # {0}?', $user->id),'class'=>' btn btn-danger btn-outline','escape'=>false,'title'=>'Apagar']) ?>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('próxima') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
