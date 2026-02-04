<?php
$db = \Config\Database::connect();
$query = $db->query("SELECT * FROM members WHERE status ='Active'")->getResultArray();
echo count($query);
?>

