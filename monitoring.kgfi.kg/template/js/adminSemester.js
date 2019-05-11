 $(document).ready(function(){
    function loading(){
        $(".admin-date").empty();
        var load = '<div ><h3 style="text-align:center"><i class=" fa fa-circle-o-notch fa-spin fa-1x"></i></3></div>';
        $(".admin-date").html(load);
    }
    
    function main(){
        var content =   "<div class='items'>"+
                            "<a class ='btn btn-primary cursor_ text-center' id='plus-semester'>Semester steigern</a>"+
                        "</div>";
        $(".admin-date").empty();
        $(".admin-date").append(content); 
        $("#plus-semester").on('click',function(){
            loading();
            $.post('/admin/semester-translate',{},function(data){
                console.log(data);
                $(".admin-date").empty();
                $(".admin-date").append('<h4 text-success text-center>Erfolgreich<h4>'); 
        
            });
        });
    }
    $('#edit-semester').on('click', function(){
        loading();
        main();
    });
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
    
    $('#admin-teachers').bind("click", function (){
        window.location.href="/admin/teachers";
    });
//    $('#semeste-edit').bind("click", function (){
//        window.location.href="/admin/semester-edit";
//    }); 
});
