
<div class="row" >
    <div class="col-sm-12 view">
        <div class="box">
            <h3><?= h($user->name) ?></h3>
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Ações <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><?= $this->Html->link(__('Editar User'), ['action' => 'edit', $user->id]) ?> </li>
                    <li><?= $this->Form->postLink(__('Deletar User'), ['action' => 'delete', $user->id], ['class'=>'text-danger','confirm' => __('Tem certeza que deseja deletar # {0}? Essa ação não pode ser desfeita.', $user->id)]) ?> </li>
                                    </ul>
            </div>
            <table class="table table-striped" >
                                <!-- <div class="col-md-5 col-sm-5"> -->
                                <tr>
                                            <th><?= __($PT_LABELS['name']) ?></th>
                        <td><?= h($user->name) ?></td>
                                            </tr>
                                    <tr>
                                            <th><?= __($PT_LABELS['email']) ?></th>
                        <td><?= h($user->email) ?></td>
                                            </tr>
                                    <tr>
                                            <th><?= __($PT_LABELS['password']) ?></th>
                        <td><?= h($user->password) ?></td>
                                            </tr>
                                    <tr>
                                            <th><?= __($PT_LABELS['token']) ?></th>
                        <td><?= h($user->token) ?></td>
                                            </tr>
                                        <!-- </div> -->
                                                                                <tr>
                        <th><?= __($PT_LABELS['id']) ?></th>
                        <td><?= $this->Number->format($user->id) ?></td>
                    </tr>
                                                                                                                        <tr>
                        <th><?= __($PT_LABELS['isActive']) ?></th>
                        <td><?= $user->isActive ? __('Yes') : __('No'); ?></td>
                    </tr>
                                                                                    
                    <tr>
                        <th><?= __($PT_LABELS['role']) ?></th>
                        <td><?= $this->Text->autoParagraph(h($user->role)) ?></td>
                    </tr>
                                                        </table>
            </div>
        </div>
    </div>

    <!-- <div class="users view col-md-12 col-sm-12"> -->
    
    