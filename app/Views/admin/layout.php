<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> - Perfect Gym Admin</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link href="<?= base_url('font-awesome/css/all.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('font-awesome/css/fontawesome.css') ?>" rel="stylesheet" />
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="<?= base_url('css/admin-modern.css') ?>" />
    
    <?= $this->renderSection('styles') ?>
</head>
<body>

<div class="app-wrapper">
    <!-- Sidebar -->
    <aside class="app-sidebar" id="sidebar">
        <div class="sidebar-header">
            <h1>
                <i class="fas fa-dumbbell"></i>
                <span>Perfect Gym</span>
            </h1>
        </div>
        
        <nav class="sidebar-nav">
            <?php 
            $page = $page ?? ''; 
            $user = session()->get('user_name') ?? 'Admin';
            ?>
            <ul>
                <!-- Dashboard -->
                <li class="<?= $page=='dashboard'?'active':'' ?>">
                    <a href="<?= base_url('admin') ?>">
                        <i class="fas fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <!-- Members -->
                <li class="submenu <?= in_array($page, ['members', 'members-entry', 'members-remove', 'members-update'])?'active':'' ?>">
                    <span class="submenu-toggle">
                        <i class="fas fa-users"></i>
                        <span>Members</span>
                    </span>
                    <ul>
                        <li class="<?= $page=='members'?'active':'' ?>">
                            <a href="<?= base_url('admin/members') ?>">
                                <i class="fas fa-list"></i> All Members
                            </a>
                        </li>
                        <li class="<?= $page=='members-entry'?'active':'' ?>">
                            <a href="<?= base_url('admin/member-entry') ?>">
                                <i class="fas fa-user-plus"></i> Add Member
                            </a>
                        </li>
                        <li class="<?= $page=='members-update'?'active':'' ?>">
                            <a href="<?= base_url('admin/edit-member') ?>">
                                <i class="fas fa-edit"></i> Edit Member
                            </a>
                        </li>
                        <li class="<?= $page=='members-remove'?'active':'' ?>">
                            <a href="<?= base_url('admin/remove-member') ?>">
                                <i class="fas fa-trash"></i> Remove Member
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Equipment -->
                <li class="submenu <?= in_array($page, ['list-equip', 'add-equip', 'remove-equip', 'update-equip'])?'active':'' ?>">
                    <span class="submenu-toggle">
                        <i class="fas fa-dumbbell"></i>
                        <span>Equipment</span>
                    </span>
                    <ul>
                        <li class="<?= $page=='list-equip'?'active':'' ?>">
                            <a href="<?= base_url('admin/equipment') ?>">
                                <i class="fas fa-list"></i> All Equipment
                            </a>
                        </li>
                        <li class="<?= $page=='add-equip'?'active':'' ?>">
                            <a href="<?= base_url('admin/equipment-entry') ?>">
                                <i class="fas fa-plus"></i> Add Equipment
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Attendance -->
                <li class="submenu <?= in_array($page, ['attendance', 'view-attendance'])?'active':'' ?>">
                    <span class="submenu-toggle">
                        <i class="fas fa-calendar-check"></i>
                        <span>Attendance</span>
                    </span>
                    <ul>
                        <li class="<?= $page=='attendance'?'active':'' ?>">
                            <a href="<?= base_url('admin/attendance') ?>">
                                <i class="fas fa-arrow-right-arrow-left"></i> Check In/Out
                            </a>
                        </li>
                        <li class="<?= $page=='view-attendance'?'active':'' ?>">
                            <a href="<?= base_url('admin/view-attendance') ?>">
                                <i class="fas fa-history"></i> History
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Payments -->
                <li class="<?= $page=='payment'?'active':'' ?>">
                    <a href="<?= base_url('admin/payment') ?>">
                        <i class="fas fa-credit-card"></i>
                        <span>Payments</span>
                    </a>
                </li>

                <!-- Announcements -->
                <li class="<?= $page=='announcement'?'active':'' ?>">
                    <a href="<?= base_url('admin/announcement') ?>">
                        <i class="fas fa-megaphone"></i>
                        <span>Announcements</span>
                    </a>
                </li>

                <!-- Staff -->
                <li class="<?= $page=='staff-management'?'active':'' ?>">
                    <a href="<?= base_url('admin/staffs') ?>">
                        <i class="fas fa-users-cog"></i>
                        <span>Staff</span>
                    </a>
                </li>
                
                <!-- Reports -->
                <li class="submenu <?= in_array($page, ['chart', 'member-repo', 'c-p-r'])?'active':'' ?>">
                    <span class="submenu-toggle">
                        <i class="fas fa-chart-bar"></i>
                        <span>Reports</span>
                    </span>
                    <ul>
                        <li class="<?= $page=='chart'?'active':'' ?>">
                            <a href="<?= base_url('admin/reports') ?>">
                                <i class="fas fa-chart-pie"></i> Analytics
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>

        <div class="sidebar-footer">
            <a href="<?= base_url('logout') ?>" title="Logout">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="app-content">
        <!-- Header -->
        <header class="app-header">
            <div class="d-flex align-items-center gap-2">
                <button class="sidebar-toggle" id="sidebarToggle" style="background:none; border:none; font-size:1.5rem; cursor:pointer; color:var(--gray-700);">
                    <i class="fas fa-bars"></i>
                </button>
                <h2 class="header-title"><?= $this->renderSection('header_title') ?: 'Admin Panel' ?></h2>
            </div>
            
            <div class="header-actions">
                <input type="text" class="search-box" placeholder="Search anything..." id="headerSearch">
                
                <div class="notification-bell" title="Notifications">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">3</span>
                </div>
                
                <div class="user-menu">
                    <div class="user-avatar" title="User Profile"><?= strtoupper(substr($user, 0, 1)) ?></div>
                    <div style="display:flex; flex-direction:column;">
                        <span style="font-weight:600; font-size:0.9rem;"><?= htmlspecialchars($user) ?></span>
                        <span style="font-size:0.8rem; color:var(--gray-600);">Administrator</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="app-main">
            <?= $this->renderSection('content') ?>
        </main>
    </div>
</div>

<!-- Scripts -->
<script src="<?= base_url('js/jquery.min.js') ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sidebar Toggle (Mobile)
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
    }

    // Submenu Toggle
    const submenuToggles = document.querySelectorAll('.submenu-toggle');
    submenuToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const submenu = this.closest('.submenu');
            submenu.classList.toggle('active');
        });
    });

    // Close sidebar on mobile when clicking a link
    if (window.innerWidth <= 768) {
        const sidebarLinks = document.querySelectorAll('.sidebar-nav a');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', function() {
                sidebar.classList.remove('active');
            });
        });
    }

    // Flash message auto-dismiss
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        const closeBtn = alert.querySelector('.alert-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                alert.remove();
            });
        }
        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            if (alert.parentElement) {
                alert.remove();
            }
        }, 5000);
    });
});
</script>
<?= $this->renderSection('scripts') ?>

</body>
</html>
