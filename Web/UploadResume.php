<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link href="http://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    
</head>
<body>
<textarea id="txtskill" class="skillstextarea" placeholder="Add your skills here" style="height: 300px; width: 430px;"></textarea>
<button id="btnupload" style="height: 30px; width: 130px;">Upload</button>
  <script type="text/javascript">
    $('#btnupload').click(function () {
        console.log($('#txtskill').val());
        $.ajax({ url: 'ParseAndSaveSkills.php',
         // data: {action: 'get_missingskills_job'},
         data: { skillstring: $('#txtskill').val() },
         type: 'POST',
         success: function(output) {
                      //SWITCH TO OTHER PAGE
                      alert(output);
                      window.location.replace("ResultsForSkills.php");
                      //$('#naslov b').html(output);
                  }
        });
    });
    </script>
</body>
</html>