$(document).ready(function(){
    
    function loading(){
        $(".admin-date").empty();
        var load = '<div ><h3 style="text-align:center"><i class=" fa fa-circle-o-notch fa-spin fa-1x"></i></3></div>';
        $(".admin-date").html(load);
    }
    
    
    function main(){
        $.post('/admin/get-all-groups/', {}, function(data){
            data = JSON.parse(data);
            $(".admin-date").empty();
            for (var i in data){
                var content = "\
                    <div class='items'>\n\
                         <h4 >"+data[i]+"</h4>\n\
                            <a class='list-of-students cursor_' data-id='"+i+"' > Liste der Studenten </a>"+
                          " |<a class='semesters cursor_' data-id='"+i+"' > Semester </a> "+
                          " | <a href='/admin/edit-group/"+i+"' >   Ändern</a>"+
                          " | <a href='/admin/delete-group/"+i+"'>Löschen</a>"+                    
                          " | <a href='/admin/head-student/"+i+"'>Head Student</a>"
                $(".admin-date").append(content);
            }
            content = "<div class='add-new'><a href='/admin/add-group/' class = 'btn btn-primary'>Hinzufügen</a></div>";
            $(".admin-date").append(content);    
             $(".list-of-students").on("click", function(event){
                    loading();
                    var id_ = parseInt($(event.target).attr("data-id")); 
                    
                    $.post('/admin/students/', {'id' : id_}, function(data){
                        data = JSON.parse(data);
                        $(".admin-date").empty();
                        var content = '<table class="table-bordered table-striped table"><thead>'+
                                    '<tr ><th class="text-center">Name</th><th class="text-center">Ändern</th><th class="text-center">Löschen</th></tr></thead><tbody>';
                            
                        for (var i in data){
                            content+="<tr class='text-center'>"+
                                    "<td>"+data[i]+"</td>"+
                                    "<td><a href='/admin/edit-student/"+i+"'><i class='fa fa-pencil-square-o'></i></a></td>"+
                                    "<td><a href='/admin/delete-student/"+i+"'><i class='fa fa-trash-o'></i></a></td>"+
                                    "</tr>";
                            }
                        content += "</tbody></table>";
                        content+="<div class='add-new'><a href='/admin/add-student/' class = 'btn btn-primary'>Hinzufügen</a></div>";
                        $(".admin-date").append(content);
                    });
            });
            
            $(".semesters").on("click", function(event){
                var id = $(event.target).attr("data-id");
                
                 loading();
                $.post('/admin/get-semester/',{'id':id}, function(data){
                    data = JSON.parse(data);
                    var semester = data['value'];
                    $(".admin-date").empty();
                    var content = "";;
                
                    for(var i = 1; i <=semester; i++ ){
                        content+=" <div class='items'>";
                            content+="<h4>"+i+".Semester</h4>";
                            content+="<a class='list-of-lessons cursor_' semester='"+i+"' group='"+id+"'>Stundenplan</a>";
                        content += " </div>"                        
                    }
                    $(".admin-date").append(content);
                    $(".list-of-lessons").on("click", function(event){
                        loading();
                        console.log('Testing');
                        var semester = parseInt($(event.target).attr('semester'));
                        var group = parseInt($(event.target).attr('group'));
                        $.post('/admin/get-lessons-group-by-id-json', {'semester' : semester, 'group' : group}, function(lessGroup){
                            
                            var content2 = '';
                            lessGroup = JSON.parse(lessGroup);
                            content2 += "<div class ='form-group margin-top' >"+
                                        "<div class ='form-group'><table class='table-bordered table-striped table'>"+
                                            '<thead>'+
                                                '<tr >'+
                                                    '<th class="text-center">Stunde</th>'+
                                                    '<th class="text-center">Lehrer</th>'+
                                                '</tr></thead><tbody>';
                           
                            for (var i in lessGroup){
                                
                                content2+="<tr class='text-center'>"+
                                             "<td>"+lessGroup[i].lesson+"</td>"+
                                             "<td>"+lessGroup[i].teacher+"</td>"+
                                          "</tr>";
                            }
                                content2+="<tr class='text-center'>"+
                                    "<td colspan='3'>"+
                                         "<a href='/admin/lessons-group-choose/"+group+"/"+semester+"' class='btn btn-primary add-lessons-group' semester='"+semester+"' group='"+group+"'>Auswählen</a>"
                                     +
                                    "</td>"+
                                    "</tr>"+
                                "</tbody></table></div>";
                
                        $(".admin-date").empty();
                        $(".admin-date").append(content2);
                            
                        });
                         
                    });
                }); 
                
            });
               
            
        });
    }
    
    loading();
    
    main();
    
    $('#admin-getallgroups').bind("click", function (){
        loading();
        main(); 
    });
    
    
    $('#admin-lessons').bind("click", function (){
        window.location.href="/admin/lessons";
        
    });
    
    $('#list-of-semester-lessons').on("click", function(){
        
       window.location.href="/admin/lessons-groups";
        
    });
   
//    $('#admin-getallgroups').bind("click", function (){
//        window.location.href="/admin/";
//    });
//    
    $('#admin-teachers').bind("click", function (){
        window.location.href="/admin/teachers";
    });
    $('#edit-semester').bind("click", function (){
        window.location.href="/admin/semester-edit";
    }); 
});


