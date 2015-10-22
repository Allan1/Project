<div class="container-fluid" style="padding-top: 50px">
	<div class="row login-register" >
		<div class="col-md-6 col-sm-12">
			<?php
                echo $this->Form->create(null,['url'=>['controller'=>'users','action'=>'login'],'class'=>'form-signin']);
                echo '<h4>Login</h4>
                  <!-- <label for="inputEmail" class="sr-only">Email address</label> -->
                  <input name="email" id="inputEmail" class="form-control" placeholder="Email" required="true" autofocus="" type="email">
                  <!-- <label for="signupPassword" class="sr-only">Password</label> -->
                  <input name="password" id="signupPassword" class="form-control" placeholder="Senha" required="true" type="password">';
                echo $this->Html->link('Esqueceu a senha?', ['controller'=>'users','action'=>'recovery']).
                  '<button class="btn btn-success btn-block" type="submit">Entrar</button>
                  <a href="#" class="btn btn-danger btn-block" disabled="true">Entrar com o GMail</a>';
                echo  $this->Form->end();
              ?>
		</div>
	</div>
</div>