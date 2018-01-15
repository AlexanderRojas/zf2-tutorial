<?php
/**
 *Si no está el sqlite instalado, se usa este código para crear la base de datos. 
 */
$db = new PDO('sqlite:' . realpath(__DIR__) . '/zftutorial.db');
$fh = fopen(__DIR__ . '/schema.sql', 'r');
while ($line = fread($fh, 4096)) {
    $db->exec($line);
}
fclose($fh);