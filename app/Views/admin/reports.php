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



