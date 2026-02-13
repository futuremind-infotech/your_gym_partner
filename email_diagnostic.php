<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/html; charset=utf-8');

require 'vendor/autoload.php';

echo "<!DOCTYPE html>
<html>
<head>
    <title>Complete Email Diagnostic</title>
    <style>
        body { font-family: Arial; margin: 20px; background: #f5f5f5; }
        .container { max-width: 900px; margin: 0 auto; }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        .info { color: #0066cc; }
        .box { background: white; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #ddd; }
        .box.pass { border-left-color: green; }
        .box.fail { border-left-color: red; }
        pre { background: #f0f0f0; padding: 10px; overflow-x: auto; }
        table { border-collapse: collapse; width: 100%; }
        table td { border: 1px solid #ddd; padding: 8px; }
        table tr:nth-child(odd) { background: #f9f9f9; }
    </style>
</head>
<body>
<div class='container'>
    <h1>🔍 Complete Email Configuration Diagnostic</h1>
    <p>This tool will check every step of your email configuration</p>
    <hr>";

// Step 1: Configuration
echo "<h2>Step 1: Configuration Check</h2>";
try {
    $config = new \Config\Email();
    echo "<div class='box pass'>";
    echo "<p class='success'>✓ Configuration loaded successfully</p>";
    echo "<table>";
    echo "<tr><td><strong>SMTP Host</strong></td><td><code>" . htmlspecialchars($config->SMTPHost) . "</code></td></tr>";
    echo "<tr><td><strong>SMTP Port</strong></td><td><code>" . $config->SMTPPort . "</code></td></tr>";
    echo "<tr><td><strong>SMTP User</strong></td><td><code>" . htmlspecialchars($config->SMTPUser) . "</code></td></tr>";
    echo "<tr><td><strong>SMTP Pass</strong></td><td><code>" . (str_repeat('*', max(1, strlen($config->SMTPPass) - 4)) . substr($config->SMTPPass, -4)) . "</code></td></tr>";
    echo "<tr><td><strong>SMTP Auth</strong></td><td>" . $config->SMTPAuthMethod . "</td></tr>";
    echo "<tr><td><strong>SMTP Crypto</strong></td><td>" . $config->SMTPCrypto . "</td></tr>";
    echo "<tr><td><strong>SMTP Timeout</strong></td><td>" . $config->SMTPTimeout . "s</td></tr>";
    echo "<tr><td><strong>Mail Type</strong></td><td>" . $config->mailType . "</td></tr>";
    echo "</table>";
    echo "</div>";
    
    $configValid = true;
} catch (Exception $e) {
    echo "<div class='box fail'>";
    echo "<p class='error'>✗ Configuration Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "</div>";
    $configValid = false;
}

// Step 2: Connection Test
echo "<h2>Step 2: SMTP Connection Test</h2>";
if ($configValid) {
    echo "<p>Testing connection to: <code>" . htmlspecialchars($config->SMTPHost) . ":" . $config->SMTPPort . "</code></p>";
    $fsock = @fsockopen($config->SMTPHost, $config->SMTPPort, $errno, $errstr, 15);
    
    if ($fsock) {
        echo "<div class='box pass'>";
        echo "<p class='success'>✓ SMTP Connection Successful!</p>";
        echo "<p>Server responded successfully on port " . $config->SMTPPort . "</p>";
        echo "</div>";
        fclose($fsock);
        $connectionValid = true;
    } else {
        echo "<div class='box fail'>";
        echo "<p class='error'>✗ SMTP Connection Failed</p>";
        echo "<p><strong>Error:</strong> " . htmlspecialchars($errstr) . " (Code: $errno)</p>";
        echo "<p><strong>Possible causes:</strong></p>";
        echo "<ul>";
        echo "<li>Port " . $config->SMTPPort . " is blocked by firewall/ISP</li>";
        echo "<li>Mailtrap host is unreachable from your network</li>";
        echo "<li>Your internet connection issue</li>";
        echo "</ul>";
        echo "</div>";
        $connectionValid = false;
    }
} else {
    echo "<div class='box fail'><p class='error'>✗ Skipped (config error)</p></div>";
    $connectionValid = false;
}

// Step 3: Email Service
echo "<h2>Step 3: Email Service Initialization</h2>";
try {
    $email = \Config\Services::email();
    echo "<div class='box pass'>";
    echo "<p class='success'>✓ Email Service Created</p>";
    echo "</div>";
    $emailServiceValid = true;
} catch (Exception $e) {
    echo "<div class='box fail'>";
    echo "<p class='error'>✗ Email Service Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "</div>";
    $emailServiceValid = false;
}

// Step 4: Email Send Test
echo "<h2>Step 4: Email Send Test</h2>";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['test_send'])) {
    $testEmail = trim($_POST['test_email']);
    
    if (!filter_var($testEmail, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='box fail'><p class='error'>✗ Invalid email address</p></div>";
    } else if (!$connectionValid) {
        echo "<div class='box fail'><p class='error'>✗ Cannot test - SMTP connection failed</p></div>";
    } else if (!$emailServiceValid) {
        echo "<div class='box fail'><p class='error'>✗ Cannot test - Email service initialization failed</p></div>";
    } else {
        echo "<p>Sending test email to: <strong>" . htmlspecialchars($testEmail) . "</strong></p>";
        
        try {
            $email->clear();
            $email->setFrom('noreply@yourgymspartner.com', 'Your Gym Partner');
            $email->setTo($testEmail);
            $email->setSubject('Test Email from Gym Partner');
            $email->setMessage('<h2>Test Email</h2><p>If you see this, email is working!</p>');
            $email->setMailType('html');
            
            $result = $email->send(false);
            
            if ($result) {
                echo "<div class='box pass'>";
                echo "<p class='success'>✓ Email Sent Successfully!</p>";
                echo "<p>Email was accepted by Mailtrap. <a href='https://mailtrap.io' target='_blank'>Check your Mailtrap inbox here</a></p>";
                echo "</div>";
            } else {
                echo "<div class='box fail'>";
                echo "<p class='error'>✗ Email Send Failed</p>";
                echo "<p><strong>Debug Output:</strong></p>";
                echo "<pre>" . htmlspecialchars($email->printDebugger()) . "</pre>";
                echo "</div>";
            }
        } catch (\Throwable $e) {
            echo "<div class='box fail'>";
            echo "<p class='error'>✗ Exception: " . htmlspecialchars($e->getMessage()) . "</p>";
            echo "<p><strong>File:</strong> " . $e->getFile() . "</p>";
            echo "<p><strong>Line:</strong> " . $e->getLine() . "</p>";
            echo "<p><strong>Trace:</strong></p>";
            echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
            echo "</div>";
        }
    }
} else {
    echo "<p>Click below to send a test email:</p>";
}

// Form
echo "<div style='background: white; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
echo "<form method='POST'>";
echo "<div>";
echo "<label><strong>Email Address:</strong></label><br>";
echo "<input type='email' name='test_email' placeholder='your@email.com' required style='width: 300px; padding: 8px;'>";
echo "</div>";
echo "<button type='submit' name='test_send' style='margin-top: 10px; padding: 8px 20px; background: #1f4e78; color: white; border: none; border-radius: 4px; cursor: pointer;'>";
echo "Send Test Email";
echo "</button>";
echo "</form>";
echo "</div>";

echo "<hr>";
echo "<h2>Troubleshooting Guide</h2>";
echo "<div class='box'>";
echo "<p><strong>If SMTP connection fails:</strong></p>";
echo "<ul>";
echo "<li>Try port 25, 465 or 587 instead of 2525</li>";
echo "<li>Contact your ISP - they may block SMTP ports</li>";
echo "<li>Use a VPN to test</li>";
echo "</ul>";
echo "</div>";

echo "<div class='box'>";
echo "<p><strong>If email sends but doesn't appear in Mailtrap:</strong></p>";
echo "<ul>";
echo "<li>Log in to mailtrap.io and check the right inbox</li>";
echo "<li>Check email spam/junk folder</li>";
echo "<li>Verify your Mailtrap credentials are exactly correct</li>";
echo "</ul>";
echo "</div>";

echo "</div>
</body>
</html>";
?>
