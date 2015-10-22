<!DOCTYPE html>
<?php
$cakeDescription = 'Projeto';
?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <?= $this->Html->charset() ?>
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <link rel="icon" href="avatar.ico" type="image/x-icon" />
    <?= $this->Html->css('bootstrap/bootstrap.min.css') ?>
    <?= $this->Html->css('font-awesome-4.4.0/css/font-awesome.min.css') ?>
    <?= $this->Html->css('styles.css') ?>
    <?= $this->Html->css('home.css') ?>
    <style type="text/css">
      body {
        position: relative;
          /*padding-top: 50px;*/
      }      
      body > .alert{
        margin-top: 70px;
      }
    </style>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body data-spy="scroll" data-target="#navbar">
  <nav class="navbar navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button id="mobile-button" type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="glyphicon glyphicon-menu-hamburger"></span>
        </button>
         <?= $this->Html->link('projeto', '#home',['class'=>'navbar-brand scroll-menu']);?>
      </div>
      <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
        <?php if($this->request->session()->read('Auth.User.id')): ?>
          <li><?= $this->Html->link('Painel', ['controller'=>'users'])?></li>
        <?php endif;?>
        <?php if($this->request->params['controller']=='Pages'): ?>
          <li><a href="#sobre" class="scroll-menu">Sobre</a></li>
          <li><a href="#contato" class="scroll-menu">Contato</a></li>
        <?php endif;?>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
          <?php if($this->request->session()->read('Auth.User.id')): ?>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= $this->request->session()->read('Auth.User.email');?><span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><?= $this->Html->link('Minha conta', ['controller'=>'users','action'=>'view']);?></li>
              <li><hr></li>
              <li><?= $this->Html->link('Sair', ['controller'=>'users','action'=>'logout']);?></li>
            </ul>
          <?php else: ?>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Login <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li>
              <?php
                echo $this->Form->create(null,['url'=>['controller'=>'users','action'=>'login'],'class'=>'form-signin']);
                echo '<h4></h4>
                  <!-- <label for="inputEmail" class="sr-only">Email address</label> -->
                  <input name="email" id="inputEmail" class="form-control" placeholder="Email" required="true" type="email">
                  <!-- <label for="signupPassword" class="sr-only">Password</label> -->
                  <input name="password" id="signupPassword" class="form-control" placeholder="Senha" required="true" type="password">
                  ';
                echo $this->Html->link('Esqueceu a senha?', ['controller'=>'users','action'=>'recovery']).
                  '<button class="btn btn-success btn-block" type="submit">Entrar</button>';
                echo  $this->Form->end();
              ?>
              </li>
            </ul>
          </li>
          <?php endif;?>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </nav>

  <!-- <div class="container"> -->
    <?= $this->Flash->render('flash') ?>
  <!-- </div> -->
    <?= $this->fetch('content') ?>  
    

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <?= $this->Html->script('jquery-1.11.3.min.js') ?>
    <?= $this->Html->script('bootstrap/bootstrap.min.js') ?>
    <?= $this->Html->script('jquery.scrollTo.min.js') ?>
    <?= $this->Html->script('scripts.js') ?>
    <!-- <script src="../../dist/js/bootstrap.min.js"></script> -->
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <!-- <script src="../../assets/js/vendor/holder.min.js"></script> -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <!-- <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script> -->
    <script type="text/javascript">
        $('a.scroll-menu').click(function (event) {
          event.preventDefault();
          // console.log($('#navbar').attr('aria-expanded'));  
          if($('#navbar').attr('aria-expanded')=='true'){
            $('#mobile-button').click();
          }
          $.scrollTo($(this).attr('href'),1800,{easing:'easeOutBack'});
        });
    </script>
</body>
</html>
