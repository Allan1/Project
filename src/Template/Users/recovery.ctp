<div class="container-fluid" style="padding-top:50px">
	<div class="row login-register">
		<div class="col-md-6 col-sm-12 ">
			<?= $this->Form->create('',['class'=>'form-signin']);?>
			<h4>Redefinição de senha</h4>
			<?= $this->Form->input('email',['class'=>'form-control','label'=>'Confirme seu email']);?>
			<?= $this->Form->submit('Enviar');?>
			<?= $this->Form->end();?>
		</div>
	</div>
</div>