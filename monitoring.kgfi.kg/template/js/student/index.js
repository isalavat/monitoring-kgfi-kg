
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
      var content = "<br><h4 class='text-primary text-center'>Новое событие</h4><div class ='form-group'>"+
              "<input type='text' class ='form-control' name='name' ></div>"+
              "<div class ='form-group'><button class='btn btn-primary' id='newevent'>Добавить</button></div>";
      $(".admin-date").append(content);
      $("#newevent").on("click", function(){
          var date = new Date ();
          var day = date.getDate();
          var month = date.getMonth();
          var groupId = $('.row').attr('group-id');
          var name = $("input[name='name']").val()
            loading();
          $.post('../student/new-event', {'day':day, 'month':month , 'groupId':groupId , 'name':name},function(data){
              $('.admin-date').empty();
              data = JSON.parse(data);
              if (data){
                  $('.admin-date').append("<br><br><h4 class = 'text-center text-success'>Event ist eingefuegt worden</h4><br><br>");
              }else{
                  $('.admin-date').append("<br><br><h4 class='text-center text-danger'>Event ist nicht eingefuegt worden</h4><br><br>");
              
              }
              
          });
          
      });
    }
    
    
    main();
    
    $('#new-event').on("click" , function(){
        window.location.href="/std-admin";
    });
    $('#events').on("click" , function(){
        window.location.href="/std-admin/events";
        
    });
});


