<?php
$db = \Config\Database::connect();
$query = $db->query("SELECT * FROM staffs WHERE designation='Trainer'")->getResultArray();
echo count($query);
?><!-- Visit codeastro.com for more projects -->

