
 $(document).ready(function(){
    
    function loading(){
        $(".admin-date").empty();
        var load = '<div ><h3 style="text-align:center"><i class=" fa fa-circle-o-notch fa-spin fa-1x"></i></3></div>';
        $(".admin-date").html(load);
    }
    function loadingStatus(id){
        $("a[field-id='"+id+"']").empty();
        var load = '<p style="text-align:center; font-size : 9px"><i class=" fa fa-circle-o-notch fa-spin "></i></p>';
        $("a[field-id='"+id+"']").html(load);
    }
    
    function loadingEvent(id){
        //$("a[event-id='"+id+"']").empty();
        var load = '<p style="text-align:center; font-size : 29px"><i class=" fa fa-circle-o-notch fa-spin "></i></p>';
        $("div[event-id='"+id+"']").html(load);
    }
           
    function main(){
        var groupId = $(".row").attr("group-id");
        loading();
        $.post('../student/get-last-events', {'groupId': groupId},function(data){
            data = JSON.parse(data);
            var content = "";
            var months = ['Januar', 'Februar' , 'Marth' , 'April' , 'Mai' , 'June' , 'Juli' , 'August' , 'Semtember', 'Oktober', 'Nowember', 'December'];
            $('.admin-date').empty();
            for (i in data){
                content +=  "<div class='items'>";
                content +="<h4>"+data[i].name+" / "+data[i].day+"."+months[data[i].month]+"</h4>"
                content +="<a event-id = "+data[i].id+" event-name='"+data[i].name+"' day='"+data[i].day+"' month='"+data[i].month+"'   group-id = "+data[i].group_id+" class ='cursor_'> Studenten </a>"
                content +="<div event-id='"+data[i].id+"'></div></div>";
                
            }
            $('.admin-date').append(content);
            $('a').on("click", function(event){
                
                var eventId = $(event.target).attr('event-id');
                loadingEvent(eventId);
                var groupId = $(event.target).attr('group-id');
                var name = $(event.target).attr('event-name');
                var day = $(event.target).attr('day');
                var month = $(event.target).attr('month');
                $.post('../student/get-students', {'id': groupId}, function(students){
                    $('div[event-id]').empty();
                    students =  JSON.parse(students);
                    var select =    "<option value='0' >N</option>"+
                                    "<option value='1' selected>Y</option>"+
                                   "</select>"; 
                                
                    var content = '<br><table class="table-bordered table-striped table">\n\
                                        <thead>'+
                                           '<tr >\n\
                                                <th class="text-center">Name</th>\n\
                                                <th class="text-center">Status</th>'+
                                                '<th class="text-center">Ändern</th>'+
                                            '</tr>\n\
                                        </thead>\n\
                                       <tbody>';
                                for (var k in students){
                                       content +=  "<tr class='text-center'>"+
                                            "<td><a >"+students[k].name+"</a></td>"+
                                            "<td>\n\
                                                <a field-id='"+students[k].user_id+"'>X</a>"+
                                            "</td>"+
                                            "<td><a  ><select  class='status' std-id='"+students[k].user_id+"'>"+select+"&nbsp;"+
                                            "<i class='fa fa-star-o cursor_ save-attendance' event-id='"+eventId+"' event-name = '"+name+"' group-id='"+groupId+"'  student-name='"+students[k].name+"'  student-id='"+students[k].user_id+"' day='"+day+"'  month = '"+month+"' aria-hidden='true'></i>\n\
                                            </a></td>"+
                                        "</tr>";
                                }
                                content += "</tbody></table><hr><a data-id='"+eventId+"' class ='cursor_'>Hidden</a>";
                                
                                $("div[event-id='"+eventId+"']").empty();
                                $("div[event-id='"+eventId+"']").append(content);
                                $.post("../student/get-attendance", {'groupId':groupId, 'eventId':eventId}, function(status_){
                                    status_ = JSON.parse(status_);
                                    for (j in status_){
                                        $("a[field-id='"+status_[j].student_user_id+"']").empty();
                                        if (parseInt(status_[j].status) == 1){
                                            $("a[field-id='"+status_[j].student_user_id+"']").text("Y");
                                        }else{
                                            $("a[field-id='"+status_[j].student_user_id+"']").text("N");
                                        
                                        }
                                    }
                                });
                                $(".save-attendance").on("click", function(event){
                                    var e_id = $(event.target).attr('event-id');
                                    var g_id = $(event.target).attr('group-id');
                                    var e_name = $(event.target).attr('event-name');
                                    var s_name = $(event.target).attr('student-name');
                                    var s_id = $(event.target).attr('student-id');
                                    var day = $(event.target).attr('day');
                                    var month = $(event.target).attr('month');
                                    var status = $(".status[std-id='"+s_id+"']").val();
                                    loadingStatus(s_id);
                                    $.post('../student/save-attendance',{'e_id':e_id , 'g_id':g_id , 'e_name':e_name, 's_name':s_name , 's_id':s_id,'day':day,'month':month, 'status':status},function(result){
                                        console.log(result);
                                        result = JSON.parse(result);
                                        $("a[field-id='"+s_id+"']").empty();
                                        $("a[field-id='"+s_id+"']").append(result);
                                    });   
                                });
                                $("a[data-id]").on("click", function(event){
                                    var id_ = $(event.target).attr('data-id');
                                    $("div[event-id='"+id_+"']").empty();
                                        
                                });
                                
                                
                                
                    
                });
            });
        });
    }
    
    loading();
    
    main();
    
    $('#new-event').on("click" , function(){
        window.location.href="/std-admin/";
    });
    $('#events').on("click" , function(){
        window.location.href="/std-admin/events";
        
    });
});


