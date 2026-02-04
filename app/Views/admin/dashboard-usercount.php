<?php
$db = \Config\Database::connect();
$query = $db->query("SELECT * FROM members")->getResultArray();
echo count($query);
?><!-- Visit codeastro.com for more projects -->

