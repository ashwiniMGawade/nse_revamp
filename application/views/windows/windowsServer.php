<?php include VIEW_PATH."graphs-tab.php" ?>
<div class="panel-body">
    <div class="tab-content">
        <div class="row tab-pane fade in active">
            
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>  
            <?php if(isset($_GET['serverStatus']) && $_GET['serverStatus'] != '') {
                ?>
                 <div class="col-sm-6">
                 <script type="text/javascript">  
                   
                     google.charts.load('current', {'packages':['corechart']});  
                     google.charts.setOnLoadCallback(drawChart_server_status);
                     function drawChart_server_status()  
                     {  
                         var urlParams = new URLSearchParams(location.search);
                         $("#loader-server-status").show();
                         var serverData = $.ajax({
                             url: "index.php?p=windows&a=getServerData",
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
                                 var s = moment();
                                 if (urlParams.get('serverStatus') != 'today') {
                                    var s =  moment(urlParams.get('serverStatus'));
                                 }
                                 
                                 urlAppend += "&startDate="+s.format("MM/DD/YYYY hh:mm A")+"&endDate="+s.add(1, 'days').format("MM/DD/YYYY hh:mm A");
                                 window.location.replace("index.php?p=windows&a=copies"+urlAppend);
                             } else {
                                window.location.replace("index.php?p=windows&a=serverStatus&serverStatus="+(urlParams.get('serverStatus')));
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
            <div class="col-sm-6">
            <script type="text/javascript">  
                google.charts.load('current', {'packages':['corechart']});  
                google.charts.setOnLoadCallback(drawChart_copy);  
                google.charts.setOnLoadCallback(drawChart_check);  
                function drawChart_copy()  
                {  
                    var urlParams = new URLSearchParams(location.search);
                    var name = urlParams.getAll('name[]');
                    console.log(name);
                    $("#loader-copy").show();
                    var serverData = $.ajax({
                        url: "index.php?p=windows&a=getData",
                        type: "POST",
                        data: {"name": name, "type": "copy", "day": urlParams.get('day') },
                        dataType: "json",
                        async: false
                    }).responseText;
                    var array = JSON.parse(serverData);
                    var data = google.visualization.arrayToDataTable(array);  
                    $("#loader-copy").hide();
                    var options = {  
                        title: 'Percentage of Windows LOG Copy Success and Failure',  
                        is3D:true,  
                        pieHole: 0.4,  
                        colors: ['red',  'green',]
                    };  
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
                        window.location.replace("index.php?p=windows&a=copies"+urlAppend); 
                    });
                } 
                function drawChart_check()  
                {  
                    var urlParams = new URLSearchParams(location.search);
                    var name = urlParams.getAll('name[]');
                    $("#loader-check").show();
                    var serverData = $.ajax({
                        url: "index.php?p=windows&a=getData",
                        type: "POST",
                        data: {"name": name, "type": "check", "day": urlParams.get('day')},
                        dataType: "json",
                        async: false
                    }).responseText;
                    var array_check = JSON.parse(serverData);
                    var data_check = google.visualization.arrayToDataTable(array_check);  
                    $("#loader-check").hide();
                    var options_check = {  
                        title: 'Percentage of Windows LOG Check Success and Failure',  
                        is3D:true,  
                        pieHole: 0.4,
                        colors:  ['red',  'green'],
                        pieSliceTextStyle: {
                            color: 'black'
                        }  
                    };
                    var chart_check = new google.visualization.PieChart(document.getElementById('piechart_check'));  
                    chart_check.draw(data_check, options_check);  

                    google.visualization.events.addListener(chart_check, 'select', function() {
                        var selection = chart_check.getSelection();
                        var value = data_check.getValue(selection[0].row, 0);
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
                        window.location.replace("index.php?p=windows&a=checks"+urlAppend);  
                    });  
                } 
            </script>  
            
                
            <div style="">  
                <div id="loader-copy" class="graph-loader row "></div>
                <div id="piechart_copy" style="width: 100%; height: 400px;"></div>   
            </div> 
                
        </div>
        <div class="col-sm-6">    
            <div style="">  
                <div id="loader-check" class="graph-loader row "></div>
                <div id="piechart_check" style="width: 100%; height: 400px;"></div>   
            </div>  
        </div>
        <?php } ?>
    </div>
</div>
</div>