# GYM PARTNER - PAYMENT SYSTEM FLOW DIAGRAM

## Complete Payment Processing Flow

```
┌─────────────────────────────────────────────────────────────────────┐
│                    ADMIN DASHBOARD                                   │
│                   (admin/index view)                                 │
└────────────────┬──────────────────────────────────────────────────┘
                 │ Click "Payments" in Sidebar
                 ▼
┌─────────────────────────────────────────────────────────────────────┐
│ PAYMENT LIST VIEW                                                    │
│ Route: GET /admin/payment                                           │
│ Controller: Admin::payment()                                         │
│ View: app/Views/admin/payment.php                                   │
├─────────────────────────────────────────────────────────────────────┤
│ ✓ Displays all members                                              │
│ ✓ Shows last payment date                                           │
│ ✓ Shows current amount and plan                                     │
│ ✓ Search functionality                                              │
│ ✓ Action buttons: "Make Payment" and "Send Alert"                   │
└────────────────┬──────────────────────────────────────────────────┘
                 │ Click "Make Payment" button next to member
                 │ Button link: base_url('admin/user-payment?id=5')
                 ▼
┌─────────────────────────────────────────────────────────────────────┐
│ PAYMENT FORM VIEW                                                    │
│ Route: GET /admin/user-payment?id=X                                 │
│ Controller: Admin::userPayment()                                     │
│ View: app/Views/admin/user-payment.php                              │
├─────────────────────────────────────────────────────────────────────┤
│ Form displays:                                                       │
│  - Member Name (read-only): <?php echo $member['fullname']; ?>     │
│  - Service (read-only): <?php echo $member['services']; ?>         │
│  - Amount/Month (input): <input type="number" name="amount">        │
│  - Plan (dropdown): 1/3/6/12 months or None-Expired                │
│  - Status (dropdown): Active / Expired                              │
│                                                                      │
│ Hidden fields:                                                       │
│  - id (member_id)                                                    │
│  - fullname                                                          │
│  - services                                                          │
│  - paid_date                                                         │
│                                                                      │
│ Form Action: POST /admin/userpay                                    │
│ Form Method: POST                                                    │
└────────────────┬──────────────────────────────────────────────────┘
                 │ Admin fills in details and clicks "Make Payment"
                 │ Form Data:
                 │  - amount: 55
                 │  - plan: 3
                 │  - status: Active
                 │  - id: 5
                 │  - fullname: John Doe
                 │  - services: Fitness
                 ▼
┌─────────────────────────────────────────────────────────────────────┐
│ PAYMENT PROCESSING (CONTROLLER)                                      │
│ Route: POST /admin/userpay                                          │
│ Controller: Admin::userpay()                                         │
├─────────────────────────────────────────────────────────────────────┤
│ Step 1: Extract POST Data                                            │
│  $fullname = $_POST['fullname'];        // John Doe                 │
│  $services = $_POST['services'];        // Fitness                  │
│  $amount = $_POST['amount'];            // 55                       │
│  $plan = $_POST['plan'];                // 3                        │
│  $status = $_POST['status'];            // Active                   │
│  $id = $_POST['id'];                    // 5                        │
│                                                                      │
│ Step 2: Calculate Total                                              │
│  $amountpayable = 55 * 3 = 165 ₹                                    │
│                                                                      │
│ Step 3: Update Database                                              │
│  UPDATE members SET                                                  │
│    amount = 165,                                                     │
│    plan = 3,                                                         │
│    status = 'Active',                                                │
│    paid_date = '2026-02-04',                                         │
│    reminder = 0                                                      │
│  WHERE user_id = 5;                                                  │
│                                                                      │
│ Step 4: Pass data to view                                            │
│  return view('admin/userpay', [                                      │
│    'success' => true,                                                │
│    'fullname' => 'John Doe',                                         │
│    'services' => 'Fitness',                                          │
│    'amount' => 55,                                                   │
│    'plan' => 3,                                                      │
│    'amountpayable' => 165,                                           │
│    'status' => 'Active',                                             │
│    'paid_date' => '2026-02-04'                                       │
│  ]);                                                                  │
└────────────────┬──────────────────────────────────────────────────┘
                 │ Display view based on success/status
                 ▼
┌─────────────────────────────────────────────────────────────────────┐
│ PAYMENT RECEIPT VIEW                                                 │
│ Route: POST /admin/userpay (response)                               │
│ View: app/Views/admin/userpay.php                                   │
├─────────────────────────────────────────────────────────────────────┤
│                                                                      │
│ IF status == 'Active':                                               │
│  ✓ Display Success Receipt                                          │
│    - Invoice number (random)                                        │
│    - Member Name: John Doe                                          │
│    - Payment Date                                                    │
│    - Service: Fitness                                               │
│    - Valid Duration: 3 Months                                       │
│    - Charge/Month: ₹55                                              │
│    - Total Amount: ₹165                                             │
│    - [Print] [Back to Payments]                                     │
│                                                                      │
│ ELSE IF status == 'Expired':                                         │
│  ⚠ Display Warning Message                                          │
│    - "Account Status: EXPIRED"                                      │
│    - Account marked as expired until next payment                   │
│    - [Go Back]                                                      │
│                                                                      │
│ ELSE:                                                                │
│  ✗ Display Error Message                                            │
│    - "Something went wrong!"                                        │
│    - Payment could not be processed                                 │
│    - [Try Again]                                                    │
│                                                                      │
└────────────────┬──────────────────────────────────────────────────┘
                 │ Admin can print receipt or go back
                 │
                 ├─→ [Print Button]
                 │   └─→ window.print() (CSS @media print)
                 │
                 └─→ [Back to Payments]
                     └─→ base_url('admin/payment')
                         └─→ PAYMENT LIST VIEW (updated)
```

