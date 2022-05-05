<?php

if(!file_exists("logs")){
    mkdir("logs");
}

$logfilename = $_GET['logfilename'];
$timer=$_GET['timer'];
file_put_contents("logs/$logfilename", $timer);
print "Command: ".$timer."<br>";
?>