@extends('layout.main')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
 <!--   <h1 class="h3 mb-0 text-gray-800">Dashboard  $numero   $color</h1> -->
 <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
 <!--<a href="/admin/dashboard/pdf" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">
    <i class="fas fa-print fa-sm text-white-50"></i>&nbsp;Descargar en PDF</a>-->
<a onclick="generatePDF()" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Descargar en PDF</a>
    <!--<a href="/admin/download-pdf" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">-->

       <!-- <a href="admin/download-pdf">Download PDF File</a>-->
      <!-- <a href="admin/downloadpdf" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">-->
    <!--<i class="fas fa-print fa-sm text-white-50"></i>&nbsp;Descargar en PDF</a>-->
</div>
      <!-- Content Row -->
      <div class="row" id="invoice">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4" >
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                     <div class="col mr-2" >
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Dnis generados</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $all_dni }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-address-card fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


          <div class="col-xl-3 col-md-6 mb-4" data-html2canvas-ignore="true">
              <div class="card border-left-info shadow h-100 py-2">
                  <div class="card-body">
                      <div class="row no-gutters align-items-center">
                          <div class="col mr-2">
                              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                  Primer dni generado:</div>
                              <div class="font-weight-bold text-gray-800"> {{ $firstDniGeneratedMessage1 }}</div>                                              
                          </div>
                          <div class="col-auto">
                              <i class="fas fa-info-circle fa-2x text-gray-300"></i>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="col-xl-3 col-md-6 mb-4" data-html2canvas-ignore="true">
              <div class="card border-left-info shadow h-100 py-2">
                  <div class="card-body">
                      <div class="row no-gutters align-items-center">
                          <div class="col mr-2">
                              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                  Último dni generado:</div>
                              <div class="font-weight-bold text-gray-800">{{ $lastDniGeneratedMessage1 }}</div>
                          </div>
                          <div class="col-auto">
                              <i class="fas fa-info-circle fa-2x text-gray-300"></i>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4" data-html2canvas-ignore="true">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Usuarios registrados</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $all_user }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

     <!-- <div class="col-xl-6 col-md-1 mb-4" >
        <div class="d-flex justify-content-center card border-left-success shadow h-100 py-2" style="width:100%;">  
        <div id="pie_chart"></div>
        </div>
      </div>-->
      <div class="col-xl-6 col-md-1 mb-4">
        <div class="d-flex justify-content-center card border-left-success shadow h-100 py-2" style="width:100%;">
      <div id="chart_wrap">
        <div id="pie_chart" style="height:50vh;"></div>
      </div>
      </div></div>

      <div class="col-xl-6 col-md-1 mb-4">
        <div class="d-flex justify-content-center card border-left-danger shadow h-100 py-2" style="width:100%;">
      <div id="chart_wrap">
        <canvas id="canvas"></canvas>  
      </div>
      </div></div>


      </div>

<style>
@media (max-width: 450px) {
  #pie_chart {
   width: 350px;
  height: 0vh;
  }
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<!--<script src="https://raw.githubusercontent.com/nnnick/Chart.js/master/dist/Chart.bundle.js"></script>
-->
<!--<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.0/chart.min.js"></script>
<script type="text/javascript">
    var year = <?php echo $department; ?>; 
    var data_click = <?php echo $amount; ?>;  
    
  
    var barChartData = {  
        labels: year,  
        datasets: [{  
            label: 'Total Generados',  
            //backgroundColor: "rgba(220,220,220,0.5)", 
            backgroundColor: "orange", 
            data: data_click  
        },]  
    };  

    window.onload = function() {  
        var ctx = document.getElementById("canvas").getContext("2d");  
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
                }
                
        };
        var chart = new google.visualization.PieChart(document.getElementById('pie_chart'));
        chart.draw(data, options);
        
    }

    /**
    *
    * Function for generate a PDF to download with a JS Function 
    *
    */
    /* @TODO: Update the Style for PDF */
    //https://stackoverflow.com/questions/15084329/how-to-set-landscape-orientation-using-html2pdf
    function generatePDF() {
        const element2 = document.getElementById('invoice');
        //element2.style.backgroundColor = 'red';
        //const element = document.getElementsByClassName("invoice");
        //const element = document.getElementsByClassName('invoice');
       //const element = "<h1>Hola</h1>"+
        //"<p>Me llamo Luis Ángel</p>";
        var opt = {
        margin:       1,
        filename:     'myfile.pdf',
        image:        { type: 'png', quality: 1 },
        html2canvas:  { scale: 1 },
        // orientation: 'landscape' or 'portrait'
        jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
        };
        html2pdf()
            .set(opt)
            .from(element2)
            .save(); 
    }

</script>
@endsection
