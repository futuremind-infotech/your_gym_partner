<?php
// Data is now passed from the Dashboard controller
?>

<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h2 class="page-title">Dashboard Overview</h2>
    <div class="breadcrumb">
        <i class="fas fa-home"></i> Home / Dashboard
    </div>
</div>

<div class="grid-container" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
    <!-- Active Members -->
    <a href="<?= base_url('admin/members') ?>" class="card stat-card">
        <div class="stat-content">
            <h3><?php include 'actions/dashboard-activecount.php'?></h3>
            <p>Active Members</p>
        </div>
        <div class="stat-icon bg-info">
            <i class="fas fa-user-check"></i>
        </div>
    </a>

    <!-- Registered Members -->
    <a href="<?= base_url('admin/members') ?>" class="card stat-card">
        <div class="stat-content">
            <h3><?php include 'dashboard-usercount.php'?></h3>
            <p>Registered Members</p>
        </div>
        <div class="stat-icon bg-warning">
            <i class="fas fa-users"></i>
        </div>
    </a>

    <!-- Earnings -->
    <a href="<?= base_url('admin/payment') ?>" class="card stat-card">
        <div class="stat-content">
            <h3>₹<?php include 'income-count.php' ?></h3>
            <p>Total Earnings</p>
        </div>
        <div class="stat-icon bg-success">
            <i class="fas fa-dollar-sign"></i>
        </div>
    </a>

     <!-- Announcements -->
     <a href="<?= base_url('admin/announcement') ?>" class="card stat-card">
        <div class="stat-content">
            <h3><?php include 'actions/count-announcements.php'?></h3>
            <p>Announcements</p>
        </div>
        <div class="stat-icon bg-danger">
            <i class="fas fa-bullhorn"></i>
        </div>
    </a>
</div>

<div class="grid-container" style="grid-template-columns: 2fr 1fr;">
    <!-- Services Report Chart -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Services Popularity</h3>
        </div>
        <div class="card-body">
            <div id="top_x_div" style="width: 100%; height: 300px;"></div>
        </div>
    </div>

    <!-- Quick Stats List -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Gym Statistics</h3>
        </div>
        <div class="card-body" style="padding: 0;">
            <table class="modern-table">
                <tbody>
                    <tr>
                        <td><i class="fas fa-users text-info"></i> Total Members</td>
                        <td class="text-right"><strong><?php include 'dashboard-usercount.php';?></strong></td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-user-clock text-warning"></i> Staff Users</td>
                        <td class="text-right"><strong><?php include 'actions/dashboard-staff-count.php';?></strong></td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-dumbbell text-success"></i> Equipments</td>
                        <td class="text-right"><strong><?php include 'actions/count-equipments.php';?></strong></td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-file-invoice-dollar text-danger"></i> Expenses</td>
                        <td class="text-right"><strong>₹<?php include 'actions/total-exp.php';?></strong></td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-user-ninja text-primary"></i> Trainers</td>
                        <td class="text-right"><strong><?php include 'actions/count-trainers.php';?></strong></td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-calendar-check text-info"></i> Present</td>
                        <td class="text-right"><strong><?php include 'actions/count-attendance.php';?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="grid-container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Financial Overview</h3>
        </div>
        <div class="card-body">
            <div id="top_y_div" style="width: 100%; height: 250px;"></div>
        </div>
    </div>
</div>

<div class="grid-container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Members by Gender</h3>
        </div>
        <div class="card-body">
            <div id="donutchart" style="width: 100%; height: 300px;"></div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Staff by Designation</h3>
        </div>
        <div class="card-body">
             <div id="donutchart2022" style="width: 100%; height: 300px;"></div>
        </div>
    </div>
</div>

