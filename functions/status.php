<?php

require_once('functions/load_functions.php');

// ----------------------------------------------------------
// Funkcja wyświetlająca dane o statusach matrymonialnych
// ----------------------------------------------------------

$status_json["json"] = $json["status_json"];
$status_csv["csv"] = $csv["status_csv"];
$status_ldif["ldif"] = $ldif["status_ldif"];
$status_json_key =  array_keys($status_json);
$status_csv_key =  array_keys($status_csv);
$status_ldif_key =  array_keys($status_ldif);

function analyze($status_arr, $status_key)
{
	sort($status_arr[$status_key[0]]);
	$status_arr_count = count($status_arr[$status_key[0]]);
	$counter = 0;
	$status_arr_counts = array();

	for ($i = 0; $i < $status_arr_count; $i++)
	{
		$counter++;
		if ($i+1 < $status_arr_count)
		{
			if ($status_arr[$status_key[0]][$i] != $status_arr[$status_key[0]][$i+1])
			{
				// Powoduje, że klucz jest dopisywany na końcu
				if ($i < $status_arr_count - 1)
				{
					$status_arr_counts += [$status_arr[$status_key[0]][$i]=>$counter];
					$counter = 0;
				} 
				else if ($i == $status_arr_count - 1)
				{
					$status_arr_counts += [$status_arr[$status_key[0]][$i]=>$counter, "key" => $status_key[0]];
					$counter = 0;
				} 
			}
		} 

		if ($i+1 == $status_arr_count)
		{
			$status_arr_counts += [$status_arr[$status_key[0]][$i]=>$counter, "key" => $status_key[0]]; 
			$counter = 0;
		} 
	}

	$status_arr_count = count($status_arr_counts);

	return array($status_arr_counts);
}

$json_s = analyze($status_json,$status_json_key);
$csv_s = analyze($status_csv,$status_csv_key);
$ldif_s = analyze($status_ldif,$status_ldif_key);

$status = array_merge($json_s,$csv_s,$ldif_s);
$status_keys = array_keys($status[0]);

$status_count = count($status);
$tab = array();
for ($j = 0; $j < 4; $j++)
{
	$tab = array();
	for ($i = 0; $i< $status_count; $i++)
	{	
		$tab[] = array($status_keys[$j] => $status[$i][$status_keys[$j]],"file"=> $status[$i][$status_keys[4]]);
		$tab[] = array($status_keys[$j] => $status[$i][$status_keys[$j]],"file"=> $status[$i][$status_keys[4]]);
		$tab[] = array($status_keys[$j] => $status[$i][$status_keys[$j]],"file"=> $status[$i][$status_keys[4]]);
	}
	array_multisort($tab, SORT_DESC);
	echo "</br>";
	echo "Największa ilość statusów ".key($tab[0])." wynosi ".$tab[0][$status_keys[$j]]." w pliku ".$tab[0]["file"];
}

echo "</br></br>"
	
?>