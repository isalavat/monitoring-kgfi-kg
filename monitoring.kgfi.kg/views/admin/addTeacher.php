<?php 
    include ROOT.'/views/layouts/header.php';
?>
	<div class="container" style="margin-top: 100px;">
        <div class="row ">

            <div class=" col-sm-4 col-sm-offset-4 padding-right " style="box-shadow: 0px 3px 30px #bbb;">
                
                 <?php  if (isset($errors) && is_array($errors)): ?>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><h4 class="text-danger"> -<?php echo $error; ?></h4></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif?>
                <?php if (!$success):?>
                    <h5 class="text-center text-info">Добавление преподавателя</h5>
                    <hr>
                    <form action="" method="post" >
			
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="ФИО" value="<?php echo $name;?>">
                        </div>
                        
			<div class="form-group">
                            <input type="text" name="login" class="form-control" placeholder="логин" value="<?php echo $login;?>">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="пароль">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password-2" class="form-control" placeholder="Повторить пароль">
                        </div>
			<button class="btn btn-primary" type="submit" name="submit"><i class="fa fa-sign-in"> Добавить</i></button>
                    </form>
                <?php endif;?>
                    
                <br/>
                <br/>
            </div>
        </div>
    </div>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>-->
  <script src="/template/js/jquery-3.1.1.js"></script>  
  <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/template/js/bootstrap.js"></script>
  </body>
</html>