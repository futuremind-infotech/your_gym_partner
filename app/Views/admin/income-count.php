<?php
$db = \Config\Database::connect();
$result = $db->query("SELECT SUM(amount) as total FROM members")->getRow();
echo $result ? ($result->total ?? 0) : 0;
?><!-- Visit codeastro.com for more projects -->

