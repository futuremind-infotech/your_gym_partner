<?php
$db = \Config\Database::connect();
$result = $db->query("SELECT SUM(amount) as total FROM equipment")->getRow();
echo $result ? ($result->total ?? 0) : 0;
?>

