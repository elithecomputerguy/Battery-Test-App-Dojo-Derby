<h1>Battery Time Tester</h1>

<?php
$ip = $_SERVER['SERVER_ADDR'];

echo "<div style='width:640; height:480; margin-left:auto; margin-right:auto;'>";
echo "<iframe src='http://".$ip.":8000' height=480 width=640></iframe>";
echo "</div>";
echo "<br>";
?>

<p>Current Test # <span id=currenttest>0</span></p>
<button onclick="power()">Press to Start/ Pause Test</button>

<p>Test Status: <span id="status">test</span></p>

<p>Timer: <span id="timer_clock">0000</span></p>

<p>Heading: <span id="heading">0000</span></p>

<p>Speed: <span id="speed">0000</span></p>

<h2>Previous Times</h2>
<?php
$logfiles = glob( "logs/" ."*.txt" );
natsort($logfiles);
$logfiles = array_reverse($logfiles);

$nextfilenumber = $logfiles[0];
if ($nextfilenumber == " "){
    $nextfilenumber = "1";
}
$nextfilenumber = trim($nextfilenumber, ".txt");
$nextfilenumber = trim($nextfilenumber, "logs/");
$nextfilenumber = $nextfilenumber+1;

$filecounter = 0;
foreach($logfiles as $files){
    $filecounter++; 
    if ($filecounter > 10) {
        unlink($files);
    }
    $uptime = file_get_contents("$files");
    $uptime = $uptime / 60;
    $uptime = number_format($uptime, 2);
    $files = trim($files, ".txt");
    $files = trim($files, "logs/");
    echo "Test: ".$files."  ----  ".$uptime." minutes";
    echo "<br>";
    
}
?>

<script>
    var logfilename = "<?php echo"$nextfilenumber"?>";
    
    var on_off = "off";

    document.getElementById("status").innerHTML = on_off;

    function power(){
            if (on_off == "off"){
                on_off = "on";
                document.getElementById("status").innerHTML = on_off;
            } else if (on_off == "on"){
                on_off = "off";
                document.getElementById("status").innerHTML = on_off;
                direction = "stop";
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", "./controls.php?command=" + direction);
                xmlhttp.send();                
            } else {
                on_off = "off";
                document.getElementById("status").innerHTML = on_off;
                direction = "stop";
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", "./controls.php?command=" + direction);
                xmlhttp.send();                
            }
    }

    setInterval(testTimer, 1000);

    var timer = 0;

    function testTimer(){
        if (on_off == "on"){
            timer++;
            document.getElementById("timer_clock").innerHTML = timer;

            random_number = Math.floor(Math.random()*10);
            switch(random_number){
                case 0:
                direction = "forward";
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", "./controls.php?command=" + direction);
                xmlhttp.send();
                break;
                case 1:
                direction = "backward";
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", "./controls.php?command=" + direction);
                xmlhttp.send();
                break;                
                case 2:
                direction = "stop";
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", "./controls.php?command=" + direction);
                xmlhttp.send();
                break;
                case 3:
                direction = "forwardLeft";
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", "./controls.php?command=" + direction);
                xmlhttp.send();
                break;
                case 4:
                direction = "left";
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", "./controls.php?command=" + direction);
                xmlhttp.send();
                break;                
                case 5:
                direction = "forwardRight";
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", "./controls.php?command=" + direction);
                xmlhttp.send();
                break;            
                case 6:
                direction = "right";
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", "./controls.php?command=" + direction);
                xmlhttp.send();
                break;

                case 7:
                speed = "slow";
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", "./speed.php?speed=" + speed);
                xmlhttp.send();
                break;                
                case 8:
                speed = "medium";
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", "./speed.php?speed=" + speed);
                xmlhttp.send();
                break;            
                case 9:
                speed = "fast";
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", "./speed.php?speed=" + speed);
                xmlhttp.send();
                break;            
            }

            document.getElementById("currenttest").innerHTML = logfilename;

            document.getElementById("heading").innerHTML = direction;

            document.getElementById("speed").innerHTML = speed;
            
            xmlhttp.open("GET", "./battery-log.php?timer=" + timer + "&logfilename=" + logfilename + ".txt");
            xmlhttp.send();

        }
    }
</script>