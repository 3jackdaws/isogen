<?php
$handle = fopen("json.txt", "r");
echo "opening json<br>";
$string = fread($handle, filesize("json.txt"));
//var_dump($string);
$json = json_decode($string);
//var_dump($json);
echo "\n\n\n\n";
//var_dump($json);
foreach ($json->{"commits"} as $commit) {
	$messages[] = $commit->{"message"};

}
var_dump($messages);

foreach ($messages as $message) {
	if(preg_match("/(?<=KRONOS:)[ ]*'.+'/", $message, $match))
	{
		preg_match_all("/[^,.]+/", $match, $commands);
		foreach ($commands as $cmd) {
			echo $cmd . "\n";
		}
	}
} 

#kill me, dsakjgl;fkns;lgn 


