
<div class="row users form ">
    <div class="col-md-12">
    <?= $this->Form->create($user,['class'=>'box']) ?>
    <fieldset>
        <legend><?= __('Gerenciar notificações por email') ?></legend>
        <p>Escolhar quando deseja receber notificações por email.</p>
        <?php
            echo $this->Form->input('subscriptionAlert',['class'=>'','label'=> 'Matriculado/Desmatriculado de um curso.','type'=>'checkbox']);
            echo $this->Form->input('createMeetingAlert',['class'=>'','label'=> 'Conferência iniciada.','type'=>'checkbox']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Salvar')) ?>
    <?= $this->Form->end() ?>
    </div>
</div>
