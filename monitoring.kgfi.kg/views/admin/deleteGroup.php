<?php 
    include ROOT.'/views/layouts/header.php';
?>
	<div class="container" style="margin-top: 100px;">
        <div class="row">

            <div class="col-sm-4 col-sm-offset-4 padding-right" style="box-shadow: 0px 3px 30px #bbb;">
                <?php  if (isset($errors) && is_array($errors)): ?>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><h4 class="text-danger"> -<?php echo $error; ?></h4></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif?>
                 
                <?php if (!$success):?>
                
                    <h5 class="text-center text-danger">Удаление группы</h5>
                    <hr>
                    <h4 class="text-center"><?php echo $group['name'] ?></h4>
                    <hr>
                    <form action="" method="post" >
                        
			<button class="btn btn-primary text-center btn-center" type="submit"  name="submit"><i class="fa fa-sign-in">Удалить</i></button>
                    </form>
                    
                <?php endif; ?>
                   
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