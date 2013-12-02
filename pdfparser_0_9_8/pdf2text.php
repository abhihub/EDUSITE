<?php
 
// Include Composer autoloader if not already done.
include 'vendor/autoload.php';

// Filename
$filename = isset($argv[1])?$argv[1]:'document.pdf';
 
// Parse pdf file and build necessary objects.
$parser = new \Smalot\PdfParser\Parser();
$pdf    = $parser->parseFile($filename);
 
$text = $pdf->getText();
echo $text;

