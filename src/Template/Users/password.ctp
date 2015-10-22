
<div class="row users form ">
    <div class="col-md-12">
    <?= $this->Form->create(null,['class'=>'box']) ?>
    <fieldset>
        <legend><?= __('Editar senha') ?></legend>
        <p> A senha deve ser composta de números e/ou letras, e ter de 6 a 8 caracteres.</p>
        <?php
            echo $this->Form->input('oldPassword',['class'=>'form-control','label'=> 'Senha atual','type'=>'password']);
            echo $this->Form->input('password',['class'=>'form-control','label'=> 'Nova senha']);
            echo $this->Form->input('repeatPassword',['class'=>'form-control','label'=> 'Confirme a nova senha','type'=>'password']);
            
        ?>
    </fieldset>
    <?= $this->Form->button(__('Enviar')) ?>
    <?= $this->Form->end() ?>
    </div>
</div>
