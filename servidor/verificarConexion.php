<?php
include_once('../otros/otros.php');
$xml = new Xml();
$xml->startTag("Dato");
$xml->addTag("Estado","true");
$xml->closeTag("Dato");
echo $xml->toString();
?>
