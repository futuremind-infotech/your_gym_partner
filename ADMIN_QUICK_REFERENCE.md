# ADMIN QUICK START GUIDE

## 🔑 Login Credentials
- **URL**: `http://localhost/your_gym_partner/`
- **Username**: `admin`
- **Password**: `admin`

---

## 📱 Main Navigation Menu

After login, access these sections from the left sidebar:

### 1. **Members**
   - **List Members** → View all members with contact info
   - **Add Members** → Register new member with subscription plan
   - **Member Status** → Manage member status (Active/Expired)
   - **Skills**: Add, View, Edit, Delete members

### 2. **Equipment** (NEW)
   - **Add Equipment** → Register new gym equipment
   - **Equipment List** → View all equipment inventory
   - **Skills**: Add, View, Edit, Delete equipment

### 3. **Staff** (NEW)
   - **Add Staff** → Hire new staff member
   - **Staff List** → View all staff details
   - **Skills**: Add, View, Edit, Delete staff

### 4. **Attendance**
   - **Manual Attendance** → Mark members present/absent
   - **QR Scanner** → Scan QR codes for quick check-in
   - **Generate QR** → Create QR code for a member
   - **View Attendance** → Check attendance history

### 5. **Payment**
   - **Record Payment** → Process member payments
   - **Payment History** → View all payments
   - **Payment Reminders** → Send reminder to unpaid members

### 6. **Reports**
   - **Customer Progress** → Track member fitness progress
   - **Member Report** → Generate member reports
   - **Services Report** → Analyze service usage

### 7. **Announcements**
   - **Post Announcement** → Share gym announcements
   - **Manage Announcements** → Edit/Delete announcements

---

## ✅ QUICK TASKS

### Add a New Member (30 seconds)
1. Click **Members** → **Add Members**
2. Fill in details: Name, Username, Password, Services, Plan
3. Click **Submit**
4. Done! Member added and can login

### Add New Equipment (20 seconds)
1. Click **Equipment** → **Add Equipment**
2. Fill in: Name, Quantity, Unit Price, Vendor
3. Click **Submit**
4. Equipment added to inventory

### Hire New Staff (20 seconds)
1. Click **Staff** → **Add Staff**
2. Fill in: Name, Username, Email, Designation
3. Click **Submit**
4. Staff account created

### Mark Attendance (10 seconds)
1. Click **Attendance** → **Mark Attendance**
2. Select member name
3. Click **Mark Present**
4. Done! Attendance recorded

### Record Payment (15 seconds)
1. Click **Payment** → **Record Payment**
2. Select member
3. Confirm amount and plan
4. Click **Submit**
5. Payment recorded

---

## 🔄 Common Operations

### Edit Member Information
```
Members → Member List → Click "Edit" button → Change details → Update
```

### Delete Member Account
```
Members → Member List → Click "Delete" button → Confirm → Member removed
```

### Update Equipment Details
```
Equipment → Equipment List → Click "Edit" → Change details → Update
```

### Delete Equipment Record
```
Equipment → Equipment List → Click "Delete" → Confirm → Record removed
```

### Edit Staff Information
```
Staff → Staff List → Click "Edit" → Change details → Update
```

### Remove Staff Member
```
Staff → Staff List → Click "Delete" → Confirm → Staff removed
```

---

## 📊 Reports & Analytics

1. **Member Count** - Total active members
2. **Equipment Inventory** - Total equipment & quantity
3. **Staff Directory** - All staff members
4. **Attendance Tracking** - Daily check-ins
5. **Payment Status** - Paid/Unpaid members
6. **Revenue Reports** - Income tracking

---

## ⚙️ Settings & Maintenance

### Database Backup:
- Use phpMyAdmin at `http://localhost/phpmyadmin/`
- Export `gymnsb` database regularly

### Password Change:
- Edit your admin password in `admin` table in database
- Use MD5 hash for new password

### Maintenance Mode:
- Add announcement "System Maintenance" to notify members

---

## 🚨 Important Notes

1. **All operations are admin-only** - Non-admins cannot access
2. **Session expires** - Re-login if inactive for 30+ minutes
3. **Data is permanent** - Deleted records cannot be recovered
4. **Backups** - Regularly backup database using phpMyAdmin
5. **Username must be unique** - Cannot have duplicate usernames
6. **Passwords are hashed** - Cannot retrieve original passwords

---

## 💡 Tips & Best Practices

✅ **Do This:**
- Backup database monthly
- Check attendance daily
- Send payment reminders on due dates
- Keep staff information updated
- Post regular announcements
- Monitor equipment condition

❌ **Don't Do This:**
- Share admin password
- Delete important records without backup
- Leave system logged in unattended
- Ignore payment due dates
- Use weak passwords
- Store sensitive data in notes

---

## 🆘 Troubleshooting

### "Login failed"
- Check CAPS LOCK
- Verify username/password
- Clear browser cookies

### "Can't add member"
- Check username is unique
- Fill all required fields
- Verify phone format (10 digits)

### "Edit button not working"
- Refresh page
- Check member still exists
- Re-login to admin panel

### "Data not showing"
- Refresh page (F5)
- Check database connection
- Verify user exists in database

### "Payment not recorded"
- Verify member exists
- Check amount is valid
- Ensure plan is selected

---

## 📞 System Status

- **Database**: `gymnsb` (MySQL)
- **Base URL**: `http://localhost/your_gym_partner/`
- **Admin Panel**: `/admin/`
- **Member Portal**: `/customer/`
- **Staff Panel**: `/staff/`

---

## 🎯 Daily Admin Checklist

- [ ] Check new member registrations
- [ ] Review daily attendance
- [ ] Process pending payments
- [ ] Update equipment status
- [ ] Send payment reminders
- [ ] Post announcements if needed
- [ ] Backup database (weekly)
- [ ] Monitor system performance

---

**Last Updated**: February 4, 2026  
**System**: Your Gym Partner v1.0  
**Status**: ✅ Fully Operational
