# Complete Member CRUD Flow Diagram

## Add Member Flow

```
┌─────────────────────────────────────────────────────────────────┐
│ USER: Navigates to /admin/member-entry or /staff/member-entry  │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         ▼
          ┌──────────────────────────────┐
          │  Display Member Entry Form   │
          │ - CSRF token included ✅     │
          │ - Clear form                 │
          └────────────┬─────────────────┘
                       │
                       ▼
         ┌───────────────────────────────┐
         │ USER: Fills form & clicks     │
         │       "Submit"                │
         │                               │
         │ Form Data:                    │
         │ - fullname                    │
         │ - username                    │
         │ - password                    │
         │ - gender                      │
         │ - services                    │
         │ - amount                      │
         │ - plan                        │
         │ - address                     │
         │ - contact                     │
         │ - csrf_token ✅               │
         └────────┬──────────────────────┘
                  │ POST /admin/add-member
                  │ or /staff/add-member
                  ▼
┌─────────────────────────────────────────────────┐
│ Admin::addMember() / Staff::addMember()          │
│                                                 │
│ 1. Validate CSRF Token ✅                       │
│    └─ If invalid → 403 Error                    │
│                                                 │
│ 2. Check Session (isLoggedIn) ✅                │
│    └─ If not logged in → Redirect to /          │
│                                                 │
│ 3. Validate Form Data ✅                        │
│    ├─ fullname: required|min_length[2]         │
│    ├─ username: required|min_length[3]|unique  │
│    ├─ password: required|min_length[6]         │
│    ├─ gender: required                         │
│    ├─ services: required                       │
│    ├─ amount: required|numeric|>0              │
│    └─ plan: required|integer|>0                │
└─────────────┬───────────────────────────────────┘
              │
              ▼
    ┌─────────────────────────┐
    │ Validation Passed?      │
    └────────┬────────────────┘
             │
        YES  │  NO
            │   │
            │   ▼
            │  ┌──────────────────────────────────┐
            │  │ Return Form with Errors          │
            │  │                                  │
            │  │ Display:                         │
            │  │ - fullname: Field is required    │
            │  │ - username: Already in use       │
            │  │ - etc.                           │
            │  │                                  │
            │  │ User can fix & resubmit ↻        │
            │  └──────────────────────────────────┘
            │
            ▼
┌─────────────────────────────────────────────────┐
│ Prepare Data for Insertion                      │
│                                                 │
│ $data = [                                       │
│   'fullname'        => 'John Doe',              │
│   'username'        => 'johndoe',               │
│   'password'        => md5('pass123'),          │
│   'dor'             => '2024-01-15',            │
│   'gender'          => 'Male',                  │
│   'services'        => 'Fitness',               │
│   'amount'          => 5000,  // amount*plan   │
│   'p_year'          => '2024',                  │
│   'paid_date'       => '2024-01-15',            │
│   'plan'            => '1',                     │
│   'address'         => '123 Main St',           │
│   'contact'         => '9811234567',            │
│   'attendance_count'=> 0,                       │
│   'last_attendance' => NULL                     │
│ ]                                               │
└──────────────────┬───────────────────────────────┘
                   │
                   ▼
        ┌──────────────────────────┐
        │ INSERT into members      │
        │ using QueryBuilder ✅     │
        │                          │
        │ $db->table('members')   │
        │   ->insert($data);       │
        └────────┬─────────────────┘
                 │
                 ▼
        ┌──────────────────────────┐
        │ Try-Catch Block ✅        │
        └────────┬─────────────────┘
                 │
        ┌────────┴─────────┐
        │                  │
       ✅                  ❌
    SUCCESS            EXCEPTION
        │                  │
        ▼                  ▼
   ┌─────────────┐  ┌──────────────────────────┐
   │ Set Success │  │ Set Error Flashdata      │
   │ Flashdata   │  │                          │
   │             │  │ "❌ Error adding member" │
   │ "✅ New     │  │                          │
   │ member      │  │ Return to form with      │
   │ added!"     │  │ validation object        │
   └────┬────────┘  └──────────────────────────┘
        │                  │
        ▼                  ▼
   ┌─────────────────────────────────────────┐
   │ Redirect to Members List                │
   │ /admin/members or /staff/members        │
   │                                         │
   │ Success message displayed to user ✅    │
   │ New member visible in list ✅           │
   │ Data in database ✅                     │
   └─────────────────────────────────────────┘
```

