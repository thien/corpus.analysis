<?php
//------------------------------------------------------------------------
$directory = '/Users/ghost/booker/real_system/dict';

$phps = array();

$folders = glob($directory . '/*' , GLOB_ONLYDIR);
array_push($folders, '/Users/ghost/booker/real_system/dict');

foreach ($folders as $folder){
	if ($showfoundfolders == TRUE){
		// echo "<b>".$folder.'</b><br>';
	}
	foreach (scandir($folder) as $filez){
		if (strpos($filez, '.txt') !== FALSE){
			array_push($phps, $folder."/".$filez);
		}
	}
}


// foreach ($phps as $php){ //goes through all php files in array.
// 	echo '$'.str_replace(".txt", "", str_replace($folder."/sources/", "", $php)).' = array(';

// 		$filez = strtolower(file_get_contents($php)); 

// 		$separator = "\r\n";
// 		$line = strtok($filez, $separator);

// 		while ($line !== false) {
// 		  # do something with $line
// 		  $line = strtok($separator);
// 		  echo '"'.$line. '",';
// 		}
// 		echo ");";
// }

$file = '/Users/ghost/booker/real_system/dict/words.php';
$current = file_get_contents($file);
$current = "";
file_put_contents($file, $current);
$current = file_get_contents($file);
$words = 0;
$current .= '<?php';
$current .= "\n\n";
foreach ($phps as $php){ //goes through all php files in array.
	$current .= '$'.str_replace(".txt", "", str_replace($folder."/sources/", "", $php)).' = array(';

		$filez = strtolower(file_get_contents($php)); 

		$separator = "\r\n";
		$line = strtok($filez, $separator);

		while ($line !== false) {
		  $line = strtok($separator);
		  $current .= '"'.$line. '",';
		  $words++;
		}
		$current .= ");";
}
$current .= "\n\n";
$current .= '?>';
file_put_contents($file, $current);
$current = file_get_contents($file);
$current = str_replace(',"",', '', $current);
file_put_contents($file, $current);
echo "DONE!<br>";
echo $words . " words added to the list";
?>