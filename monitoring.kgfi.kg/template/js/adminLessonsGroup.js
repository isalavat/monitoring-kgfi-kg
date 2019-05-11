$(document).ready(function(){
      
    function loading(){
        $(".admin-date").empty();
        var load = '<div ><h3 style="text-align:center"><i class=" fa fa-circle-o-notch fa-spin fa-1x"></i></3></div>';
        $(".admin-date").html(load);
    }
    function loadingItem(id){
        $("#item-"+id).empty();
        var load = '<div ><h3 style="text-align:center"><i class=" fa fa-circle-o-notch fa-spin fa-1x"></i></3></div>';
        $("#item-"+id).html(load);
    }
    
    
    function main(){
       
        var content = "";
        var subcontent2 = "";
        $.post('/admin/get-lessons-group',{},function(data){
            console.log(data);
            data = JSON.parse(data);
             $(".admin-date").empty();
            for (var i in data){
               
                
                content+="<div class='items'>  \n\
                        <h4 >"+data[i].name+"</h4> \n\
                        <a data-id ='"+data[i].id+"' class=' show-lessons cursor_'>\n\
                            Stunde schauen\n\
                            <i class='fa fa-eye cursor_' ></i>\n\
                        </a>\n\
                        <div class='items-inner' id='item-"+data[i].id+"'>\n\
                        </div>";
                content+=" <a class='delete cursor_'  href ='/admin/lessonsgroupdelete/"+data[i].id+"' >  \n\
                            Löschen\n\
                        </a>  </div>"
            }
            
            
            
        content+="<div class='add-new'>\n\
                    <a id ='add-new-lessons-group'  class = 'btn btn-primary cursor_'>\n\
                        Hinzufügen \n\
                    </a>\n\
                 </div>";
        $(".admin-date").append(content);
            
        $(".show-lessons").on("click", function(event){
            var id = parseInt($(event.target).attr('data-id'));
            console.log(id);
            loadingItem(id);
            $.post("/admin/group-lessons", {'id':id}, function(data2){
                data2 = JSON.parse(data2);
                var text = "<div class ='form-group margin-top' >"+
                                        "<div class ='form-group'><table class='table-bordered table-striped table'>"+
                                            '<thead>'+
                                                '<tr >'+
                                                    '<th class="text-center">Stude</th>'+
                                                    '<th class="text-center">Lehrer</th>'+
                                                '</tr></thead><tbody>';
                           ;
                for (k in data2){
                    text+="<tr class='text-center'>"+
                                             "<td>"+data2[k].lesson+"</td>"+
                                             "<td>"+data2[k].teacher+"</td>"+
                                          "</tr>";
                }
                text+="<tr class='text-center'>"+
                                "<td colspan='3'>"+
                                    "<a data-id-2 ='"+id+"' class='hide-lessons cursor_'>Verbergen<i class='fa fa-eye-slash cursor_' ></i></a>"
                                    +
                                "</td>"+
                            "</tr>"+
                        "</tbody></table></div>";
                
                $("#item-"+id).empty();
                $("#item-"+id).append(text);
                
                $("[data-id = "+id+"]").hide();
                $(".hide-lessons").on("click", function(event){
                    var id = parseInt($(event.target).attr('data-id-2'));
                    console.log(id);
                    $("[data-id = "+id+"]").show();
                    $("#item-"+id).empty();
                    
                });
            
        });
        
        });
        
        
        
        $('#add-new-lessons-group').on("click", function(){
            $(".admin-date").empty();
            
            
            loading();
            $.post('/admin/get-all-lessonteachers', {}, function(data){
                $(".admin-date").empty();
                data = JSON.parse(data);
                content = "<div class ='form-group margin-top' ><input type='text' name = 'name' placeholder='Введите название' class='form-control'/></div>"
                content += '<div class ="form-group"><table class="table-bordered table-striped table">'+
                                '<thead>'+
                                    '<tr >'+
                                        '<th class="text-center">Stunde</th>'+
                                        '<th class="text-center">Lehrer</th>'+
                                        '<th class="text-center">Auswählen</th>'+
                                    '</tr></thead><tbody>';
                for (var i in data){
                   content+="<tr class='text-center'>"+
                                 "<td>"+data[i].lesson+"</td>"+
                                 "<td>"+data[i].teacher+"</td>"+
                                 "<td><input type = 'checkbox' name = 'name' value='"+data[i].id+"'></td>"+
                                 "</tr>";
                }
                content+="<tr class='text-center'>"+
                                "<td colspan='3'>"+
                                    "<a class='cursor_ btn btn-primary' id = 'add-lessons-group'>"+
                                        "<i class='fa fa-floppy-o' aria-hidden='true'></i>&nbsp;Hinzufügen"+
                                    "</a>"+
                                "</td>"+
                            "</tr>"+
                        "</tbody></table></div>";
                $('.admin-date').append(content);
                $('#add-lessons-group').on("click", function(){
                    var chb = $('input:checkbox:checked');
                    var name = $('input:text');
                    name = $(name[0]).val();
                    
                    var checked = new Array();
                    for(var i = 0; i < $(chb).length; i++){
                            checked[i] = $(chb[i]).val();
                            
                    }
                    var json = JSON.stringify(checked); 
                    $.post('/admin/add-lessons-group', {'name': name , 'json':json}, function (data){
                        
                        window.location.href='/admin/lessons-groups';
                    });
                    
                });
            })
        });
        });
    }
   
    loading();
    main();    
    $('#list-of-semester-lessons').bind("click", function (){
         
        loading();
       main();
    });
   
   
    
        
    $('#admin-lessons').bind("click", function (){
        window.location.href="/admin/lessons";
        
    });
    
    $('#admin-lessons').bind("click", function (){
        window.location.href="/admin/lessons";
        
    });
    $('#edit-semester').bind("click", function (){
        window.location.href="/admin/semester-edit";
    }); 
    
//    $('#list-of-semester-lessons').on("click", function(){
//        
//       window.location.href="/admin/lessons-groups";
//        
//    });
//   
    $('#admin-getallgroups').bind("click", function (){
        window.location.href="/admin/";
    });
    
    $('#admin-teachers').bind("click", function (){
        window.location.href="/admin/teachers";
    });
    
       
});     