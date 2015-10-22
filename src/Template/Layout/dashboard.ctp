<?php
use Cake\Routing\Router;
$cakeDescription = 'Projeto';
?>
<!DOCTYPE html>
<html lang="en">
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
        <?= $title ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <link rel="icon" href="avatar.ico" type="image/x-icon" />
    <?= $this->Html->css('bootstrap/bootstrap.min.css') ?>
    <?= $this->Html->css('font-awesome-4.4.0/css/font-awesome.min.css') ?>
    <?= $this->Html->css('dashboard.css') ?>
    <?= $this->Html->css('styles.css') ?>
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
  </head>

  <body>

    <nav class="navbar navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="glyphicon glyphicon-menu-hamburger"></span>
        </button>
        <?= $this->Html->link('Projeto', '/',['class'=>'navbar-brand']);?>
      </div>
      <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
          <?php if($this->request->session()->read('Auth.User.id')): ?>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= $this->request->session()->read('Auth.User.email');?><span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><?= $this->Html->link('Minha conta', ['controller'=>'users','action'=>'view']);?></li>
              <li role="separator" class="divider"></li>
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
                  <input name="email" id="inputEmail" class="form-control" placeholder="Email" required="true" autofocus="" type="email">
                  <!-- <label for="signupPassword" class="sr-only">Password</label> -->
                  <input name="password" id="signupPassword" class="form-control" placeholder="Senha" required="true" type="password">
                  ';
                echo $this->Html->link('Esqueceu a senha?', ['controller'=>'users','action'=>'recovery']).
                  '<button class="btn btn-success btn-block" type="submit">Entrar</button>
                  <a href="#" class="btn btn-danger btn-block" disabled="true">Entrar com o GMail</a>';
                echo  $this->Form->end();
              ?>
              </li>
            </ul>
          <?php endif;?>
          </li>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </nav>


    <div class="container-fluid">
      <div class="row">
        
        <div class="col-sm-3 col-md-3 sidebar">
          
        </div>

        <div id="content" class="col-sm-9 col-sm-offset-3 col-md-9 col-md-offset-3 main"> 
          
          <?= $this->Flash->render() ?>
          <?= $this->fetch('content') ?>  
        </div>

      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <?= $this->Html->script('jquery-1.11.3.min.js') ?>
    <?= $this->Html->script('bootstrap/bootstrap.min.js') ?>
    <?= $this->Html->script('scripts.js') ?>
    
    <script type="text/javascript">
      // assigns active class to current menu item
      var controller = "<?php echo ($this->request->params['controller']); ?>";
      var base = "<?php echo $this->request->base; ?>";
      var fullBase = "<?php echo Router::url('/', true); ?>";
      var userStr = '<?php echo json_encode($this->request->session()->read("Auth.User")); ?>';
      // console.log(base);
      var user = $.parseJSON(userStr);
      // console.log($('ul.nav-sidebar > li > a[data-target="'+controller+'"]'))
      $('#navbar li[data-target="'+controller+'"]').addClass('active');

    </script>
  </body>
</html>
