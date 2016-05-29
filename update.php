<?php
//$handle = fopen("json.txt", "r");
//echo "opening json<br>";
//$string = fread($handle, filesize("json.txt"));
//var_dump($string);
$json = json_decode($_POST["payload"]);
//var_dump($json);
echo "\n\n\n\n";
//var_dump($json);
foreach ($json->{"commits"} as $commit) {
	$messages[] = $commit->{"message"};

}
//var_dump($messages);

foreach ($messages as $message) {
	if(preg_match("/(?<=KRONOS:)[ ]*'.+'/", $message, $match))
	{
		preg_match_all("/[^,^'.]+/", $match[0], $commands);
		//var_dump($commands);
		foreach ($commands[0] as $cmd) {
			runCommand($cmd);
			echo $cmd . "<br>";
		}
	}
}


function runCommand($cmd){
	if(strtolower($cmd) == "update")
	{
		exec("/var/www/sites/isogen/updatesite.sh");
	}
} 



