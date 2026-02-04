<?php
$db = \Config\Database::connect();
$sql = "SELECT SUM(curr_weight - ini_weight) as diff FROM members WHERE user_id='" . $db->escape($id) . "'";
$result = $db->query($sql)->getRow();
echo $result ? ($result->diff ?? 0) : 0;
?>