---

## Edit Member Flow

```
┌──────────────────────────────────────────────────┐
│ USER: Navigates to /staff/members                │
│ Clicks "Edit" next to a member                   │
└────────────────────┬─────────────────────────────┘
                     │ GET ?id=5
                     ▼
        ┌────────────────────────────────┐
        │ Staff::editMember()            │
        │                                │
        │ 1. Check session ✅             │
        │ 2. Get member_id from URL      │
        │ 3. Query database for member   │
        │    $db->table('members')       │
        │      ->where('user_id', $id)   │
        │      ->get()->getRowArray()    │
        │ 4. Load edit form with data    │
        └────────┬─────────────────────────┘
                 │
                 ▼
        ┌──────────────────────────────┐
        │ Display Edit Form            │
        │ - Form pre-filled ✅         │
        │ - CSRF token ✅              │
        │ - Hidden user_id field ✅    │
        │                              │
        │ Fields populated from DB:    │
        │ - fullname: "John Doe"       │
        │ - username: "johndoe"        │
        │ - gender: "Male"             │
        │ - contact: "9811234567"      │
        │ - address: "123 Main St"     │
        │ - amount: "5000"             │
        │ - plan: "1"                  │
        │ - services: "Fitness"        │
        └────────┬──────────────────────┘
                 │
                 ▼
        ┌──────────────────────────┐
        │ USER: Modifies form &    │
        │       clicks "Update"    │
        │                          │
        │ Changes made:            │
        │ - contact: "9819876543"  │
        │ - address: "456 Oak St"  │
        │ - csrf_token ✅          │
        │ - user_id (hidden) ✅    │
        └────────┬─────────────────┘
                 │ POST /staff/edit-member-req
                 ▼
    ┌──────────────────────────────────────┐
    │ Staff::editMemberReq()               │
    │                                      │
    │ 1. Validate CSRF ✅                  │
    │ 2. Check session ✅                  │
    │ 3. Get user_id from POST ✅          │
    │ 4. Validate form data ✅             │
    │ 5. Prepare update data               │
    │ 6. UPDATE database                   │
    │                                      │
    │ $db->table('members')               │
    │   ->where('user_id', $user_id)      │
    │   ->update($data)                    │
    │                                      │
    │ 7. Check affected rows               │
    │ 8. Set flashdata                     │
    │ 9. Redirect to members list          │
    └───────────────────────────────────────┘
             │
             ▼
    ┌──────────────────────────┐
    │ Success Message:         │
    │ "✅ Member updated!"     │
    │                          │
    │ Member details changed   │
    │ in database ✅           │
    │                          │
    │ Redirected to            │
    │ /staff/members ✅        │
    └──────────────────────────┘
```

---

## Delete Member Flow

```
┌──────────────────────────────────────────────────┐
│ USER: At /staff/members                          │
│ Clicks "Delete" next to a member                 │
└────────────────────┬─────────────────────────────┘
                     │
                     ▼
        ┌──────────────────────────────┐
        │ Show Confirm Dialog          │
        │ "Delete member?"             │
        │ [Cancel] [Confirm]           │
        └────────┬─────────────────────┘
                 │ User clicks "Confirm"
                 ▼
    ┌──────────────────────────────────┐
    │ POST /staff/delete-member        │
    │ with user_id in form data        │
    │ + csrf_token ✅                  │
    └────────┬─────────────────────────┘
             │
             ▼
    ┌──────────────────────────────┐
    │ Staff::deleteMember()        │
    │                              │
    │ 1. Validate CSRF ✅          │
    │ 2. Check session ✅          │
    │ 3. Get user_id ✅            │
    │ 4. DELETE from database:     │
    │                              │
    │ $db->table('members')       │
    │   ->where('user_id', $id)   │
    │   ->delete()                 │
    │                              │
    │ 5. Set success flashdata     │
    │ 6. Redirect to members list  │
    └────────┬──────────────────────┘
             │
             ▼
    ┌──────────────────────────────┐
    │ Success Message:             │
    │ "✅ Member deleted!"         │
    │                              │
    │ Member removed from DB ✅    │
    │ Member removed from list ✅  │
    └──────────────────────────────┘
```

---

## Error Handling Flow

