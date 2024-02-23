<div id="invoice2">

<div class="chart_wrap">
    <div class="title"> <h2>Reporte de PEID</h2></div>
    </div>
    <div class="chart_wrap">
    <div class="dni_generado">
        {{ $all_dni }} Dni's generados a la fecha del: @php echo date("d-m-Y")@endphp
    </div>
    </div>
    
    <div class="chart_wrap">
        <div id="pie_charts" style="height:50vh;"></div>
      </div>
    
      <div class="chart_wrap">
        <canvas id="canvas2"></canvas>  
      </div>
</div>

    <style>
        #invoice2{
           /* visibility: hidden;*/
            /*display: none;*/
        }

    .chart_wrap{
        padding: 1%;
        width: 50%;   
    }
    .dni_generado{
        background-color: white;
        padding: 3%;
        border-radius: 5px;
        text-align: center;
        font-weight: bold;
        box-shadow: 20px -16px #F15B5B;
        border-width: 1px;
      border-style: solid;
      border-color: black;
    }
    .title{
        font-weight: bold;
        text-align: center;
        color: #F15B5B;
        text-decoration-line: underline;
      text-decoration-style: double;
    }
    </style>
    
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.0/chart.min.js"></script>
     <!-- <script type="text/javascript" src="https://www.google.com/jsapi"></script>-->
      <script type="text/javascript">
        var year = <?php echo $department; ?>; 
        var data_click = <?php echo $amount; ?>;  
        
      
        var barChartData = {  
            labels: year,  
            datasets: [{  
                label: 'Total Generados',  
                //backgroundColor: "rgba(220,220,220,0.5)", 
                backgroundColor: "#FFF800", 
                data: data_click  
            },]  
        };  
    
        window.onload = function() {  
            var ctx = document.getElementById("canvas2").getContext("2d");  
            window.myBar = new Chart(ctx, {  
                type: 'bar',  
                data: barChartData,  
                options: {  
                    elements: {  
                        rectangle: {  
                            borderWidth: 1,  
                            borderColor: 'rgb(2, 2, 2, 1)',  
                            borderSkipped: 'bottom'  
                        }  
                    },  
                    scales: {
                        yAxes: [{
                        ticks: {
                        beginAtZero: true
                        }
                    }],
                    },
                    responsive: true,  
                    title: {  
                        display: true,
                      // https://www.chartjs.org/docs/master/configuration/title.html
                        position: 'top',
                        text: 'Departamentos del Perú con más DNIs generados',
                        fontColor: 'black',
                        fontWeight: 'bold',
                        verticalAlign: 'left'
                       // font: {weight: 'bold'}  
                    }  
                }  
            });  
      
        };
        var analytics = <?php echo $course; ?>
        
       
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
      

       
       function drawChart() {
            var data = google.visualization.arrayToDataTable(analytics);
            var options = {
                title : 'Gráfico Pastel Según la Especies',
                //titleTextStyle
                pieSliceTextStyle: {
                    fontSize: 12,
                    bold: true
                    },
                    colors: ['#F15B5B', '#25EDF2', 'lime', 'yellow', '#062825'],
                
            };
            var chart = new google.visualization.PieChart(document.getElementById('pie_charts'));
            chart.draw(data, options);
            
        }
    
    
    </script>