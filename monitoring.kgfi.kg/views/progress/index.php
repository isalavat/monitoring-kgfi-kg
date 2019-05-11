<?php include ROOT."/views/layouts/header.php"?>
<div class="container">
    
    <div class="row">
        
        <div class="col-md-offset-3 col-md-6  block-fade " >
                <h4>&nbsp;&nbsp;Leistung </h4>
                <hr>
                <?php foreach($groups as $group): ?>
                <div class="items items-radius">
                    <h4>&nbsp;&nbsp;<i class="fa fa-graduation-cap fa-1x" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo$group['name']?></h4>
                   &nbsp;&nbsp;<a href="/progress/group/<?php echo$group['id']?>">&nbsp;&nbsp;Studenten&nbsp;&nbsp|</a>
                    <a href="/progress/top-5/<?php echo$group['id']?>">&nbsp;&nbsp;Top 5&nbsp;&nbsp</a>
                </div>
                 <?php endforeach;?>
                <hr>
            
        </div>
        
    </div>
    
</div>
