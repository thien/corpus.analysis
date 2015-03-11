<?php
include 'words.php';
$time_start = microtime(true);
$new_words = array();
$uncounted = array();
$other = array();

$words = trim(preg_replace('/\s\s+/', ' ', $_POST['input']));
$words = explode(' ', $words);
foreach ($words as $word){
	$word = preg_replace("/[^a-zA-Z'\s\-]/", '', strtolower($word));
	array_push($new_words, $word);
}
$new_words = array_filter($new_words);

$time_finish_accumulation = microtime(true);

foreach ($new_words as $word){
	if (in_array($word, $adjectives)){
		$adj++;
	} elseif (in_array($word, $adverbs)){
		$adv++;
	} elseif (in_array($word, $verbs)){
		$ver++;
	} elseif (in_array($word, $pronouns)){
		$pro++;
	} elseif (in_array($word, $nouns)){
		$nou++;
	} else {
		array_push($other, $word);
	}
}

foreach ($other as $word){
	if (in_array($word, $determiners)){
		$det++;
	} elseif (in_array($word, $conjunctions)){
		if (in_array($word, $prepositions)){
			$prep++;
		} else {
		$conj++;
		}
	}
	else {
		$else++;
		array_push($uncounted, $word);
	}
}

$uncounted_list = array_values(array_unique($uncounted));
$time_finish_matching = microtime(true);

echo "<center><h1>Glorious Word Counter (Beta!)</h1>";
echo "<h2>“I choose a lazy person to do a hard job. Because a lazy person will find an easy way to do it.” - Bill Gates</h2></center>";


echo '<div style="width: 45%; float:left">
<form method="POST" action="index.php">
Plop your text in here:<br>

<textarea name="input" rows="20" cols="50">';
if ($_POST){
	echo $_POST['input'];
}
echo '</textarea>
<br>
<input type="submit" value="Submit">
</form>
<p>Notes<br>
If there are words that are uncounted contact me at 64881@woodhouse so i can make the dictionary list better. Cheers!<br><br>
<i>PS: Xavia and tom owes me money</i>
</div>
';
echo '<div style="width: 45%; float:right">';
if ($_POST){
	$hunna = 100;
	$totalwords = str_word_count($_POST['input']);
	echo "Parsing your data took ". number_format(($time_finish_accumulation - $time_start), 3, '.', ',').' seconds <br>';
	echo "Matching took ". number_format(($time_finish_matching - $time_finish_accumulation), 3, '.', ',').' seconds<br>';
	echo "The entire thing took ". number_format(($time_finish_matching - $time_start), 3, '.', ',').' seconds<br><br>';
	echo "Estimated Word Count:" . str_word_count($_POST['input']) . "<br>";
	echo "Adjectives: " . $adj . " (".number_format(($adj/$totalwords) * $hunna, 1, '.', ',')."%)<br>";
	echo "Verbs: " . $ver . " (".number_format(($ver/$totalwords) * $hunna, 1, '.', ',')."%)<br>";
	echo "Adverbs: " . $adv . " (".number_format(($adv/$totalwords) * $hunna, 1, '.', ',')."%)<br>";
	echo "Pronouns: " . $pro . " (".number_format(($pro/$totalwords) * $hunna, 1, '.', ',')."%)<br>";
	echo "Nouns: " . $nou . " (".number_format(($nou/$totalwords) * $hunna, 1, '.', ',')."%)<br>";
	echo "Determiners: ". $det . " (".number_format(($det/$totalwords) * $hunna, 1, '.', ',')."%)<br>";
	echo "Prepositions: ". $prep . " (".number_format(($prep/$totalwords) * $hunna, 1, '.', ',')."%)<br>";
	echo "Uncounted: " . $else . " (".number_format(($else/$totalwords) * $hunna, 1, '.', ',')."%)<br><br>";
	echo "Accuracy: " .($totalwords - $else) . "/" . $totalwords . " (".number_format((($totalwords-$else)/$totalwords) * $hunna, 1, '.', ',')."%)<br><br>";

	if (!empty($uncounted_list)){
		echo "Words that are not counted (duplicates are hidden): <br><pre>";
		foreach($uncounted_list as $word){
			echo "<i>$word</i><br>";
		}

		echo "</pre></div>";
	}
}

?>