$(document).ready(function(){
    function loading(){
        $(".admin-date").empty();
        var load = '<div ><h3 style="text-align:center"><i class=" fa fa-circle-o-notch fa-spin fa-1x"></i></3></div>';
        $(".admin-date").html(load);
    }
    function main(){
        $.post('/admin/get-all-teachers/', {}, function(data){
        data = JSON.parse(data);
        $(".admin-date").empty();
        for (var i in data){
        var content = "\
            <div class='items'>\n\
                <h4 >"+data[i]+"</h4>\n\
                    <a href='/admin/edit-teacher/"+i+"' > Ändern </a> | <a href='/admin/delete-teacher/"+i+"'>Löschen</a>\
                    "
                
            $(".admin-date").append(content);
        }
        content = "<div class='add-new'><a href='/admin/add-teacher/' class = 'btn btn-primary'> Hinzufügen </a></div>";
        $(".admin-date").append(content);
    });
    
    }
    loading();
    main();  
    
    $('#admin-teachers').bind("click", function (){
        loading();
        main();
         
    });
    
    
     $('#admin-lessons').bind("click", function (){
        window.location.href="/admin/lessons";
        
    });
    
    $('#list-of-semester-lessons').on("click", function(){
        
       window.location.href="/admin/lessons-groups";
        
    });
   
    $('#admin-getallgroups').bind("click", function (){
        window.location.href="/admin/";
    });
    
//    $('#admin-teachers').bind("click", function (){
//        window.location.href="/admin/teachers";
//    });
    $('#edit-semester').bind("click", function (){
        window.location.href="/admin/semester-edit";
    }); 
       
});

 