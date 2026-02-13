<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Test the sendReminder route directly
echo "<h1>🧪 Send Reminder Test</h1>";

// Simulate what happens when clicking the send button
$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST = [
    'member_id' => '1',
    'action' => 'send_reminder'
];

echo "<h3>Simulating POST request:</h3>";
echo "<pre>";
echo "Method: " . $_SERVER['REQUEST_METHOD'] . "\n";
echo "POST data:\n";
print_r($_POST);
echo "</pre>";

echo "<h3>Testing direct form submission:</h3>";
?>

<form method="POST" action="/admin/sendReminder/1" id="testForm">
    <input type="hidden" name="member_id" value="1">
    <input type="hidden" name="action" value="send_reminder">
    <p>
        <button type="submit" class="btn btn-warning">Test Form Submit</button>
    </p>
</form>

<h3>Debug Info:</h3>
<pre>
BASE_URL: <?= getenv('CI_ENVIRONMENT') ?>
Script Name: <?= $_SERVER['SCRIPT_NAME'] ?>
Request URI: <?= $_SERVER['REQUEST_URI'] ?>
</pre>

<h3>Check logs:</h3>
<?php
$logFile = 'writable/logs/log-' . date('Y-m-d') . '.log';
if (file_exists($logFile)) {
    echo "<p>Log file exists: <strong>$logFile</strong></p>";
    $lines = file($logFile);
    $recentLines = array_slice($lines, -20); // Last 20 lines
    echo "<pre>";
    echo implode('', $recentLines);
    echo "</pre>";
} else {
    echo "<p>No log file found for today</p>";
}
?>
