
<div class="row users form ">
    <div class="col-md-12">
    <?= $this->Form->create($user,['class'=>'box']) ?>
    <fieldset>
        <legend><?= __('Edit User') ?></legend>
        <?php
            echo $this->Form->input('name',['class'=>'form-control','label'=> $PT_LABELS['name']]);
            echo $this->Form->input('email',['class'=>'form-control','label'=> $PT_LABELS['email']]);
            echo $this->Form->input('password',['class'=>'form-control','label'=> $PT_LABELS['password']]);
            echo $this->Form->input('role',['class'=>'form-control','label'=> $PT_LABELS['role']]);
            echo $this->Form->input('isActive',['class'=>'form-control','label'=> $PT_LABELS['isActive']]);
            echo $this->Form->input('token',['class'=>'form-control','label'=> $PT_LABELS['token']]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Enviar')) ?>
    <?= $this->Form->end() ?>
    </div>
</div>