---

## Database Updates Flow

```
BEFORE Payment:
┌────────────────────────────────────────┐
│ members table (user_id = 5)            │
├────────────────────────────────────────┤
│ user_id: 5                             │
│ fullname: John Doe                     │
│ amount: 55 (old)                       │
│ plan: 1 (old)                          │
│ status: Active                         │
│ paid_date: 2025-12-01                  │
│ reminder: 0                            │
└────────────────────────────────────────┘
            │
            │ Payment Form Submitted
            │ Amount: 55, Plan: 3, Status: Active
            ▼
AFTER Payment:
┌────────────────────────────────────────┐
│ members table (user_id = 5)            │
├────────────────────────────────────────┤
│ user_id: 5                             │
│ fullname: John Doe                     │
│ amount: 165 ✓ (UPDATED: 55 * 3)       │
│ plan: 3 ✓ (UPDATED)                    │
│ status: Active                         │
│ paid_date: 2026-02-04 ✓ (UPDATED)     │
│ reminder: 0 ✓ (RESET)                 │
└────────────────────────────────────────┘
```

---

## File & Route Mapping

```
REQUEST FLOW:
─────────────

1. admin/payment
   └─ Config/Routes.php: $routes->get('admin/payment', 'Admin::payment');
      └─ Controllers/Admin.php: payment() { return view('admin/payment'); }
         └─ Views/admin/payment.php
            ├─ Displays member list from database
            │  Link: base_url('admin/user-payment?id=5')
            │
            └─ Form Search:
               action="<?= base_url('admin/search-result') ?>"

2. admin/user-payment?id=X
   └─ Config/Routes.php: $routes->get('admin/user-payment', 'Admin::userPayment');
      └─ Controllers/Admin.php: userPayment() { return view('admin/user-payment'); }
         └─ Views/admin/user-payment.php
            ├─ Loads member data via PHP: $member_id = $_GET['id'];
            │  $db->query("SELECT * FROM members WHERE user_id = ?");
            │
            └─ Payment Form:
               action="<?= base_url('admin/userpay') ?>"
               method="POST"

3. admin/userpay [POST]
   └─ Config/Routes.php: $routes->post('admin/userpay', 'Admin::userpay');
      └─ Controllers/Admin.php: userpay() { 
            if ($this->request->getMethod() === 'post') {
              // Process payment
              // Update database
              // return view('admin/userpay', $data);
            }
         }
         └─ Views/admin/userpay.php
            ├─ Display Receipt (if success && status='Active')
            ├─ Display Warning (if success && status='Expired')
            └─ Display Error (if !success)
```

---

## Sidebar Navigation Routes

```
SIDEBAR MENU (Views/admin/includes/sidebar.php)
───────────────────────────────────────────

Dashboard
  └─ base_url('admin')

Manage Members
  ├─ List All Members → base_url('admin/members')
  ├─ Member Entry Form → base_url('admin/member-entry')
  ├─ Remove Member → base_url('admin/remove-member')
  └─ Update Member → base_url('admin/edit-member')

Gym Equipment
  ├─ List Equipment → base_url('admin/equipment')
  ├─ Add Equipment → base_url('admin/equipment-entry')
  ├─ Remove Equipment → base_url('admin/remove-equipment')
  └─ Update Equipment → base_url('admin/edit-equipment')

Attendance
  ├─ Check In/Out → base_url('admin/attendance')
  └─ View → base_url('admin/view-attendance')

Manage Customer Progress → base_url('admin/customer-progress')
Member's Status → base_url('admin/member-status')
Payments → base_url('admin/payment') ✓ FIXED
Announcement → base_url('admin/announcement')
Staff Management → base_url('admin/staffs')

Reports
  ├─ Charts → base_url('admin/reports')
  ├─ Members Report → base_url('admin/members-report')
  └─ Progress Report → base_url('admin/progress-report')
```

---

## Security Flow

```
REQUEST RECEIVED
       │
       ▼
CodeIgniter Router
       │
       ▼
CSRF Protection Check (Automatic in CI4)
       │
       ▼
Admin Controller::userpay()
       │
       ├─ Check Session (middleware)
       ├─ Validate POST Data
       ├─ Prepare Statement: $db->query(..., $data)
       │  (SQL Injection Prevention)
       │
       ▼
Database Update
       │
       ▼
Pass Data to View
       │
       ▼
Escape Output in View: htmlspecialchars($fullname)
       │  (XSS Prevention)
       ▼
Return HTML Response
```

---

This is the complete working flow of your payment system!
