$(document).ready(function(){
    
    function loading(){
        $(".admin-date").empty();
        var load = '<div ><h3 style="text-align:center"><i class=" fa fa-circle-o-notch fa-spin fa-1x"></i></3></div>';
        $(".admin-date").html(load);
    }
    
    
    function main(){
        $.post('/admin/get-all-lessons/', {}, function(data){
            data = JSON.parse(data);
            $(".admin-date").empty();
            for (var i in data){
                var content = "\
                    <div class='items'>\n\
                         <h4 >"+data[i]+"</h4>\n\
                             <a class='list-of-teachers cursor_' data-id='"+i+"' >Liste der Lehrer</a> | \n\
                             <a href='/admin/edit-lesson/"+i+"' >Ändern</a> | \n\
                             <a href='/admin/delete-lesson/"+i+"'>Löschen</a>\
                    "
                
                $(".admin-date").append(content);
            }
            content = "<div class='add-new'><a href='/admin/add-lesson/' class = 'btn btn-primary'>Добавить новую </a></div>";
            $(".admin-date").append(content);
            $(".list-of-teachers").on("click", function(event){
                var id = parseInt($(event.target).attr('data-id')) ;
                console.log(id);
                $.post('/admin/get-lesson-teachers/',{'id':id},function(data){
                    data = JSON.parse(data);
                        
                    $(".admin-date").empty();
                    var content = '<table class="table-bordered table-striped table"><thead>'+
                                  '<tr ><th class="text-center">ФИО</th><th class="text-center">Löschen</th></tr></thead><tbody>';
                            
                    for (var i in data){
                        content+="<tr class='text-center'>"+
                                 "<td>"+data[i]+"</td>"+
                                 "<td><a href='/admin/delete-lessonteacher/"+id+"/"+i+"'><i class='fa fa-trash-o'></i></a></td>"+
                                 "</tr>";
                          //  $(".admin-date").append(content);
                    }
                    content+= "</tbody></table>";
                    content+="<div class='add-new'><a href='/admin/add-lessonteacher/"+id+"' class = 'btn btn-primary'>Hinzufügen</a></div>";
                    $(".admin-date").append(content);
                });
            });
    });
     
    }
    
    
    loading();
    main();
    
     $('#admin-lessons').on("click", function(){
         loading();
         main();
     });   
    
//    $('#admin-lessons').bind("click", function (){
//        window.location.href="/admin/lessons";
//        
//    });
    
    $('#list-of-semester-lessons').on("click", function(){
        
       window.location.href="/admin/lessons-groups";
        
    });
   
    $('#admin-getallgroups').bind("click", function (){
        window.location.href="/admin/";
    });
    
    $('#admin-teachers').bind("click", function (){
        window.location.href="/admin/teachers";
    });
    $('#edit-semester').bind("click", function (){
        window.location.href="/admin/semester-edit";
    }); 
    
});