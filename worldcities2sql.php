<?php

$sqltable = 'CREATE TABLE IF NOT EXISTS "cities" (
	"gid" INTEGER NOT NULL UNIQUE , 
	"iso" TEXT, 
	"name" TEXT, 
	"asciiname" TEXT, 
	"latitude" REAL, 
	"longitude" REAL, 
	"timezone" TEXT, 
	"population" INTEGER, 
	"elevation" INTEGER, 
	"alternate_names" TEXT, 
	"feature_class" TEXT, 
	"feature_code" TEXT, 
	"cc2" TEXT, 
	"admin1_code" TEXT, 
	"admin2_code" TEXT, 
	"admin3_code" TEXT, 
	"admin4_code" TEXT, 
	"dem" INTEGER, 
	"updated" TEXT)';


$fields = array (
  0 => 'gid',
  1 => 'name',
  2 => 'asciiname',
  3 => 'alternate_names',
  4 => 'latitude',
  5 => 'longitude',
  6 => 'feature_class',
  7 => 'feature_code',
  8 => 'iso',
  9 => 'cc2',
  10 => 'admin1_code',
  11 => 'admin2_code',
  12 => 'admin3_code',
  13 => 'admin4_code',
  14 => 'population',
  15 => 'elevation',
  16 => 'dem',
  17 => 'timezone',
  18 => 'updated'
);

$col = $values = '';
foreach ($fields as $k => $v) {
	$col .= $v.', ';
	$values .= ':'.$v.', ';
}
$col = trim($col, " ,");
$values = trim($values, " ,");
$sqlinsert = "INSERT INTO cities ($col) VALUES ($values)";

$db = new SQLite3('geo.sqlite');
$db->exec($sqltable);
$stmt = $db->prepare($sqlinsert);

$file = 'allCountries.txt';
$i = 0;
$fp = fopen($file, 'r');
while ($line = fgets($fp)) {
	$array = explode("\t", $line);
	foreach($array as $k => $v){
		$stmt->bindValue(':'.$fields[$k], trim($v));
	}
	$result = $stmt->execute();
	echo $i. "\t\t-> ". $array[8] .' -> '. $array[1] . PHP_EOL;
	$i++;
}
fclose($fp);
$db->close();
?>
