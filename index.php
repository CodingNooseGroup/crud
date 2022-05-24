<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
    <script src="crud/js/script.js"></script>
    
</head>
<body>
<div id="target">
  Click here
</div>
<div id="other">
  Trigger the handler
</div>
<script>
    $( "#target" ).click(function() {
  alert( "Handler for .click() called." );
});
$( "#other" ).click(function() {
$('#add_modal').modal('show')
});
</script>
</body>
</html>