google.charts.load('current', {'packages':['corechart']});

$(document).ready(function(){ 
    function loading(){
        $("#data-1").empty();
        var load = '<div ><br><br><br><h3 style="text-align:center"><i class=" fa fa-circle-o-notch fa-spin fa-2x"></i></3><br><br><br></div>';
        $("#data-1").html(load);
    }
    
     function drawChart(j_data, semester, name ) {
        console.log('No');
         j_data = JSON.parse(j_data);
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Note');
        for (var i in j_data){
           data.addRow([j_data[i].lesson,parseFloat(j_data[i].note )]); 
        }
        
        var options = {'title': name,
                       'width':600,
                       'height':400};
        $('#data-1').empty();           
        var chart = new google.visualization.ColumnChart(document.getElementById('data-'+1));
        chart.draw(data, options);
     }
    function main(gId, sId, semester){
       var name;
       console.log("1 "+gId+" "+sId+" "+semester);
       var semester2 = semester;
        loading();
        $.post('/progress/get-student-notes',{'groupId':gId,'studentId':sId,'semester':semester },function(data){
            $.post('/progress/student-name',{'id':sId, },function(data_){
                data_ = JSON.parse(data_); 
                name = data_[0].name;
                console.log("2 "+gId+" "+sId+" "+semester2);
     
                
                google.charts.setOnLoadCallback(drawChart(data, semester, name));
            });  
            
        });
    }

    var gId_ = $('#student').attr("group-id");
    var sId_ = $('#student').attr("student-id");
    var semester_ = 1;
    main(gId_ , sId_ , semester_);
    $(".tabs_").on("click", function(event){
       var gId = $(event.target).attr("group-id");
       var sId = $(event.target).attr("student-id");
       var semester = $(event.target).attr("semester-value");
       main(gId, sId, semester);
    });
   
      
});      