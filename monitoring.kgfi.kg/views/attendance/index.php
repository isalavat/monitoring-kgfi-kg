<?php include ROOT."/views/layouts/header.php"?>

	<div class="container " >
		<div class="row">
                    <div class="col-md-6 col-md-offset-3 block-fade">
                        <h4>&nbsp;&nbsp;Besucherzahl</h4>
                        <hr>
                        <?php for ($i = 0; $i < count($groups); $i++):?>
                        <div class="items items-radius">
                        <h4>&nbsp;&nbsp;<i class="fa fa-graduation-cap fa-1x" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $groups[$i]['name']?></h4>                            
                        &nbsp;&nbsp;<a href="/attendance/show/<?php echo $groups[$i]['id']?>">Besucherzahl</a>
                        </div>
                        <?php endfor; ?>
                        <hr>
                    </div>
                </div>
	</div>

 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>-->
  
 <script src="/template/js/jquery-3.1.1.js"></script>
   
  <!-- Include all compiled plugins (below), or include individual files as needed -->
 <script type="text/javascript" src="/template/js/loader.js"></script>
    
  <script src="/template/js/bootstrap.js"></script>   
  </body>
</html>