<?php
$filename = __DIR__ . "_" . date("Y-m-d_H-i-s") . ".php";
file_put_contents($filename, 'qq');
echo $filename;
