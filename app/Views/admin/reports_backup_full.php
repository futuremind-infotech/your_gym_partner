<?php
$db = \Config\Database::connect();
// Pre-fetch data for charts using CI4 builder
$genderQuery = $db->query("SELECT gender, count(*) as number FROM members GROUP BY gender")->getResultArray();
$earningsQuery = $db->query("SELECT gender, SUM(amount) as numberone FROM members")->getRowArray();
$expensesQuery = $db->query("SELECT quantity, SUM(amount) as numbert FROM equipment")->getRowArray();
$servicesQuery = $db->query("SELECT services, count(*) as number FROM members GROUP BY services")->getResultArray();
?>

<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Chart Reports<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h2 class="page-title">Chart Representation</h2>
    <div class="breadcrumb">
        <a href="<?= base_url('admin') ?>">Home</a> / Reports
    </div>
</div>

<div class="grid-container" style="grid-template-columns: 1fr;">
    <!-- Earnings vs Expenses -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-chart-bar"></i> Earning and Expenses Report</h3>
        </div>
        <div class="card-body">
            <div id="top_y_div" style="width: 100%; height: 350px;"></div>
        </div>
    </div>
    
    <!-- Member Gender -->
    <div class="card">
         <div class="card-header">
            <h3 class="card-title"><i class="fas fa-chart-pie"></i> Registered Member's Gender Report</h3>
        </div>
        <div class="card-body">
            <div id="piechart" style="width: 100%; height: 400px;"></div>  
        </div>
    </div>

    <!-- Services -->
    <div class="card">
         <div class="card-header">
            <h3 class="card-title"><i class="fas fa-chart-area"></i> Services Popularity Report</h3>
        </div>
        <div class="card-body">
            <div id="top_x_div" style="width: 100%; height: 350px;"></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart', 'bar']});
    
    // Draw all charts
    google.charts.setOnLoadCallback(drawGenderChart);
    google.charts.setOnLoadCallback(drawEarningsChart);
    google.charts.setOnLoadCallback(drawServicesChart);

    function drawGenderChart() {
        var data = google.visualization.arrayToDataTable([  
            ['Gender', 'Number'],  
            <?php  
            foreach($genderQuery as $row) {  
                echo "['".$row["gender"]."', ".$row["number"]."],";  
            }  
            ?>  
        ]);  
        var options = {  
            title: 'Percentage of Male and Female GYM Members',  
            pieHole: 0.4,
            colors: ['#3b82f6', '#ec4899', '#f59e0b']
        };  
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));  
        chart.draw(data, options);  
    }

    function drawEarningsChart() {
        var data = new google.visualization.arrayToDataTable([
            ['Type', 'Total Amount',],
            ['Earnings', <?= $earningsQuery['numberone'] ?? 0 ?>],
            ['Expenses', <?= $expensesQuery['numbert'] ?? 0 ?>]
        ]);

        var options = {
            legend: { position: 'none' },
            bars: 'horizontal', 
            axes: {
                x: { 0: { side: 'top', label: 'Total Amount (₹)'} }
            },
            bar: { groupWidth: "60%" },
             colors: ['#10b981'] 
        };

        var chart = new google.charts.Bar(document.getElementById('top_y_div'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
    }

    function drawServicesChart() {
        var data = new google.visualization.arrayToDataTable([
            ['Services', 'Total Numbers'],
            <?php
            foreach($servicesQuery as $data){
                echo "['".$data['services']."', ".$data['number']."],";   
            }
            ?> 
        ]);

        var options = {
            legend: { position: 'none' },
            bars: 'horizontal', 
            axes: {
                x: { 0: { side: 'top', label: 'Total Members'} }
            },
            bar: { groupWidth: "60%" },
            colors: ['#6366f1']
        };

        var chart = new google.charts.Bar(document.getElementById('top_x_div'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
    
    // Redraw on resize
    window.addEventListener('resize', function() {
        drawGenderChart();
        drawEarningsChart();
        drawServicesChart();
    });
</script>
<?= $this->endSection() ?>

<title>Gym System Admin</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="../css/bootstrap.min.css" />
<link rel="stylesheet" href="../css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="../css/fullcalendar.css" />
<link rel="stylesheet" href="../css/matrix-style.css" />
<link rel="stylesheet" href="../css/matrix-media.css" />
<link href="../font-awesome/css/fontawesome.css" rel="stylesheet" />
<link href="../font-awesome/css/all.css" rel="stylesheet" />
<link rel="stylesheet" href="../css/jquery.gritter.css" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>  
           <script type="text/javascript">  
           google.charts.load('current', {'packages':['corechart']});  
           google.charts.setOnLoadCallback(drawChart);  
           function drawChart()  
           {  
                var data = google.visualization.arrayToDataTable([  
                          ['Gender', 'Number'],  
                          <?php  
                          while($row = mysqli_fetch_array($result))  
                          {  
                               echo "['".$row["gender"]."', ".$row["number"]."],";  
                          }  
                          ?>  
                     ]);  
                var options = {  
                      title: 'Percentage of Male and Female GYM Members',  
                      //is3D:true,  
                      pieHole: 0.0 
                     };  
                var chart = new google.visualization.PieChart(document.getElementById('piechart'));  
                chart.draw(data, options);  
           }  
           </script>

           <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
          ['Terms', 'Total Amount',],
          
          <?php
          $query1 = "SELECT gender, SUM(amount) as numberone FROM members; ";

            $rezz=mysqli_query($con,$query1);
            while($data=mysqli_fetch_array($rezz)){
              $services='Earnings';
              $numberone=$data['numberone'];
              // $numbertwo=$data['numbertwo'];
           ?>
           ['<?php echo $services;?>',<?php echo $numberone;?>,],   
           <?php   
            }
           ?> 

      <?php
          $query10 = "SELECT quantity, SUM(amount) as numbert FROM equipment";
            $res1000=mysqli_query($con,$query10);
            while($data=mysqli_fetch_array($res1000)){
              $expenses='Expenses';
              $numbert=$data['numbert'];
              
           ?>
           ['<?php echo $expenses;?>',<?php echo $numbert;?>,],   
           <?php   
            }
           ?> 

          
        ]);

        var options = {
         
          width: "1050",
          legend: { position: 'none' },
          
          bars: 'horizontal', // Required for Material Bar Charts.
          axes: {
            x: {
              0: { side: 'top', label: 'Total'} // Top x-axis.
            }
          },
          bar: { groupWidth: "100%" }
        };

        var chart = new google.charts.Bar(document.getElementById('top_y_div'));
        chart.draw(data, options);
      };


      
    </script>

    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
          ['Services', 'Total Numbers'],
          // ["King's pawn (e4)", 44],
          // ["Queen's pawn (d4)", 31],
          // ["Knight to King 3 (Nf3)", 12],
          // ["Queen's bishop pawn (c4)", 10],
          // ['Other', 3]

          <?php
            $query="SELECT services, count(*) as number FROM members GROUP BY services";
            $res=mysqli_query($con,$query);
            while($data=mysqli_fetch_array($res)){
              $services=$data['services'];
              $number=$data['number'];
           ?>
           ['<?php echo $services;?>',<?php echo $number;?>],   
           <?php   
            }
           ?> 

          
        ]);

        var options = {
          // title: 'Chess opening moves',
          width: 1050,
          legend: { position: 'none' },
          // chart: { title: 'Chess opening moves',
          //          subtitle: 'popularity by percentage' },
          bars: 'horizontal', // Required for Material Bar Charts.
          axes: {
            x: {
              0: { side: 'top', label: 'Total'} // Top x-axis.
            }
          },
          bar: { groupWidth: "100%" }
        };

        var chart = new google.charts.Bar(document.getElementById('top_x_div'));
        chart.draw(data, options);
      };


      
    </script>
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="dashboard.html">Perfect Gym Admin</a></h1>
</div>
<!--close-Header-part--> 


