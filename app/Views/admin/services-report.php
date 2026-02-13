<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Services Report<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h2 class="page-title">GYM Services Report</h2>
    <div class="breadcrumb">
        <a href="<?= base_url('admin') ?>">Home</a> / <a href="<?= base_url('admin/reports') ?>">Reports</a> / Services Report
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-bar-chart"></i> Services Distribution Chart</h3>
    </div>
    <div class="card-body">
        <div id="piechart" style="width: 100%; height: 450px; display: flex; justify-content: center;"></div>
    </div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Services', 'Number'],
            <?php
            if (!empty($services)) {
                foreach ($services as $service) {
                    echo "['" . htmlspecialchars($service['services'], ENT_QUOTES) . "', " . intval($service['number']) . "],";
                }
            }
            ?>
        ]);

        var options = {
            title: 'Percentage of Services Taken by Perfect GYM Members',
            pieHole: 0.4,
            chartArea: { width: '80%', height: '80%' },
            legend: { position: 'bottom' }
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
    }

    // Redraw chart on window resize
    window.addEventListener('resize', function() {
        drawChart();
    });
</script>

<?= $this->endSection() ?>

