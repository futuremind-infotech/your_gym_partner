<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'vendor/autoload.php';

echo "<h2>SMTP Connection Diagnostic</h2>";
echo "<hr>";

// Load configuration
$config = new \Config\Email();

echo "<h3>Current Email Configuration:</h3>";
echo "<table border='1' cellpadding='10'>";
echo "<tr><td><strong>SMTP Host:</strong></td><td>" . htmlspecialchars($config->SMTPHost) . "</td></tr>";
echo "<tr><td><strong>SMTP Port:</strong></td><td>" . $config->SMTPPort . "</td></tr>";
echo "<tr><td><strong>SMTP User:</strong></td><td>" . htmlspecialchars($config->SMTPUser) . "</td></tr>";
echo "<tr><td><strong>SMTP Encryption:</strong></td><td>" . $config->SMTPCrypto . "</td></tr>";
echo "<tr><td><strong>Mail Type:</strong></td><td>" . $config->mailType . "</td></tr>";
echo "<tr><td><strong>From Email:</strong></td><td>" . htmlspecialchars($config->fromEmail) . "</td></tr>";
echo "</table>";

echo "<h3>SMTP Connection Test:</h3>";

// Test SMTP connection
$fsock = @fsockopen($config->SMTPHost, $config->SMTPPort, $errno, $errstr, 5);

if ($fsock) {
    echo "<p style='color: green;'><strong>✓ SMTP connection successful!</strong></p>";
    fclose($fsock);
} else {
    echo "<p style='color: red;'><strong>✗ SMTP connection failed!</strong></p>";
    echo "<p>Error: " . htmlspecialchars($errstr) . " (Code: $errno)</p>";
    echo "<p><strong>Possible issues:</strong></p>";
    echo "<ul>";
    echo "<li>SMTP Host '" . htmlspecialchars($config->SMTPHost) . "' is not reachable</li>";
    echo "<li>SMTP Port " . $config->SMTPPort . " is blocked by firewall</li>";
    echo "<li>Your email service may not be configured</li>";
    echo "</ul>";
}

echo "<h3>Credentials Check:</h3>";
if ($config->SMTPUser === 'your-email@gmail.com' || $config->SMTPPass === 'your-app-password') {
    echo "<p style='color: red;'><strong>⚠️ SMTP credentials are still using placeholder values!</strong></p>";
    echo "<p><strong>You need to:</strong></p>";
    echo "<ol>";
    echo "<li>Choose an email service (Gmail, SendGrid, Mailtrap, etc.)</li>";
    echo "<li>Update the SMTP credentials in <code>app/Config/Email.php</code></li>";
    echo "<li>For Gmail: Get an <a href='https://myaccount.google.com/apppasswords' target='_blank'>App Password</a></li>";
    echo "</ol>";
} else {
    echo "<p style='color: green;'><strong>✓ Custom credentials are set</strong></p>";
}

echo "<h3>Send Test Email:</h3>";
echo "<form method='POST'>";
echo "<input type='email' name='test_email' placeholder='Enter test email address' required>";
echo "<button type='submit' name='send_test' class='btn btn-primary'>Send Test Email</button>";
echo "</form>";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_test'])) {
    $testEmail = trim($_POST['test_email']);
    
    echo "<h3>Attempting to send test email...</h3>";
    
    try {
        $email = \Config\Services::email();
        $email->clear();
        $email->setFrom('noreply@yourgymspartner.com', 'Your Gym Partner');
        $email->setTo($testEmail);
        $email->setSubject('SMTP Test Email');
        $email->setMessage('<h2>SMTP Test</h2><p>If you received this, SMTP is working!</p>');
        $email->setMailType('html');
        
        if ($email->send(false)) {
            echo "<p style='color: green;'><strong>✓ Email sent successfully!</strong></p>";
            echo "<p>Check your inbox at: " . htmlspecialchars($testEmail) . "</p>";
            echo "<p><em>Note: Check spam folder if not received immediately</em></p>";
        } else {
            echo "<p style='color: red;'><strong>✗ Email send failed</strong></p>";
            echo "<p><strong>Email Debug Output:</strong></p>";
            echo "<pre>" . htmlspecialchars($email->printDebugger()) . "</pre>";
        }
    } catch (\Throwable $e) {
        echo "<p style='color: red;'><strong>✗ Exception occurred:</strong></p>";
        echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<p><strong>Trace:</strong></p>";
        echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    }
}

?>
