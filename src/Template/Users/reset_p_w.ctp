<div class="container-fluid" style="padding-top: 50px">
    <div class="row users form login-register">
        <div class="col-md-6">
        <?= $this->Form->create() ?>
        <fieldset>
            <legend><?= __('Defina a nova senha') ?></legend>
            <p> A senha deve ser composta de números e/ou letras, e ter de 6 a 8 caracteres.</p>
            <?php
                echo $this->Form->input('id',['type'=>'hidden','value'=>$user['id']]);
                echo $this->Form->input('password',['class'=>'form-control','label'=> 'Nova senha']);
                echo $this->Form->input('repeatPassword',['class'=>'form-control','label'=> 'Confirme a nova senha','type'=>'password']);                
            ?>
        </fieldset>
        <?= $this->Form->button(__('Enviar')) ?>
        <?= $this->Form->end() ?>
        </div>
    </div>
</div>