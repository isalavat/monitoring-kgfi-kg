$(document).ready(function(){
    function loading(){
        $(".admin-date").empty();
        var load = '<div ><h3 style="text-align:center"><i class=" fa fa-circle-o-notch fa-spin fa-1x"></i></3></div>';
        $(".admin-date").html(load);
    }
    function loadingLessons(id){
        
        $("#chart-div-"+id).empty();
        var load = '<div ><h3 style="text-align:center"><i class=" fa fa-circle-o-notch fa-spin fa-1x"></i></3></div>';
        $("#chart-div-"+id).html(load);
    }
    function loadingTable(id){
        
        $("#chart-table-"+id).empty();
        var load = '<div ><h3 style="text-align:center"><i class=" fa fa-circle-o-notch fa-spin fa-1x"></i></3></div>';
        $("#chart-table-"+id).html(load);
    }
    
   $('.days').on("click", function(event){
                        
       var groupId = $(event.target).attr('group-id');
       var m = ['Januar', 'Februar' , 'Marth' , 'April' , 'Mai' , 'June' , 'Juli' , 'August' , 'Semtember', 'Oktober', 'Nowember', 'December'];
            
       var month = $(event.target).attr('month');
        $("div[month]").empty();
      
       $.post('/attendance/get-days', {'id':groupId, 'month':month}, function(data){
          console.log(data);
           data = JSON.parse(data);
          var content = "";
                     for (var i in data){
                        content += "<div class ='days_'><h4>"+data[i].day+"."+m[month]+"</h4>"+
                                "<a class = 'events cursor_ ' group-id='"+groupId+"' month-value='"+month+"' day-value='"+data[i].day+"' >"+
                                    " Die Unterrichts"+
                                "</a><div item-id='"+data[i].day+"'>"+
                            "</div>"+
                        "</div>";
                        }
                                
                        $("div[month='"+month+"']").empty();
                        $('div[month="'+month+'"]').append(content);        
                        $(".events").on("click", function(event){
                            $('div.lessons').empty();
                            var m_ = $(event.target).attr('month-value');
                            var d_ = $(event.target).attr('day-value');
                            $.post('/attendance/get-events',{'day':d_, 'month':m_, 'groupId':groupId}, function(events){
                                events = JSON.parse(events);
                                content = "<div class ='lessons'>";
                                for (var e in events){
                                    content+="<hr><a class ='cursor_ chart' e-id = '"+events[e].event_id+"'>"+events[e].event_name+"</a>"+
                                            "<div class = 'charts' id = 'chart-div-"+events[e].event_id+"'></div>";
                                }
                                content += "</div>";
                                $("div[item-id='"+d_+"']").empty();
                                $("div[item-id='"+d_+"']").append(content);
                                $(".chart").on("click", function(event){
                                    
                                    var e_id = $(event.target).attr('e-id');
                                    $('.charts').empty();
        
                                    loadingLessons(e_id);
                                    $.post('/attendance/get-students-count', {'eventId':e_id, 'day':d_, 'month':m_, 'groupId':groupId}, function(count){
                                        count = JSON.parse(count)
                                        var count1 = count.attendance;
                                        var count2 = count.notattendance;
                                        draw(count1, count2, e_id);
                                        content = "<button class='btn btn-primary' id='table'  >Als Tabelle</button><div id='chart-table-"+e_id+"'></div>"
                                        $("#chart-div-"+e_id).append(content);
                                        $("#table").on("click", function(){
                                            loadingTable(e_id);
                                            $.post("/attendance/all-students", {'eventId':e_id, 'day':d_, 'month':m_, 'groupId':groupId}, function(students){
                                                console.log(students);
                                                students = JSON.parse(students);
                                                content = '<div><br><table class="table-bordered table-striped table">\n\
                                                <thead>'+
                                                   '<tr >\n\
                                                        <th class="text-center">Name</th>\n\
                                                        <th class="text-center">Status</th>'+
                                                    '</tr>\n\
                                                </thead>\n\
                                            <tbody>';
                                                for (var k in students){
                                                    var temp = ['<a class="text-danger" ><i  class=" fa fa-times" aria-hidden="true"></i></a>','<a class = "text-success"><i class="fa fa-check " aria-hidden="true" ></i></a>'];
                                                   content +=  "<tr class='text-center'>"+
                                                                   "<td><a >"+students[k].name+"</a></td>"+
                                                                    "<td>\n\
                                                                        <a field-id='"+students[k].status+"'>"+temp[students[k].status]+"</a>"+
                                                                    "</td>"+
                                                               "</tr>";
                                                }
                                                content += "</tbody></table><hr><a id='hidden' hidden-id='"+e_id+"' class ='cursor_'>Hidden</a></div>";
                                
                                                 $("#chart-table-"+e_id).empty();
                                                $("#chart-table-"+e_id).append(content);
                                                $('#hidden').on("click", function(event){
                                                    var id_ = $(event.target).attr('hidden-id');
                                                    $("#chart-table-"+id_).empty();
                                                });
                    
                                            });
                                        });
                                    });
                                });
                            });
                        });    
       });
   
   });
   // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
    function draw(count1, count2, id){
          
        google.charts.setOnLoadCallback(drawChart(count1, count2, id));
    }
    function drawChart(count1, count2,id) {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
          ['Die Anwesenden', parseInt(count1)],
          ['Die Fehlenden', parseInt(count2)],
          
        ]);

        // Set chart options
        var options = {'title':'Die Kennziffer des Besuches',
                       'width':500,
                       'height':300};
                   
        // Instantiate and draw our chart, passing in some options.
        
          var chart = new google.visualization.PieChart(document.getElementById('chart-div-'+id));
        chart.draw(data, options);
        
      }
});