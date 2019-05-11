
 $(document).ready(function(){
    
    function loading(){
        $(".admin-date").empty();
        var load = '<div ><h3 style="text-align:center"><i class=" fa fa-circle-o-notch fa-spin fa-1x"></i></3></div>';
        $(".admin-date").html(load);
    }
    function loadingNote(id){
        $("a[field-id='"+id+"']").empty();
        var load = '<p style="text-align:center; font-size : 9px"><i class=" fa fa-circle-o-notch fa-spin "></i></p>';
        $("a[field-id='"+id+"']").html(load);
    }
    
           
    function main(){
        var id;
        
        $.post('../teacher/get-id/', {}, function(id_){
           
            id = JSON.parse(id_);
            var teacher_id = id;
            loading();
            $.post('../teacher/get-lessons/', {'id': id}, function(lessons_){
                lessons_ = JSON.parse(lessons_);
                var content = '<br><table class="table-bordered table-striped table"><thead>'+
                                    '<tr ><th class="text-center">Stunde</th><th class="text-center">Gruppe</th></tr></thead><tbody>';
                            
                        for (var i in lessons_){
                            content+="<tr class='text-center'>"+
                                     "<td><a href='/admin/edit-student/"+i+"'>"+lessons_[i].name+"</a></td>"+
                                    "<td><a ><i class='fa fa-pencil-square-o teacher-group cursor_'  data-id='"+lessons_[i].id+"' ></i></a></td>"+
                                    "</tr>";
                        }
                        content += "</tbody></table>";
                        $(".admin-date").empty();
                        $(".admin-date").append(content);
                $(".teacher-group").on("click", function(event){
                    
                    var id = $(event.target).attr('data-id');
                    var less_id = $(event.target).attr('data-id');
                    $.post('../teacher/get-groups/', {'id':id}, function(groups_){
                        loading();
                        groups_ = JSON.parse(groups_);
                        var content = '<br><table class="table-bordered table-striped table">\n\
                                            <thead>'+
                                                '<tr >\n\
                                                    <th class="text-center">Name</th>\n\
                                                    <th class="text-center">Liste der Studenten</th>'+
                                                    '<th class="text-center">Semester</th>'+
                                                
                                                '</tr>\n\
                                            </thead>\n\
                                        <tbody>';
                           
                        for (var k in groups_){
                            content +=  "<tr class='text-center'>"+
                                            "<td><a >"+groups_[k].name+"</a></td>"+
                                            "<td><a ><i class='fa fa-pencil-square-o students cursor_' semester='"+ groups_[k].semester+"' data-id='"+groups_[k].group_id+"'></i></a></td>"+
                                            "<td><a >"+groups_[k].semester+"</a></td>"+
                                        
                                        "</tr>";
                        }
                         content += "</tbody></table>";
                         
                        $(".admin-date").empty();
                        $(".admin-date").append(content);
                        
                        $('.students').on("click", function(event){
                            var group_id = $(event.target).attr('data-id');
                            var semester = $(event.target).attr('semester');
                            loading();
                            $.post('../teacher/get-students-by-group',{'groupId':group_id , 'semester':semester , 'lessonId':less_id }, function(students){
                                students = JSON.parse(students);
                                var select =    "<option value='0' selected>0</option>"+
                                                "<option value='2.0' >2.0</option>"+
                                                "<option value='2.1' >2.1</option>"+
                                                "<option value='2.2' >2.2</option>"+
                                                "<option value='2.3' >2.3</option>"+
                                                "<option value='2.4' >2.4</option>"+
                                                "<option value='2.5' >2.5</option>"+
                                                "<option value='2.6' >2.6</option>"+
                                                "<option value='2.7' >2.7</option>"+
                                                "<option value='2.8' >2.8</option>"+
                                                "<option value='2.9' >2.9</option>"+
                                                "<option value='3.0' >3.0</option>"+
                                                "<option value='3.1' >3.1</option>"+
                                                "<option value='3.2' >3.2</option>"+
                                                "<option value='3.3' >3.3</option>"+
                                                "<option value='3.4' >3.4</option>"+
                                                "<option value='3.5' >3.5</option>"+
                                                "<option value='3.6' >3.6</option>"+
                                                "<option value='3.7' >3.7</option>"+
                                                "<option value='3.8' >3.8</option>"+
                                                "<option value='3.9' >3.9</option>"+
                                                "<option value='4.0' >4.0</option>"+
                                                "<option value='4.1' >4.1</option>"+
                                                "<option value='4.2' >4.2</option>"+
                                                "<option value='4.3' >4.3</option>"+
                                                "<option value='4.4' >4.4</option>"+
                                                "<option value='4.5' >4.5</option>"+
                                                "<option value='4.6' >4.6</option>"+
                                                "<option value='4.7' >4.7</option>"+
                                                "<option value='4.8' >4.8</option>"+
                                                "<option value='4.9' >4.9</option>"+
                                                "<option value='5.0' >5.0</option>"+
                                                
                                        "</select>";
                               
                                var content = '<br><table class="table-bordered table-striped table">\n\
                                        <thead>'+
                                           '<tr >\n\
                                                <th class="text-center">Name</th>\n\
                                                <th class="text-center">Note</th>'+
                                                '<th class="text-center">Ändern</th>'+
                                            '</tr>\n\
                                        </thead>\n\
                                       <tbody>';
                                for (var k in students){
                                       content +=  "<tr class='text-center'>"+
                                            "<td><a >"+students[k].name+"</a></td>"+
                                            "<td>\n\
                                                <a field-id='"+students[k].user_id+"'>0</a>"+
                                            "</td>"+
                                            "<td><a  ><select  class='note' std-id='"+students[k].user_id+"'>"+select+"&nbsp;"+
                                            "<i class='fa fa-star-o cursor_ save-note' note-id='"+students[k].user_id+"' aria-hidden='true'></i>\n\
                                            </a></td>"+
                                        "</tr>";
                                }
                                content += "</tbody></table>";
                                $(".admin-date").empty();
                                $(".admin-date").append(content);
                                $.post('../teacher/get-notes-by-group',
                                    {'groupId':group_id , 'semester':semester , 'lessonId':less_id }, 
                                    function(notes){
                                        notes = JSON.parse(notes);
                                        for (var k in notes){
                                           
                                            $("a[field-id='"+notes[k].user_id+"']").empty();
                                            $("a[field-id='"+notes[k].user_id+"']").append(notes[k].note);
                                        }
                                
                                    });
                                
                                $('.save-note').on("click", function(event){
                                    
                                    var std_id = $(event.target).attr("note-id");
                                    var note = $('.note[std-id="'+std_id+'"]').val();
                                    var gr_id = group_id;
                                    var lesson_id = less_id;
                                    var teach_id = teacher_id;
                                    loadingNote(std_id);
                                    
                                    $.post('../user/save-note',
                                    {'studentId':std_id , 'groupId':gr_id , 'lessonId':lesson_id, 'teacherId':teach_id, 'note':note, 'semester':semester},
                                    function(){
                                        $('a[field-id="'+std_id+'"]').empty();
                                        $('a[field-id="'+std_id+'"]').text(note);
                                    });
                                });
                            });
                            
                        });
                    });
                });        
            });
        });
    }
    
    loading();
    
    main();
    
        
});


