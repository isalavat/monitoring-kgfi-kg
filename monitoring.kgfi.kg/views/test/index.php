<?php include ROOT."/views/layouts/header.php"?>

    
	<div class="container " style="margin-top: 100px;">
            <div class="row" group-id="<?php $groupId?>" semesters="<?php $groupId?>" student-id="<?php $studentId?>">
			
			<div class="tabs col-md-8 col-md-offset-2">
				<ul class="nav nav-tabs">
                                    <?php 
                                        $i = 1; $std_id=1; $status = 4; 
                                        while ($i<=$status): ?>
                                            <li  <?php if ($i == 1) echo 'class="active"'?>>
                                                <a href="<?php echo '#params-'.$std_id.'-'.$i  ?>"   data-toggle="tab" ><?php echo $i; ?>-семестр</a>
                                            </li>
                                    <?php $i++; endwhile;?>    
					
				</ul>
				<div class="tab-content">
                                    <?php $i =1;
                                        while ($i <= $status):?>    
                                            <div class="tab-pane fade <?php if ($i == 1) echo 'in active';?>"  id="<?php echo 'params-'.$std_id.'-'.$i ?>"></div>                                                               
					
                                    <?php 
                                            $i++; 
                                        endwhile;
                                     ?>       
					
				</div>

			</div>
		</div>
	</div>
    <script src="/template/js/jquery-3.1.1.js"></script>    
    <script type="text/javascript" src="/template/js/loader.js"></script>
    <script type="text/javascript" src="/template/js/google-charts-attendance.js"></script>
    <script src="/template/js/bootstrap.js"></script>
  </body>
</html>