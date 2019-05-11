<?php 
    include ROOT.'/views/layouts/header.php';
?>
<div class="container" >
        <div class="row">

            <div class="col-sm-4 col-sm-offset-4 padding-right block-fade">
                
                 <?php if (isset($errors) && is_array($errors)): ?>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li> -<?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif?>
                    <h3>Einloggen</h3>
                    <form action="" method="post" >
			<div class="form-group">
                            <input type="text" name="login" class="form-control" placeholder="Login">
			</div>
			<div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="Password">
			</div>
			<button class="btn btn-primary" type="submit" name="submit"><i class="fa fa-sign-in">Einloggen</i></button>
                    </form>
                
                    
               
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