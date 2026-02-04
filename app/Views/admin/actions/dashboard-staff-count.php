<?php
$db = \Config\Database::connect();
$query = $db->query("SELECT * FROM staffs")->getResultArray();
echo count($query);
?>

