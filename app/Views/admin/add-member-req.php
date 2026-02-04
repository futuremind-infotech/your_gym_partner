<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header('location:../index.php');    
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add New Member - Perfect Gym Admin</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="../css/matrix-style.css" />
    <link href="../font-awesome/css/fontawesome.css" rel="stylesheet" />
    <link href="../font-awesome/css/all.css" rel="stylesheet" />
</head>
<body>

<!--Header-part-->
<div id="header">
    <h1><a href="index.php">Perfect Gym Admin</a></h1>
</div>

<!--top-Header-menu-->
<?php include 'includes/topheader.php';?>

<!--sidebar-menu-->
<?php $page='members-entry'; include 'includes/sidebar.php';?>

<!-- MAIN CONTENT -->
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> 
            <a href="index.php"><i class="fas fa-home"></i> Home</a> 
            <a href="members.php">Manage Members</a> 
            <a href="#">Add New Member</a> 
        </div>
        <h1>Member Entry Form</h1>
    </div>

    <div class="container-fluid">
        <?php 
        if(isset($_POST['fullname']) && !empty($_POST['fullname'])) {
            $fullname = trim($_POST["fullname"] ?? '');
            $username = trim($_POST["username"] ?? '');
            $password = trim($_POST["password"] ?? '');
            $dor = trim($_POST["dor"] ?? date('Y-m-d'));
            $gender = trim($_POST["gender"] ?? '');
            $services = trim($_POST["services"] ?? '');
            $amount = floatval($_POST["amount"] ?? 0);
            $p_year = date('Y');
            $paid_date = date("Y-m-d");
            $plan = intval($_POST["plan"] ?? 1);
            $address = trim($_POST["address"] ?? '');
            $contact = trim($_POST["contact"] ?? '');

            $password = md5($password);
            $totalamount = $amount * $plan;

            include 'dbcon.php';

            $stmt = $conn->prepare("INSERT INTO members(fullname,username,password,dor,gender,services,amount,p_year,paid_date,plan,address,contact) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("sssssdissiis", $fullname, $username, $password, $dor, $gender, $services, $totalamount, $p_year, $paid_date, $plan, $address, $contact);

            if($stmt->execute()) {
                $new_member_id = $conn->insert_id;
                echo "
                <div class='row-fluid'>
                    <div class='span12'>
                        <div class='widget-box'>
                            <div class='widget-title'>
                                <span class='icon'><i class='fas fa-check-circle'></i></span>
                                <h5>SUCCESS</h5>
                            </div>
                            <div class='widget-content padding'>
                                <h1>New member '$fullname' added successfully!</h1>
                                <p>Member ID: #$new_member_id</p>
                                <p>Total Amount: ₹$totalamount for $plan months</p>
                                <a href='members.php' class='btn btn-success'>View All Members</a>
                                <a href='add-member-req.php' class='btn btn-primary'>Add Another Member</a>
                            </div>
                        </div>
                    </div>
                </div>";
            } else {
                echo "
                <div class='row-fluid'>
                    <div class='span12'>
                        <div class='widget-box'>
                            <div class='widget-title'>
                                <span class='icon'><i class='fas fa-exclamation-triangle'></i></span>
                                <h5>ERROR</h5>
                            </div>
                            <div class='widget-content padding'>
                                <h1>Error occurred while adding member</h1>
                                <p>Error: " . $conn->error . "</p>
                                <a href='javascript:window.location.reload()' class='btn btn-warning'>Try Again</a>
                            </div>
                        </div>
                    </div>
                </div>";
            }
            $stmt->close();
        } else {
        ?>
        
        <form method="POST" action="add-member-req.php" class="form-horizontal">
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title">
                            <span class="icon"><i class="fas fa-user-plus"></i></span>
                            <h5>Add New Member</h5>
                        </div>
                        <div class="widget-content padding">
                            
                            <div class="control-group">
                                <label class="control-label">Full Name *</label>
                                <div class="controls">
                                    <input type="text" name="fullname" class="span8" placeholder="Enter full name" required>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Username *</label>
                                <div class="controls">
                                    <input type="text" name="username" class="span8" placeholder="Enter username" required>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Password *</label>
                                <div class="controls">
                                    <input type="password" name="password" class="span8" placeholder="Enter password" required>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Date of Registration</label>
                                <div class="controls">
                                    <input type="date" name="dor" class="span8" value="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Gender *</label>
                                <div class="controls">
                                    <select name="gender" class="span8" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Services *</label>
                                <div class="controls">
                                    <select name="services" class="span8" required>
                                        <option value="">Select Service</option>
                                        <option value="Gym">Gym</option>
                                        <option value="Yoga">Yoga</option>
                                        <option value="Zumba">Zumba</option>
                                        <option value="Personal Training">Personal Training</option>
                                    </select>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Amount per Month (₹) *</label>
                                <div class="controls">
                                    <input type="number" name="amount" class="span8" min="0" step="0.01" placeholder="1000" value="1000" required>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Plan Duration *</label>
                                <div class="controls">
                                    <select name="plan" class="span8" required>
                                        <option value="1">1 Month</option>
                                        <option value="3">3 Months</option>
                                        <option value="6">6 Months</option>
                                        <option value="12">12 Months</option>
                                    </select>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Address</label>
                                <div class="controls">
                                    <textarea name="address" class="span8" rows="3" placeholder="Enter full address"></textarea>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Contact Number</label>
                                <div class="controls">
                                    <input type="tel" name="contact" class="span8" placeholder="Enter phone number">
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-success">Add Member</button>
                                <a href="members.php" class="btn btn-inverse">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php } ?>
    </div>
</div>

<!--Footer-part-->
<div class="row-fluid">
    <div id="footer" class="span12"> 
        <?php echo date("Y");?> &copy; Perfect Gym Admin
    </div>
</div>

<!-- Scripts -->
<script src="../js/jquery.min.js"></script> 
<script src="../js/bootstrap.min.js"></script> 
<script src="../js/matrix.js"></script>

</body>
</html>
