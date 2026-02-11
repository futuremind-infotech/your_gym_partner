<?= $this->extend('admin/layout') ?>

<?= $this->section('header_title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('title') ?>Dashboard - Admin Panel<?= $this->endSection() ?>

<?= $this->section('content') ?>

<style>
    .dashboard-container {
        animation: fadeIn 0.5s ease;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="dashboard-container">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Dashboard</h1>
            <p class="page-subtitle">Welcome back! Here's your gym overview.</p>
        </div>
        <button class="btn btn-primary" onclick="location.reload()">
            <i class="fas fa-sync-alt"></i> Refresh
        </button>
    </div>

    <!-- Key Statistics Cards -->
    <div class="grid-container grid-4">
        <!-- Active Members Card -->
        <a href="<?= base_url('admin/members') ?>" class="stat-card">
            <div class="stat-content">
                <div class="stat-label">Active Members</div>
                <div class="stat-value" style="color: var(--info);">
                    <?php include 'actions/dashboard-activecount.php'?>
                </div>
            </div>
            <div class="stat-icon bg-info">
                <i class="fas fa-user-check"></i>
            </div>
        </a>

        <!-- Total Members Card -->
        <a href="<?= base_url('admin/members') ?>" class="stat-card">
            <div class="stat-content">
                <div class="stat-label">Total Members</div>
                <div class="stat-value" style="color: var(--primary);">
                    <?php include 'dashboard-usercount.php'?>
                </div>
            </div>
            <div class="stat-icon bg-primary">
                <i class="fas fa-users"></i>
            </div>
        </a>

        <!-- Total Earnings Card -->
        <a href="<?= base_url('admin/payment') ?>" class="stat-card">
            <div class="stat-content">
                <div class="stat-label">Total Earnings</div>
                <div class="stat-value" style="color: var(--success);">
                    ₹<?php include 'income-count.php' ?>
                </div>
            </div>
            <div class="stat-icon bg-success">
                <i class="fas fa-credit-card"></i>
            </div>
        </a>

        <!-- Announcements Card -->
        <a href="<?= base_url('admin/announcement') ?>" class="stat-card">
            <div class="stat-content">
                <div class="stat-label">Announcements</div>
                <div class="stat-value" style="color: var(--danger);">
                    <?php include 'actions/count-announcements.php'?>
                </div>
            </div>
            <div class="stat-icon bg-danger">
                <i class="fas fa-megaphone"></i>
            </div>
        </a>
    </div>

    <!-- Charts Row -->
    <div class="grid-container" style="grid-template-columns: 2fr 1fr;">
        <!-- Services Popularity Chart -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-bar" style="color: var(--primary); margin-right: 0.5rem;"></i>
                    Services Popularity
                </h3>
            </div>
            <div class="card-body">
                <div id="servicesChart" style="width: 100%; height: 320px;"></div>
            </div>
        </div>

        <!-- Quick Stats Panel -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie" style="color: var(--primary); margin-right: 0.5rem;"></i>
                    Quick Stats
                </h3>
            </div>
            <div class="card-body">
                <table style="width: 100;">
                    <tbody>
                        <tr style="border-bottom: 1px solid var(--gray-200); padding: 0.75rem 0;">
                            <td style="padding: 0.75rem 0;"><span style="color: var(--gray-600);"><i class="fas fa-users"></i> Members</span></td>
                            <td style="text-align: right; padding: 0.75rem 0;"><strong><?php include 'dashboard-usercount.php';?></strong></td>
                        </tr>
                        <tr style="border-bottom: 1px solid var(--gray-200); padding: 0.75rem 0;">
                            <td style="padding: 0.75rem 0;"><span style="color: var(--gray-600);"><i class="fas fa-users-cog"></i> Staff</span></td>
                            <td style="text-align: right; padding: 0.75rem 0;"><strong><?php include 'actions/dashboard-staff-count.php';?></strong></td>
                        </tr>
                        <tr style="border-bottom: 1px solid var(--gray-200); padding: 0.75rem 0;">
                            <td style="padding: 0.75rem 0;"><span style="color: var(--gray-600);"><i class="fas fa-dumbbell"></i> Equipment</span></td>
                            <td style="text-align: right; padding: 0.75rem 0;"><strong><?php include 'actions/count-equipments.php';?></strong></td>
                        </tr>
                        <tr style="border-bottom: 1px solid var(--gray-200); padding: 0.75rem 0;">
                            <td style="padding: 0.75rem 0;"><span style="color: var(--gray-600);"><i class="fas fa-money-bill"></i> Expenses</span></td>
                            <td style="text-align: right; padding: 0.75rem 0;"><strong>₹<?php include 'actions/total-exp.php';?></strong></td>
                        </tr>
                        <tr>
                            <td style="padding: 0.75rem 0;"><span style="color: var(--gray-600);"><i class="fas fa-check-circle text-success"></i> Present</span></td>
                            <td style="text-align: right; padding: 0.75rem 0;"><strong><?php include 'actions/count-attendance.php';?></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Financial Overview & Demographics -->
    <div class="grid-container">
        <!-- Financial Chart -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-line" style="color: var(--success); margin-right: 0.5rem;"></i>
                    Financial Overview
                </h3>
            </div>
            <div class="card-body">
                <div id="financialChart" style="width: 100%; height: 280px;"></div>
            </div>
        </div>

        <!-- Gender Distribution -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-venus-mars" style="color: var(--warning); margin-right: 0.5rem;"></i>
                    Members by Gender
                </h3>
            </div>
            <div class="card-body">
                <div id="genderChart" style="width: 100%; height: 280px;"></div>
            </div>
        </div>

        <!-- Staff Distribution -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-sitemap" style="color: var(--primary); margin-right: 0.5rem;"></i>
                    Staff by Designation
                </h3>
            </div>
            <div class="card-body">
                <div id="staffChart" style="width: 100%; height: 280px;"></div>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Announcements -->
    <div class="grid-container">
        <!-- Recent Announcements -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-bell" style="color: var(--danger); margin-right: 0.5rem;"></i>
                    Recent Announcements
                </h3>
            </div>
            <div class="card-body">
                <?php if (!empty($announcements)): ?>
                    <div style="max-height: 400px; overflow-y: auto;">
                        <?php foreach($announcements as $announce): ?>
                            <div style="padding: 1rem 0; border-bottom: 1px solid var(--gray-200);">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                    <span class="badge badge-primary">
                                        <i class="fas fa-calendar-alt"></i> <?= date('M d, Y', strtotime($announce['date'] ?? now())) ?>
                                    </span>
                                    <span class="badge badge-info">Admin</span>
                                </div>
                                <p style="margin: 0; color: var(--gray-800); font-weight: 500;">
                                    <?= htmlspecialchars(substr($announce['message'] ?? '', 0, 80)) ?>...
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div style="text-align: center; padding: 2rem; color: var(--gray-500);">
                        <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 1rem; display: block;"></i>
                        <p>No announcements yet</p>
                    </div>
                <?php endif; ?>
                <div style="margin-top: 1rem; text-align: center; border-top: 1px solid var(--gray-200); padding-top: 1rem;">
                    <a href="<?= base_url('admin/announcement') ?>" class="btn btn-sm btn-primary">
                        <i class="fas fa-arrow-right"></i> View All
                    </a>
                </div>
            </div>
        </div>

        <!-- To-Do List -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-tasks" style="color: var(--success); margin-right: 0.5rem;"></i>
                    To-Do List
                </h3>
            </div>
            <div class="card-body">
                <?php if (!empty($todos)): ?>
                    <div style="max-height: 400px; overflow-y: auto;">
                        <?php foreach($todos as $todo): ?>
                            <div style="padding: 0.85rem 0; border-bottom: 1px solid var(--gray-200); display: flex; justify-content: space-between; align-items: center;">
                                <span style="flex: 1; color: var(--gray-800);">
                                    <i class="fas fa-check-square"></i> <?= htmlspecialchars($todo['task_desc'] ?? '') ?>
                                </span>
                                <?php 
                                    $status = $todo['task_status'] ?? 'Pending';
                                    $statusClass = $status === 'Completed' ? 'badge-success' : 'badge-warning';
                                    $statusIcon = $status === 'Completed' ? 'fa-check-circle' : 'fa-clock';
                                ?>
                                <span class="badge <?= $statusClass ?>">
                                    <i class="fas <?= $statusIcon ?>"></i> <?= $status ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div style="text-align: center; padding: 2rem; color: var(--gray-500);">
                        <i class="fas fa-list-check" style="font-size: 2rem; margin-bottom: 1rem; display: block;"></i>
                        <p>No tasks in your to-do list</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    // Load Google Charts
    google.charts.load('current', {'packages':['bar', 'corechart']});
    google.charts.setOnLoadCallback(function() {
        drawServicesChart();
        drawFinancialChart();
        drawGenderChart();
        drawStaffChart();
    });

    // Services Chart
    function drawServicesChart() {
        var data = google.visualization.arrayToDataTable([
            ['Services', 'Total Numbers'],
            <?php
                if (is_array($result) && !empty($result)) {
                    foreach($result as $item) {
                        if (is_array($item)) {
                            $services = $item['services'] ?? '';
                            $number = $item['number'] ?? 0;
                            echo "['" . addslashes($services) . "', " . intval($number) . "],";
                        }
                    }
                } else {
                    echo "['No Data', 0],";
                }
            ?>
        ]);

        var options = {
            legend: { position: 'bottom' },
            bars: 'vertical',
            bar: { groupWidth: "75%" },
            colors: ['#6366f1'],
            hAxis: {
                title: 'Services'
            },
            vAxis: {
                title: 'Number of Members'
            }
        };

        var chart = new google.charts.Bar(document.getElementById('servicesChart'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
    }

    // Financial Chart
    function drawFinancialChart() {
        var data = google.visualization.arrayToDataTable([
            ['Category', 'Amount'],
            ['Earnings', <?= intval($earningsResult['numberone'] ?? 0) ?>],
            ['Expenses', <?= intval($expensesResult['numbert'] ?? 0) ?>]
        ]);

        var options = {
            legend: { position: 'bottom' },
            bars: 'horizontal',
            bar: { groupWidth: "75%" },
            colors: ['#10b981', '#ef4444'],
            hAxis: {
                title: 'Amount (₹)'
            }
        };

        var chart = new google.charts.Bar(document.getElementById('financialChart'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
    }

    // Gender Distribution Chart
    function drawGenderChart() {
        var data = google.visualization.arrayToDataTable([
            ['Gender', 'Count'],
            <?php
                if (is_array($result3) && !empty($result3)) {
                    foreach($result3 as $row) {
                        if (is_array($row)) {
                            echo "['" . addslashes($row['gender'] ?? '') . "', " . intval($row['enumber'] ?? 0) . "],";
                        }
                    }
                } else {
                    echo "['No Data', 0],";
                }
            ?>
        ]);

        var options = {
            pieHole: 0.4,
            colors: ['#3b82f6', '#ec4899', '#f59e0b'],
            legend: { position: 'bottom' }
        };

        var chart = new google.visualization.PieChart(document.getElementById('genderChart'));
        chart.draw(data, options);
    }

    // Staff Distribution Chart
    function drawStaffChart() {
        var data = google.visualization.arrayToDataTable([
            ['Designation', 'Count'],
            <?php
                if (is_array($result5) && !empty($result5)) {
                    foreach($result5 as $row) {
                        if (is_array($row)) {
                            echo "['" . addslashes($row['designation'] ?? '') . "', " . intval($row['snumber'] ?? 0) . "],";
                        }
                    }
                } else {
                    echo "['No Data', 0],";
                }
            ?>
        ]);

        var options = {
            pieHole: 0.4,
            colors: ['#8b5cf6', '#10b981', '#f97316', '#06b6d4'],
            legend: { position: 'bottom' }
        };

        var chart = new google.visualization.PieChart(document.getElementById('staffChart'));
        chart.draw(data, options);
    }

    // Responsive charts on window resize
    window.addEventListener('resize', function() {
        setTimeout(function() {
            drawServicesChart();
            drawFinancialChart();
            drawGenderChart();
            drawStaffChart();
        }, 250);
    });
</script>

<?= $this->endSection() ?>
