<?php include ROOT."/views/layouts/header.php"?>

	<div class="container " >
		<div class="row">
                    <div class="col-md-8 col-md-offset-2 block-fade">
                        <hr>
                        <h4 class='text-center text-primary' ><?php echo $name; ?></h4>
                        <?php for ($i = 0; $i < count($months); $i++):?>
                            
                        <div class="attendance month">
                            <hr>
                            <h4><?php echo $m[$months[$i]] ;?></h4>
                            <a class="days cursor_ italic" group-id = '<?php echo $groupId?>' month='<?php echo $months[$i]; ?>'>Days</a>
                            <div month ="<?php echo $months[$i]; ?>"></div>
                            <hr>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>
	</div>

 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>-->
  
 <script src="/template/js/jquery-3.1.1.js"></script>
   
  <!-- Include all compiled plugins (below), or include individual files as needed -->
 <script type="text/javascript" src="/template/js/loader.js"></script>
    
  <script src="/template/js/bootstrap.js"></script>   
  <script src="/template/js/attendance/charts.js"></script>   
</body>
</html>