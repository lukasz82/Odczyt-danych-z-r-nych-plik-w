<?php

require_once('functions/load_functions.php');

// ----------------------------------------------------------
// Funkcja wyświetlająca dane o spógoskach
// ----------------------------------------------------------

$cons = array_merge($json["cons_json"],$csv["cons_csv"],$ldif["cons_ldif"]);

$cons_count = count($cons);

$all_cons_count = 0;
$vowel = 0;
$vowel_all = 0;
for ($i = 0; $i < $cons_count; $i++)
{
	$cons[$i] = str_replace(' ', '', $cons[$i]);
	$all_cons_count += strlen($cons[$i]);
	$vowel += substr_count($cons[$i], 'a'); 
	$vowel += substr_count($cons[$i], 'ą');
	$vowel += substr_count($cons[$i], 'e');
	$vowel += substr_count($cons[$i], 'ę');  
	$vowel += substr_count($cons[$i], 'i');
	$vowel += substr_count($cons[$i], 'o');  
	$vowel += substr_count($cons[$i], 'ó'); 
	$vowel += substr_count($cons[$i], 'u'); 
	$vowel += substr_count($cons[$i], 'y'); 
	$vowel_all += $vowel;
	$vowel = 0;
}

echo "Wszystkie znaki w Customer ";
echo $all_cons_count;
echo "</br></br>Wszystkie samogoski ";
echo $vowel_all;
echo "</br></br>Wszystkie spógoski ";
echo $all_cons_count - $vowel_all;
echo "</br>";echo "</br>";	
?>