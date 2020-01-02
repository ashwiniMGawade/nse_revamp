<?php include VIEW_PATH."graphs-tab.php" ?>
<div class="panel-body">
    <div class="tab-content tab-pane fade in active">
        <div class="row">
           
                
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>  
            
            <?php if(isset($_GET['serverStatus']) && $_GET['serverStatus'] != '') {
                ?>
                 <div class="col-sm-10">
                 <script type="text/javascript">  
                   
                     google.charts.load('current', {'packages':['corechart']});  
                     google.charts.setOnLoadCallback(drawChart_server_status);
                     function drawChart_server_status()  
                     {  
                         var urlParams = new URLSearchParams(location.search);
                         $("#loader-server-status").show();
                         var serverData = $.ajax({
                             url: "index.php?p=linux&a=getServerData",
                             type: "POST",
                             data: {"serverStatus": urlParams.get('serverStatus')},
                             dataType: "json",
                             async: false
                         }).responseText;
                         var array = JSON.parse(serverData);
                         var data = google.visualization.arrayToDataTable(array);  
                         var options = {  
                             title: 'Percentage of servers ran the logs',  
                             is3D:true,  
                             pieHole: 0.4,  
                             colors: ['green', '#428bca']
                         };  
                         $("#loader-server-status").hide();
                         loadSidebarLength();
                         var chart = new google.visualization.PieChart(document.getElementById('piechart_server_status'));  
                         chart.draw(data, options); 


                         google.visualization.events.addListener(chart, 'select', function() {
                             var selection = chart.getSelection();
                             var value = data.getValue(selection[0].row, 0);  
                             urlAppend = ''; 
                             value = value.toLowerCase();
                            //  value = (value == "failure"? "failed": value);
                            //  urlAppend += value !== ''? "&status="+value.toLowerCase() : "";
                             if(urlParams.get('serverStatus') != null && value == "run") {
                                 var s = moment().startOf('day');
                                 s.subtract(1, 'days');
                                 if (urlParams.get('serverStatus') != 'today') {
                                    var s =  moment(urlParams.get('serverStatus')).startOf('day');
                                 }
                                 
                                 urlAppend += "&startDate="+s.format("MM/DD/YYYY hh:mm A")+"&endDate="+s.add(1, 'days').format("MM/DD/YYYY hh:mm A");
                                 window.location.replace("index.php?p=linux&a=copies"+urlAppend);
                             } else {
                                window.location.replace("index.php?p=linux&a=serverStatus&serverStatus="+(urlParams.get('serverStatus')));
                             }
                              
                         });
                     } 

                 </script>  
                 <div class="row">
                    <div class="col-sm-4">
                        <input class="datepicker form-control statusdate"  placeholder="Date" name="statusdate"  autocomplete="off" value="<?php echo isset($_GET['serverStatus']) ? $_GET['serverStatus']: '';?>">
                    </div>
                </div>                    
                 <div style="">    
                     <div id="loader-server-status" class="graph-loader row "></div>
                     <div id="piechart_server_status" style="width: 100%; height: 400px;">           
                     </div>           
                 </div>                 
             </div>
            <?php } else {
                ?>
                <div class="col-sm-10">
                    <script type="text/javascript">  
                        google.charts.load('current', {'packages':['corechart']});  
                        google.charts.setOnLoadCallback(drawChart_copy);  
                        function drawChart_copy()  
                        {  
                            var urlParams = new URLSearchParams(location.search);
                            var name = urlParams.getAll('name[]');
                            $("#loader-copy").show();
                            var serverData = $.ajax({
                                url: "index.php?p=linux&a=getData",
                                type: "POST",
                                data: {"name": name , "day": urlParams.get('day')},
                                dataType: "json",
                                async: false
                            }).responseText;
                            var array = JSON.parse(serverData);
                            var data = google.visualization.arrayToDataTable(array);  
                            var options = {  
                                title: 'Percentage of Linux LOG Copy Success and Failure',  
                                is3D:true,  
                                pieHole: 0.4,  
                                colors: ['red', '#428bca', '#43459d', 'green', 'orange']
                            };  
                            $("#loader-copy").hide();
                            loadSidebarLength();
                            var chart = new google.visualization.PieChart(document.getElementById('piechart_copy'));  
                            chart.draw(data, options); 


                            google.visualization.events.addListener(chart, 'select', function() {
                                var selection = chart.getSelection();
                                var value = data.getValue(selection[0].row, 0);  
                                urlAppend = ''; 
                                name.forEach(function(nameval){
                                    urlAppend += "&name[]="+nameval;
                                });   
                                value = value.toLowerCase();
                                value = (value == "failure"? "failed": value);
                                urlAppend += value !== ''? "&status="+value.toLowerCase() : "";
                                if(urlParams.get('day') != null) {
                                    var m = moment();
                                    var s = m.subtract(urlParams.get('day'), 'days').startOf('day');
                                    urlAppend += "&startDate="+s.format("MM/DD/YYYY hh:mm A")+"&endDate"+moment().startOf('day').format("MM/DD/YYYY hh:mm A");
                                }
                                window.location.replace("index.php?p=linux&a=copies"+urlAppend);  
                            });
                        }                     
                    </script>                      
                    <div style="">    
                        <div id="loader-copy" class="graph-loader row "></div>
                        <div id="piechart_copy" style="width: 100%; height: 400px;">           
                        </div>           
                    </div>                 
                </div>
               
           <?php } ?>
        </div>
    </div>
</div>