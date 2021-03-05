<?php

/* @var $this yii\web\View */
$this->title = 'Dashboard';

//$tableData = array_diff($tableData,$stk);

function generateRandomColor()
{
    $colors = [
        "info",
        "aqua",
        "success",
        "warning",
        "danger",
        "gray",
        "navy",
        "teal",
        "purple",
        "green",
        "pink",
        "red",
        "blue",
        "yellow",
        "orange",
        "maroon",
        "black",
    ];
    $len = count($colors);
    $num = random_int(0, $len - 1);
    return $colors[$num];
}

?>

<div class="site-index">

    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-<?= generateRandomColor() ?>">
                <div class="inner">
                    <h3><?=$pengajuan?></h3>

                    <p>Riwayat Pengajuan</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-<?= generateRandomColor() ?>">
                <div class="inner">
                    <h3><?=$toko?></h3>

                    <p>Toko</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-<?= generateRandomColor() ?>">
                <div class="inner">
                    <h3><?=$kategori_peralatan?></h3>

                    <p>kategori peralatan</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-<?= generateRandomColor() ?>">
                <div class="inner">
                    <h3><?=$peralatan?></h3>

                    <p>Peralatan</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-<?= generateRandomColor() ?>">
                <div class="inner">
                    <h3><?=$pengajuan_perlu_acc?></h3>

                    <p>Pengajuan Perlu Acc</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-<?= generateRandomColor() ?>">
                <div class="inner">
                    <h3><?=$pengajuan_revisi?></h3>

                    <p>Pengajuan Perlu Revisi</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-<?= generateRandomColor() ?>">
                <div class="inner">
                    <h3><?=$pengajuan_bulan_ini?></h3>

                    <p>Pengajuan Bulan Ini</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-<?= generateRandomColor() ?>">
                <div class="inner">
                    <h3><?=$pengajuan_tahun_ini?></h3>

                    <p>Pengajuan Tahun Ini</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-<?= generateRandomColor() ?>">
                <div class="inner">
                    <h3><?=$pengajuan_tahun_lalu?></h3>

                    <p>Pengajuan Tahun Lalu</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-12 col-xs-12">
          <!-- LINE CHART -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Grafik Pengajuan Per Bulan</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="lineChart" style="height:250px"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    </div>
</div>

<?php
$this->registerJs("
var areaChartData = {
    labels  : ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
    datasets: [
      {
        label               : 'Electronics',
        fillColor           : 'rgba(210, 214, 222, 1)',
        strokeColor         : 'rgba(210, 214, 222, 1)',
        pointColor          : 'rgba(210, 214, 222, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(220,220,220,1)',
        data                : ". json_encode($data_chart) ."
      },
    ]
  }

  var areaChartOptions = {
    //Boolean - If we should show the scale at all
    showScale               : true,
    //Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines      : false,
    //String - Colour of the grid lines
    scaleGridLineColor      : 'rgba(0,0,0,.05)',
    //Number - Width of the grid lines
    scaleGridLineWidth      : 1,
    //Boolean - Whether to show horizontal lines (except X axis)
    scaleShowHorizontalLines: true,
    //Boolean - Whether to show vertical lines (except Y axis)
    scaleShowVerticalLines  : true,
    //Boolean - Whether the line is curved between points
    bezierCurve             : true,
    //Number - Tension of the bezier curve between points
    bezierCurveTension      : 0.3,
    //Boolean - Whether to show a dot for each point
    pointDot                : false,
    //Number - Radius of each point dot in pixels
    pointDotRadius          : 4,
    //Number - Pixel width of point dot stroke
    pointDotStrokeWidth     : 1,
    //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
    pointHitDetectionRadius : 20,
    //Boolean - Whether to show a stroke for datasets
    datasetStroke           : true,
    //Number - Pixel width of dataset stroke
    datasetStrokeWidth      : 2,
    //Boolean - Whether to fill the dataset with a color
    datasetFill             : true,
    //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio     : true,
    //Boolean - whether to make the chart responsive to window resizing
    responsive              : true
  }

  //-------------
  //- LINE CHART -
  //--------------
  var lineChartCanvas          = $('#lineChart').get(0).getContext('2d')
  var lineChart                = new Chart(lineChartCanvas)
  areaChartOptions.datasetFill = false
  lineChart.Line(areaChartData, areaChartOptions)

");
