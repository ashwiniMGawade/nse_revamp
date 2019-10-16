<div class="row">
  <div class="col-sm-6">
    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>  
    <script type="text/javascript">  
        google.charts.load('current', {'packages':['corechart']});  
        google.charts.setOnLoadCallback(drawChart_copy);  
        function drawChart_copy()  
        {  
            var urlParams = new URLSearchParams(location.search);
            var name = urlParams.get('name');
            var serverData = $.ajax({
                url: "index.php?p=linux&a=getData",
                type: "POST",
                data: {"name": name},
                dataType: "json",
                async: false
            }).responseText;
            var array = JSON.parse(serverData);
            var data = google.visualization.arrayToDataTable(array);  
            var options = {  
                title: 'Percentage of Linux LOG Copy/Check Success and Failure',  
                is3D:true,  
                pieHole: 0.4,  
                colors: ['red', 'green']
            };  
            var chart = new google.visualization.PieChart(document.getElementById('piechart_copy'));  
            chart.draw(data, options);  

            google.visualization.events.addListener(chart, 'select', function() {
                var selection = chart.getSelection();
                var value = data.getValue(selection[0].row, 0);                
                var urlAppend = (name) ? "&name="+name : '';
                value = value.toLowerCase();
                value = (value == "failure"? "failed": value);
                urlAppend += value !== ''? "&status="+value.toLowerCase() : "";
                window.location.replace("index.php?p=linux&a=copyChecks"+urlAppend);  
            });
        } 
     
    </script>  
     
           
    <div style="">    
        <div id="piechart_copy" style="width: 100%; height: 400px;"></div>   
    </div> 
           
  </div>  
</div>