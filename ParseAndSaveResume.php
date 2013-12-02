<?php
require 'ProceduresToJson.php';
require 'DocxConversion.php';
include 'vendor/autoload.php';
$widgetJobs = new ProcedureToJson();
$widgetJobs->init();
if(empty($_SESSION['user'])) 
{ 
	header("Location: index.php"); 
	die("Redirecting to index.php"); 
} 
$DBH = common::getInstance()->getDatabase();
$userid = $_SESSION['user']['id'];

$ds = DIRECTORY_SEPARATOR;
$storeFolder = 'uploads';

if (!empty($_FILES)) 
{   
  $tempFile = $_FILES['file']['tmp_name'][0];
  $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds; 
  $targetFile =  $targetPath. $userid . "_" . $_FILES['file']['name'][0];
  $fileType = $_FILES['file']['type'][0];
  $finfo = finfo_open(FILEINFO_MIME_TYPE);
  $mime = finfo_file($finfo, $targetFile);
  echo "Mime: " . $mime . " ,FileType:" . $fileType;
  if($mime == "application/msword" || $mime == "application/octet-stream" || $fileType == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
  {
    try
    {
        move_uploaded_file($tempFile,$targetFile); 
        $widgetDocConversion = new DocxConversion($targetFile);
        $text = $widgetDocConversion->convertToText();
        unlink($targetFile);
    } 
    catch (Exception $e) 
    {
        echo 'Insert/Truncate failed: ' . $e->getMessage();
    }
}
else if($mime == "application/pdf" || $fileType == "application/pdf")
{
    $message = '';
    try 
    {
        $content = '';
        $content = file_get_contents($_FILES['file']['tmp_name'][0]);

        if ($content) {
            $parser = new \Smalot\PdfParser\Parser();
            $pdf    = $parser->parseContent($content);
            $pages  = $pdf->getPages();

            foreach ($pages as $page) {
                $text = $text . $page->getText();
            }
        } 
        else 
        {
            throw new Exception('Unable to retrieve content. Check if it is really a pdf file.');
        }
    } catch(Exception $e) 
    {
        $message = $e->getMessage();
    }
}
else 
{
    die ("Error reading resume");
}

$widgetJobs->insert_resume_for_user($text, $userid);

$splitresults = preg_split('/((^\p{P}+)|(\p{P}*\s+\p{P}*)|(\p{P}+$))/', $text, -1, PREG_SPLIT_NO_EMPTY);
$splitresults = array_unique($splitresults);
$TruncateSkills="DELETE FROM usersskills WHERE userid =" . $userid. " AND sourceid = 2";
$numRows=$DBH->exec($TruncateSkills); 
$STHGetSkillIdFromSkills = $DBH->prepare('SELECT id FROM skills WHERE name = :skillname');
$STHGetSkillIdFromSkills->bindParam(':skillname', $skillname);
$STHInsertUserSkillRelation = $DBH->prepare("INSERT INTO usersskills (userid, skillid, sourceid) values (:userid, :skillid, 2)"); 
$STHInsertUserSkillRelation->bindParam(':userid', $userid);
$STHInsertUserSkillRelation->bindParam(':skillid', $skillid);
foreach($splitresults as $splititem)
{
  $skillname = $splititem;
  $STHGetSkillIdFromSkills->execute();
  $resultsGetSkillId = $STHGetSkillIdFromSkills->fetch();
  $skillid = $resultsGetSkillId[0];
  if(isset($skillid))
  {
     $STHInsertUserSkillRelation->execute();  
 }
}
}

?>     