<div class="grid-container">
    <!-- Announcements List -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Recent Announcements</h3>
        </div>
        <div class="card-body">
            <ul style="padding-left: 0;">
                <?php
                $announcementsResult = $db->query("SELECT * FROM announcements ORDER BY date DESC LIMIT 5")->getResultArray();
                foreach($announcementsResult as $row){
                ?>
                <li style="border-bottom: 1px solid var(--gray-100); padding: 10px 0; list-style:none;">
                    <div style="display:flex; justify-content:space-between; margin-bottom: 5px;">
                         <span style="font-size: 0.8rem; color: var(--secondary);">
                            <i class="fas fa-calendar"></i> <?= $row['date'] ?>
                         </span>
                         <span class="badge badge-info">Admin</span>
                    </div>
                    <p style="margin: 0; font-weight: 500;"><?= $row['message'] ?></p>
                </li>
                <?php } ?>
            </ul>
            <div style="margin-top: 1rem; text-align: center;">
                <a href="<?= base_url('admin/announcement') ?>" class="btn btn-sm btn-primary">View All</a>
            </div>
        </div>
    </div>

    <!-- Todo List -->
    <div class="card">
         <div class="card-header">
            <h3 class="card-title">Customer To-Do List</h3>
        </div>
        <div class="card-body">
            <ul style="padding-left: 0;">
              <?php
                $todoResult = $db->query("SELECT * FROM todo LIMIT 5")->getResultArray();
                foreach($todoResult as $row){ ?>
                <li style="padding: 10px 0; border-bottom: 1px solid var(--gray-100); display: flex; justify-content: space-between; align-items: center;"> 
                    <span><?= $row["task_desc"]?></span>
                    <?php if ($row["task_status"] == "Pending") { 
                        echo '<span class="badge badge-warning">Pending</span>';
                    } else { 
                        echo '<span class="badge badge-success">In Progress</span>'; 
                    }?>
                </li>
               <?php } ?>
            </ul>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<!-- Services Chart -->
<script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
          ['Services', 'Total Numbers'],
          <?php
            if (is_array($result) && !empty($result)) {
              foreach($result as $item){
                if (is_array($item)) {
                  $services = $item['services'] ?? '';
                  $number = $item['number'] ?? 0;
           ?>
           ['<?php echo addslashes($services);?>',<?php echo intval($number);?>],   
           <?php 
                }
              }
            }
           ?> 
        ]);

        var options = {
          legend: { position: 'none' },
          bars: 'vertical', 
          axes: {
            x: {
              0: { side: 'top', label: 'Total Members'} 
            }
          },
          bar: { groupWidth: "50%" },
          colors: ['#6366f1']
        };

        var chart = new google.charts.Bar(document.getElementById('top_x_div'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
      };
</script>

<!-- Earnings/Expenses Chart -->
<script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawStuff2);

      function drawStuff2() {
        var data = new google.visualization.arrayToDataTable([
          ['Category', 'Amount',],
           ['Earnings', <?= intval($earningsResult['numberone'] ?? 0) ?>],
           ['Expenses', <?= intval($expensesResult['numbert'] ?? 0) ?>],
        ]);

        var options = {
          legend: { position: 'none' },
          bars: 'horizontal', 
          axes: {
            x: {
              0: { side: 'top', label: 'Amount (₹)'} 
            }
          },
          bar: { groupWidth: "50%" },
          colors: ['#10b981'] 
        };

        var chart = new google.charts.Bar(document.getElementById('top_y_div'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
      };
</script>

<!-- Gender Donut Chart -->
<script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChartGender);
      function drawChartGender() {
        var data = google.visualization.arrayToDataTable([  
                          ['Gender', 'Number'],  
                          <?php  
                          if (is_array($result3) && !empty($result3)) {
                            foreach($result3 as $row) {
                              if (is_array($row)) {
                                   echo "['" . addslashes($row["gender"] ?? '') . "', " . intval($row["enumber"] ?? 0) . "],";
                              }
                            }
                          }
                          ?>  
                     ]); 

        var options = {
          pieHole: 0.4,
          colors: ['#3b82f6', '#ec4899', '#f59e0b']
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
</script>

<!-- Staff Donut Chart -->
<script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChartStaff);
      function drawChartStaff() {
        var data = google.visualization.arrayToDataTable([  
                          ['Designation', 'Number'],  
                          <?php  
                          if (is_array($result5) && !empty($result5)) {
                            foreach($result5 as $row) {
                              if (is_array($row)) {
                                   echo "['" . addslashes($row["designation"] ?? '') . "', " . intval($row["snumber"] ?? 0) . "],";
                              }
                            }
                          }
                          ?>  
                     ]); 

        var options = {
          pieHole: 0.4,
          colors: ['#8b5cf6', '#10b981', '#f97316']
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart2022'));
        chart.draw(data, options);
      }
</script>
<?= $this->endSection() ?>
