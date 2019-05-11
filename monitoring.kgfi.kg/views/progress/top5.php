<?php include ROOT."/views/layouts/header.php"?>

    
	<div class="container " >
            <div class="row block-fade" id="group"  group-id="<?php echo $groupId?>" semesters="<?php echo $currentSemester?>" >
                <h4 class="text-center text-primary"><?php echo $group;?></h4>	
                <hr>
			<div class="tabs col-md-8 col-md-offset-2">
				<ul class="nav nav-tabs">
                                    <?php 
                                        $i = 1; $std_id=1; $status = $currentSemester; 
                                        while ($i<=$status): ?>
                                            <li  <?php if ($i == 1) echo 'class="active"'?>>
                                                <a class='cursor_ tabs_' group-id="<?php echo $groupId?>"  semester-value='<?php echo $i; ?>'  data-toggle="tab" ><?php echo $i; ?>.Semester</a>
                                            </li>
                                    <?php $i++; endwhile;?>    
					
				</ul>
				<div class="tab-content">
                                    <div class="tab-pane fade  in active"  id="data-1"></div>                                                               
                                </div>

			</div>
		</div>
	</div>
    <script src="/template/js/jquery-3.1.1.js"></script>    
    <script type="text/javascript" src="/template/js/loader.js"></script>
    <script type="text/javascript" src="/template/js/progress/google-charts-top5.js"></script>
    <script src="/template/js/bootstrap.js"></script>
  </body>
</html>