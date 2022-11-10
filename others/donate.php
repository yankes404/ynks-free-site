<?php 

$json = file_get_contents("../cfg/config.json");
$decoded = json_decode($json, JSON_OBJECT_AS_ARRAY);

header("location: {$decoded['donate']}");
exit("Linked to Discord!");