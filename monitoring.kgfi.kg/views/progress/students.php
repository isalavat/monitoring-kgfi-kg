<?php include ROOT."/views/layouts/header.php"?>
<div class="container">
    
    <div class="row">
        
        <div class="col-md-offset-3 col-md-6  block-fade " >
            <div >
                 
                    <div >
                        <h4 class="text-center "> Gruppe <?php echo $group ?></h4>
                        <table class="table-bordered table-striped table">
                             <thead>
                                <tr >
                                    <th class="text-center">Student</th>
                                    <th class="text-center">Lesitung</th>
                                </tr>
                            </thead>
                        <tbody>
                     
                <?php foreach($students as $student): ?>
                    <tr class='text-center'>
                        <td><?php echo $student['name']?></td>
                        <td>
                            <a href="/progress/student/<?php echo$student['group_id']?>/<?php echo$student['id']?>/<?php echo$student['current_semester']?>">
                                
                                <i class="fa fa-bar-chart fa-2x" aria-hidden="true"></i>
                            </a>
                        </td>
                        
                        
                    </tr>;
                }
                <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                
                
                
            </div>
        </div>
        
    </div>
    
</div>