```
    ┌─────────────────────────────────┐
    │ Form Submitted with Errors      │
    │ - Validation fails              │
    │ - Database exception            │
    │ - Duplicate username            │
    └────────────┬──────────────────────┘
                 │
                 ▼
    ┌──────────────────────────────────────┐
    │ Controller Catches Error             │
    │                                      │
    │ if (! $this->validate($rules)) {    │
    │   return view(..., [                │
    │     'validation' => $this->validator│
    │   ]);                               │
    │ }                                    │
    │                                      │
    │ OR                                   │
    │                                      │
    │ try {                                │
    │   $db->table(...)->insert(...);     │
    │ } catch (\Exception $e) {            │
    │   session()->setFlashdata('error',  │
    │     '❌ Error: ' . $e->getMessage() │
    │   );                                │
    │   return view(...);                 │
    │ }                                    │
    └────────────┬──────────────────────────┘
                 │
                 ▼
    ┌──────────────────────────────┐
    │ View Displays Errors to User │
    │                              │
    │ <?php if ($validation): ?>   │
    │   <div class="alert">        │
    │     fullname: Required       │
    │     username: Already used   │
    │   </div>                     │
    │ <?php endif; ?>              │
    └────────────┬──────────────────┘
                 │
                 ▼
    ┌──────────────────────────────┐
    │ Form Stays on Same Page      │
    │ - User sees errors           │
    │ - Form data retained         │
    │ - Can fix & resubmit         │
    └──────────────────────────────┘
```

---

## Security Checks Flow

```
    ┌─────────────────────────────────┐
    │ User Submits Form (POST)        │
    └────────────┬──────────────────────┘
                 │
                 ▼
    ┌──────────────────────────────┐
    │ 1. CSRF Token Validation ✅   │
    │                              │
    │ Form includes:               │
    │ <input name="csrf_token_name"│
    │        value="abc123xyz">    │
    │                              │
    │ CodeIgniter verifies token   │
    │ └─ If invalid → 403 Error    │
    └────────┬──────────────────────┘
             │ ✓ Token valid
             ▼
    ┌──────────────────────────────┐
    │ 2. Session Check ✅           │
    │                              │
    │ if (! session()->get(        │
    │   'isLoggedIn')) {           │
    │   return redirect()->to('/');│
    │ }                            │
    │                              │
    │ └─ If not logged in →        │
    │    Redirect to login         │
    └────────┬──────────────────────┘
             │ ✓ User logged in
             ▼
    ┌──────────────────────────────┐
    │ 3. Input Validation ✅        │
    │                              │
    │ Check:                       │
    │ - Required fields present    │
    │ - Data types correct         │
    │ - Min/max lengths            │
    │ - Unique constraints         │
    │                              │
    │ └─ If invalid → Show errors  │
    └────────┬──────────────────────┘
             │ ✓ All valid
             ▼
    ┌──────────────────────────────┐
    │ 4. SQL Injection Prevention   │
    │                              │
    │ Use QueryBuilder:            │
    │ $db->table('members')       │
    │   ->where('user_id', $id)   │
    │   ->update($data)            │
    │                              │
    │ (No string concatenation)    │
    └────────┬──────────────────────┘
             │ ✓ Safe query
             ▼
    ┌──────────────────────────────┐
    │ 5. Exception Handling ✅      │
    │                              │
    │ try {                        │
    │   // Database operation      │
    │ } catch (\Exception $e) {    │
    │   // Log error              │
    │   // Show user-friendly msg  │
    │ }                            │
    │                              │
    │ └─ No system details exposed │
    └──────────────────────────────┘
```

---

## Data Flow Summary

```
CLIENT (Browser)                CONTROLLER              DATABASE
     │                               │                       │
     │ 1. User fills form           │                       │
     ├──────────────────────────────>│                       │
     │                               │ 2. Validate data     │
     │                               │    & CSRF            │
     │                               │                       │
     │                               │ 3. QueryBuilder op  │
     │                               ├──────────────────────>│
     │                               │                       │
     │                               │<─ Confirm insert/   │
     │                               │   update/delete      │
     │                               │                       │
     │                               │ 4. Set flashdata     │
     │                               │    & redirect        │
     │<──────────────────────────────┤                       │
     │                               │                       │
     │ 5. Display success msg        │                       │
     │    & updated list             │                       │
     │                               │                       │
```

---

*Diagram generated for Your Gym Partner - Member CRUD Operations Flow*
