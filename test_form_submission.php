<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'vendor/autoload.php';

// Simple test to see if form submission works
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<html><body>";
    echo "<h1>✅ Form Submitted Successfully!</h1>";
    echo "<p>Method: " . $_SERVER['REQUEST_METHOD'] . "</p>";
    echo "<p>POST data:</p>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    echo "<p><a href='javascript:history.back()'>← Go Back</a></p>";
    echo "</body></html>";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Simple Form Test</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        form { background: #f0f0f0; padding: 20px; border-radius: 5px; }
        input, button { padding: 8px; margin: 5px 0; }
        button { background: #007bff; color: white; border: none; border-radius: 3px; cursor: pointer; }
        button:disabled { background: #6c757d; }
    </style>
</head>
<body>
<h1>🧪 Simple Form Submission Test</h1>

<form method="POST" id="testForm">
    <h3>Test 1: Simple POST Form (without CSRF)</h3>
    <input type="text" name="test_field" value="test data" placeholder="Test">
    <button type="submit">Submit Test Form</button>
</form>

<hr style="margin: 30px 0;">

<form method="POST" action="<?= site_url('admin/sendReminder/1') ?>">
    <h3>Test 2: POST to sendReminder with CSRF</h3>
    <?= csrf_field() ?>
    <input type="hidden" name="member_id" value="1">
    <input type="hidden" name="action" value="send_reminder">
    <button type="submit">Submit to sendReminder</button>
</form>

<hr style="margin: 30px 0;">

<h3>Debug Info:</h3>
<pre>
base_url(): <?= base_url() ?>
site_url('admin/sendReminder/1'): <?= site_url('admin/sendReminder/1') ?>
</pre>

<script>
console.log('Page loaded');
document.getElementById('testForm').addEventListener('submit', function(e) {
    console.log('Form submitted!');
    console.log('Event:', e);
});
</script>
</body>
</html>
