<?php
// Email Test Script
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'vendor/autoload.php';

echo "<h2>Email Configuration & Service Test</h2>";
echo "<hr>";

// Test 1: Load configuration
try {
    $config = new \Config\Email();
    echo "<h3>✓ Email Configuration Loaded</h3>";
    echo "<ul>";
    echo "<li><strong>From Email:</strong> " . htmlspecialchars($config->fromEmail) . "</li>";
    echo "<li><strong>From Name:</strong> " . htmlspecialchars($config->fromName) . "</li>";
    echo "<li><strong>Protocol:</strong> " . htmlspecialchars($config->protocol) . "</li>";
    echo "<li><strong>Mail Type:</strong> " . htmlspecialchars($config->mailType) . "</li>";
    echo "<li><strong>Character Set:</strong> " . htmlspecialchars($config->charset) . "</li>";
    echo "</ul>";
} catch (Exception $e) {
    echo "<h3>✗ Configuration Error</h3>";
    echo "<p style='color:red'>" . htmlspecialchars($e->getMessage()) . "</p>";
    exit;
}

// Test 2: Create email service
try {
    $email = \Config\Services::email();
    echo "<h3>✓ Email Service Created</h3>";
} catch (Exception $e) {
    echo "<h3>✗ Email Service Error</h3>";
    echo "<p style='color:red'>" . htmlspecialchars($e->getMessage()) . "</p>";
    exit;
}

// Test 3: Setup test email
try {
    $email->clear();
    $email->setFrom('noreply@yourgymspartner.com', 'Your Gym Partner');
    $email->setTo('test@example.com');
    $email->setSubject('Test Email from Your Gym Partner');
    $email->setMessage('<h2>Test Email</h2><p>If you received this, email is working!</p>');
    $email->setMailType('html');
    
    echo "<h3>✓ Email Properties Set</h3>";
    echo "<ul>";
    echo "<li>To: test@example.com</li>";
    echo "<li>From: noreply@yourgymspartner.com</li>";
    echo "<li>Subject: Test Email from Your Gym Partner</li>";
    echo "<li>Message Type: HTML</li>";
    echo "</ul>";
} catch (Exception $e) {
    echo "<h3>✗ Email Setup Error</h3>";
    echo "<p style='color:red'>" . htmlspecialchars($e->getMessage()) . "</p>";
    exit;
}

// Test 4: Attempt send
echo "<h3>Attempting to Send Email...</h3>";
try {
    $result = $email->send(false);
    
    if ($result) {
        echo "<p style='color:green'><strong>✓ Email sent successfully!</strong></p>";
        echo "<p>Email was queued for delivery. Check server mail queue or logs.</p>";
    } else {
        echo "<p style='color:orange'><strong>⚠ Email function returned FALSE</strong></p>";
        echo "<p>The email service may not be fully configured for production. This could indicate:</p>";
        echo "<ul>";
        echo "<li>'mail' protocol may not work on this server</li>";
        echo "<li>PHP mail() function may be disabled</li>";
        echo "<li>Server mail relay may not be configured</li>";
        echo "</ul>";
    }
} catch (Exception $e) {
    echo "<p style='color:red'><strong>✗ Exception during send:</strong></p>";
    echo "<pre>" . htmlspecialchars($e->getMessage() . "\n" . $e->getTraceAsString()) . "</pre>";
}

echo "<hr>";
echo "<h3>System Information</h3>";
echo "<ul>";
echo "<li><strong>PHP Version:</strong> " . phpversion() . "</li>";
echo "<li><strong>OS:</strong> " . php_uname() . "</li>";
echo "<li><strong>CodeIgniter:</strong> Available</li>";
echo "</ul>";

echo "<p><a href='admin/payment'>Back to Payments</a></p>";
?>
