<?php
$db = \Config\Database::connect();
$query = $db->query("SELECT * FROM equipment")->getResultArray();
echo count($query);
                
?><!-- Visit codeastro.com for more projects -->

