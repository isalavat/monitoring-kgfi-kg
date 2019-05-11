google.charts.load('current', {'packages':['corechart']});

$(document).ready(function(){ 
    function loading(){
        $("#data-1").empty();
        var load = '<div ><br><br><br><h3 style="text-align:center"><i class=" fa fa-circle-o-notch fa-spin fa-2x"></i></3><br><br><br></div>';
        $("#data-1").html(load);
    }
    
     function drawChart(j_data ) {
         j_data = JSON.parse(j_data);
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Druchschnittliche Note');
        for (var i in j_data){
           data.addRow([j_data[i].name,parseFloat(j_data[i].note )]); 
        }
        
        var options = {'title': 'Rating Top 5',
                       'width':800,
                       'height':400};
        $('#data-1').empty();           
        var chart = new google.visualization.ColumnChart(document.getElementById('data-'+1));
        chart.draw(data, options);
     }
    function main(gId, semester){
        loading();
        $.post('/progress/get-top-5',{'groupId':gId,'semester':semester },function(data){
            google.charts.setOnLoadCallback(drawChart(data));
              
            
        });
    }
    var gId_ = $('#group').attr("group-id");
    var semester_ = 1;
    main(gId_ ,  semester_);
    $(".tabs_").on("click", function(event){
       var gId = $(event.target).attr("group-id");
       var semester = $(event.target).attr("semester-value");
       main(gId, semester);
    });
   
      
});      