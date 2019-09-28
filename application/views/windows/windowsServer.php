<div class="row">
  <div class="col-sm-6">
    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>  
    <script type="text/javascript">  
        google.charts.load('current', {'packages':['corechart']});  
        google.charts.setOnLoadCallback(drawChart_copy);  
        google.charts.setOnLoadCallback(drawChart_check);  
        function drawChart_copy()  
        {  
            var data = google.visualization.arrayToDataTable([  
                ['Status', 'Count'],  
                <?php  
                foreach ($copies as $row) {  
                    $trimmed = trim($row["status"], " \r.");
                    echo "['".$trimmed."', ".$row["count"]."],"; 
                }  
                ?>  
            ]);  
            var options = {  
                title: 'Percentage of Windows LOG Copy Success and Failure',  
                //is3D:true,  
                pieHole: 0.4,  
                colors: ['red', 'green']
            };  
            var chart = new google.visualization.PieChart(document.getElementById('piechart_copy'));  
            chart.draw(data, options);  

            google.visualization.events.addListener(chart, 'select', function() {
                var selection = chart.getSelection();
                var urlParams = new URLSearchParams(location.search);
                var name = urlParams.get('name');
                var urlAppend = (name) ? "&name="+name : '';
                window.location.replace("index.php?p=windows&a=copies"+urlAppend); 
            });
        } 
        function drawChart_check()  
        {  
            var data_check= google.visualization.arrayToDataTable([  
                ['Status', 'Count'],  
                <?php  
                foreach ($checks as $row) {  
                    $trimmed = trim($row["status"], " \r.");
                    echo "['".$trimmed."', ".$row["count"]."],"; 
                }  
                ?> 
            ]);  
            var options_check = {  
                title: 'Percentage of Windows LOG Check Success and Failure',  
                //is3D:true,  
                pieHole: 0.4,
                colors: ['green'],
                pieSliceTextStyle: {
                    color: 'black'
                }  
            };
            var chart_check = new google.visualization.PieChart(document.getElementById('piechart_check'));  
            chart_check.draw(data_check, options_check);  

            google.visualization.events.addListener(chart_check, 'select', function() {
                var selection = chart_check.getSelection();
                window.location.replace("index.php?p=windows&a=checks");  
            });  
        } 
    </script>  
     
           
    <div style="">    
        <div id="piechart_copy" style="width: 100%; height: 400px;"></div>   
    </div> 
           
  </div>
  <div class="col-sm-6">    
    <div style="">   
        <div id="piechart_check" style="width: 100%; height: 400px;"></div>   
    </div>  
  </div>
</div>