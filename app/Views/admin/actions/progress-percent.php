<?php
$db = \Config\Database::connect();
$sql = "SELECT SUM((curr_weight - ini_weight) / ini_weight * 100) as percent FROM members WHERE user_id='" . $db->escape($id) . "'";
$result = $db->query($sql)->getRow();
echo (int)($result ? ($result->percent ?? 0) : 0);
?>

