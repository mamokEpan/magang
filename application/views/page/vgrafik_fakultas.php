<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html>
        <!-- page content -->
        <div class="right_col" role="main">

          <!-- top tiles -->
          
          <!-- /top tiles -->

          <br />
          <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>GRAFIK FAKULTAS<small>Asrama Almunawwarah UIR-presentation</small></h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                          </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
    <div class="x_content">
        <div class="dashboard-widget-content">
      
    <?php
foreach($data as  $j => $value){
  $arrayfak[] = ['name' => $value->nama_fakultas,'y' => $value->jumlahfak,'drilldown' => $value->nama_fakultas];
}
$i = 0;
// error_reporting(~E_NOTICE);
$arrayjur = array();
foreach($jur as $j => $value){
  // $arraynamaprov[] = ['name' => $value->name_prov,'y' => $value->jumlah];  
  if($i > 0 and ($arrayjur[$i-1]['name'] == $value->nama_fakultas and $arrayjur[$i-1]['id'] == $value->nama_fakultas)){
    $arrayjur[$i-1]['data'][] = array($value->nama_jurusan, $value->jumlahjur);
  }else{
    $arrayjur[] = [
      'name' => $value->nama_fakultas,
      'id' => $value->nama_fakultas, 
      'data' => array(array($value->nama_jurusan, $value->jumlahjur))
    ];
    $i++;
        }
      }
      ?> 

      <script src="assets/highcharts/code/highcharts.js"></script>
      <script src="assets/highcharts/code/modules/data.js"></script>
      <script src="assets/highcharts/code/modules/drilldown.js"></script>
      <script src="assets/highcharts/code/modules/exporting.js"></script>
      <script src="assets/highcharts/code/modules/export-data.js"></script>
      <script src="assets/highcharts/code/modules/accessibility.js"></script>
<!-- <script src="assets/css/tes.css"> </script> -->
<a href="grafik_fakultas" class="btn btn-primary">Refresh</a>
<figure class="highcharts-figure">
  <div id="container"> 
    <!-- untuk menampilkan. buat tombol kwmbLI -->
    <script type="text/javascript">
      // Create the chart
                Highcharts.chart('container', {
                  chart: {
                    type: 'column'
                  },
                  title: {
                    text: ''
                  },
                  subtitle: {
                    // text: 'Click the columns to view versions. Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>'
                  },
                  accessibility: {
                    announceNewData: {
                      enabled: true
                    }
                  },
                  xAxis: {
                    type: 'category'
                  },
                  yAxis: {
                    title: {
                      text: ''
                    }

                  },
                  legend: {
                    enabled: false
                  },
                  plotOptions: {
                    series: {
                      borderWidth: 0,
                      dataLabels: {
                        enabled: true,
                        format: '{point.y:.f}'
                      }
                    }
                  },

                  tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:. f} mahasiswa</b><br/>'
                  },

                  series: [
                                  {
                    name: "Fakultas",
                    colorByPoint: true,
                    data: 
                      <?=json_encode($arrayfak, JSON_NUMERIC_CHECK);?>
                        
                  }
                ],
                drilldown: {
                  series: 
                    <?=json_encode($arrayjur, JSON_NUMERIC_CHECK);?>
                }
                });

    </script>
  </div>
                  <p class="highcharts-description">
                   
                  </p>
</figure>
            </div>
            </div>
          </div>
        </div>
      </div> 
    </div>
  
        
      </div>
    </div>

   </body>
</html>