<!--top-Header-menu-->
<?php include 'includes/topheader.php'?>
<!--close-top-Header-menu-->
<!--start-top-serch-->
<!-- <div id="search">
  <input type="hidden" placeholder="Search here..."/>
  <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
</div> -->
<!--close-top-serch-->
<!-- Visit codeastro.com for more projects -->
<!--sidebar-menu-->
<?php $page='chart'; include 'includes/sidebar.php'?>
<!--sidebar-menu-->

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.php" title="Go to Home" class="tip-bottom"><i class="fas fa-home"></i> Home</a> <a href="reports.php" class="current">Chart Representation</a> </div>
    <h1 class="text-center">Earning and Expenses Report <i class="fas fa-chart-bar"></i></h1>
  </div>
  <div class="container-fluid">
    
    <div class="row-fluid">
      <div class="span12">
        <div id="top_y_div" style="width: 700px; height: 300px;"></div>
      </div>
    </div>
  </div>

  <div id="content-header">
    <h1 class="text-center">Registered Member's Report <i class="fas fa-chart-bar"></i></h1>
  </div>
  <div class="container-fluid">
    
    <div class="row-fluid">
      <div class="span12">
                <div id="piechart" style="width: 800px; height: 450px; margin-left:auto; margin-right:auto;"></div>  
      </div>
    </div>
  </div>

  <div id="content-header">
    <h1 class="text-center">Services Report <i class="fas fa-chart-bar"></i></h1>
  </div>
  <div class="container-fluid">
    
    <div class="row-fluid">
      <div class="span12">
        <div id="top_x_div" style="width: 1000px; height: 350px;"></div>
      </div>
    </div>
  </div>
</div>


  


<!--end-main-container-part-->

<!--Footer-part-->

<div class="row-fluid">
  <div id="footer" class="span12"> <?php echo date("Y");?> &copy; Developed By Naseeb Bajracharya</a> </div>
</div>

<style>
#footer {
  color: white;
}
</style>

<!--end-Footer-part-->

<script src="../js/excanvas.min.js"></script> 
<script src="../js/jquery.min.js"></script> 
<script src="../js/jquery.ui.custom.js"></script> 
<script src="../js/bootstrap.min.js"></script> 
<script src="../js/jquery.flot.min.js"></script> 
<script src="../js/jquery.flot.resize.min.js"></script> 
<script src="../js/jquery.peity.min.js"></script> 
<script src="../js/fullcalendar.min.js"></script> 
<script src="../js/matrix.js"></script> 
<script src="../js/matrix.dashboard.js"></script> 
<script src="../js/jquery.gritter.min.js"></script> 
<script src="../js/matrix.interface.js"></script> 
<script src="../js/matrix.chat.js"></script> 
<script src="../js/jquery.validate.js"></script> 
<script src="../js/matrix.form_validation.js"></script> 
<script src="../js/jquery.wizard.js"></script> 
<script src="../js/jquery.uniform.js"></script> 
<script src="../js/select2.min.js"></script> 
<script src="../js/matrix.popover.js"></script> 
<script src="../js/jquery.dataTables.min.js"></script> 
<script src="../js/matrix.tables.js"></script> 

</body>
</html>

