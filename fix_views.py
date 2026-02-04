#!/usr/bin/env python3
"""
Fix all admin view files to use CodeIgniter proper routing and CSS paths
"""
import os
import re
from pathlib import Path

admin_views_dir = r"c:\xampp\htdocs\your_gym_partner\app\Views\admin"

# List of files to fix
files_to_fix = [
    "members.php",
    "member-entry.php",
    "add-member-req.php",
    "edit-member.php",
    "edit-memberform.php",
    "edit-member-req.php",
    "remove-member.php",
    "member-status.php",
    "equipment.php",
    "equipment-entry.php",
    "add-equipment-req.php",
    "edit-equipment.php",
    "edit-equipmentform.php",
    "edit-equipment-req.php",
    "remove-equipment.php",
    "attendance.php",
    "view-attendance.php",
    "userpay.php",
    "search-result.php",
    "sendReminder.php",
    "announcement.php",
    "post-announcement.php",
    "manage-announcement.php",
    "staffs.php",
    "staffs-entry.php",
    "added-staffs.php",
    "edit-staff-form.php",
    "edit-staff-req.php",
    "remove-staff.php",
    "reports.php",
    "customer-progress.php",
    "progress-report.php",
    "update-progress.php",
    "view-progress-report.php",
    "members-report.php",
    "view-member-report.php",
    "services-report.php",
    "search-result-progress.php",
]

fixes = [
    # Remove session checks
    (r"if\(\!isset\(\$_SESSION\['user_id'\]\)\)\{\s*header\('location:[^']*'\);\s*\}", "// Session checked by controller"),
    
    # Fix CSS paths
    (r'href="\.\./css/', 'href="<?= base_url(\'css/'),
    (r'href=\'\.\.\/css/', "href='<?= base_url('css/"),
    
    # Fix JS paths
    (r'src="\.\./js/', 'src="<?= base_url(\'js/'),
    (r'src=\'\.\.\/js/', "src='<?= base_url('js/"),
    
    # Fix font-awesome paths
    (r'href="\.\./font-awesome/', 'href="<?= base_url(\'font-awesome/'),
    
    # Fix img paths
    (r'src="\.\./img/', 'src="<?= base_url(\'img/'),
    
    # Close the base_url calls
    (r'\.css"(?!>)', '.css\') ?>'),
    (r'\.js"(?!>)', '.js\') ?>'),
    (r'\.css\'(?!>)', ".css') ?>"),
    (r'\.js\'(?!>)', ".js') ?>"),
]

def fix_includes(content):
    """Fix include paths"""
    # include 'includes/...
    content = re.sub(r"include 'includes/", "include APPPATH . 'Views/admin/includes/", content)
    # include 'dbcon.php'
    content = re.sub(r"include 'dbcon\.php'", "// Removed dbcon.php (use CodeIgniter DB)\n    $db = \\Config\\Database::connect();", content)
    # Remove mysqli  
    content = re.sub(r"\$result = mysqli_query\(\$conn,\$qry\)", "$result = $db->query($qry)->getResultArray()", content)
    
    return content

def fix_links(content):
    """Fix hardcoded .php links"""
    # href="index.php"
    content = re.sub(r'href=["\']index\.php["\']', 'href="<?= base_url(\'admin\') ?>"', content)
    # href="payment.php"
    content = re.sub(r'href=["\']payment\.php["\']', 'href="<?= base_url(\'admin/payment\') ?>"', content)
    # href="userpay.php"
    content = re.sub(r'href=["\']userpay\.php["\']', 'href="<?= base_url(\'admin/userpay\') ?>"', content)
    # href="members.php"
    content = re.sub(r'href=["\']members\.php["\']', 'href="<?= base_url(\'admin/members\') ?>"', content)
    # href="logout.php"
    content = re.sub(r'href=[\'"]\.\./logout\.php["\']', 'href="<?= base_url(\'logout\') ?>"', content)
    # action="..."
    content = re.sub(r'action=["\']\.\.\/["\']', 'action="<?= base_url(\'admin\') ?>"', content)
    # location:...
    content = re.sub(r"location:['\"]\.\.\/index\.php", "redirect to admin home", content)
    
    return content

def process_file(filepath):
    """Process a single file"""
    try:
        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()
        
        original = content
        
        # Apply fixes
        content = fix_includes(content)
        content = fix_links(content)
        
        if content != original:
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(content)
            print(f"✓ Fixed: {Path(filepath).name}")
        else:
            print(f"- Skipped: {Path(filepath).name}")
            
    except Exception as e:
        print(f"✗ Error in {Path(filepath).name}: {str(e)}")

# Process all files
print("Starting to fix admin view files...\n")
for fname in files_to_fix:
    fpath = os.path.join(admin_views_dir, fname)
    if os.path.exists(fpath):
        process_file(fpath)
    else:
        print(f"- Missing: {fname}")

print("\nDone!")
