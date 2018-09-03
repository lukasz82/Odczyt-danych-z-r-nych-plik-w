<?php

require_once('functions/load_functions.php');

// ----------------------------------------------------------
// Łączę tabele
// ----------------------------------------------------------
$arr_country = array_merge($json["country_json"], $csv["country_csv"],$ldif["country_ldif"]);
$arr_group = array_merge($json["group_json"], $csv["group_csv"],$ldif["group_ldif"]);

// ----------------------------------------------------------
// Analizuję  i przekazuję do nowych tablic
// ----------------------------------------------------------
$arr_country_counts = array();
$arr_country_groups = array();
$arr_clients_quantity = array();

function search($arr_country, $arr_group)
{
	$count_lines = count($arr_country);
	$counter = 0;

	$group = $arr_group[0];

	for ($i = 0; $i < $count_lines; $i++)
	{
		$counter++;
		if ($i+1 < $count_lines)
		{
			if ($arr_country[$i] != $arr_country[$i+1])
			{
				if ($counter > 1)
				{
					$arr_country_counts[] = $arr_country[$i]; 
					$arr_country_groups[] = $arr_group[$i];
					$arr_clients_quantity[] = $counter;
				}
				$counter = 0;
			}
		} 

		if ($i+1 == $count_lines)
		{
			if ($counter > 1)
			{
				$arr_country_counts[] = $arr_country[$i]; 
				$arr_country_groups[] = $arr_group[$i];
				$arr_clients_quantity[] = $counter;
			}
			$counter = 0;
		}
	}
	//show_simple_3_arrays($arr_country_counts, $arr_country_groups, $arr_clients_quantity);
	array_multisort($arr_clients_quantity,SORT_DESC, $arr_country_groups, $arr_country_counts);

	$count_lines = count($arr_country_groups);
	$counter = 0;

	$arr_country_group_copy = array();
	$arr_countries_list = array();
	$arr_clients_quantity_copy = array();

	$arr_countries = "";

	for ($i = 0; $i < $count_lines; $i++)
	{
		$counter++;
		$arr_countries = $arr_countries." ".$arr_country_counts[$i].", ";
		if ($i+1 < $count_lines)
		{
			if ($arr_country_groups[$i] != $arr_country_groups[$i+1])
			{
					$arr_country_group_copy[] = $arr_country_groups[$i];
					$arr_countries_list[] = $arr_countries;
					$arr_clients_quantity_copy[] = $arr_clients_quantity[$i];
					$arr_countries = "";
			}
		} 
	}

	show_simple_3_arrays($arr_countries_list, $arr_country_group_copy, $arr_clients_quantity_copy);
}


array_multisort($arr_country,SORT_ASC, $arr_group);
search($arr_country, $arr_group);
//show_simple($arr_country, $arr_group);


function show($arr_all) 
	{
		$count_cols = 5;
		$count_lines = count($arr_all);
		echo "<table>";
		for($i = 0; $i < $count_lines; $i++)
		{
			echo "<tr>";
			for($j = 0; $j < $count_cols; $j++)
			{
				echo "<td>";
				echo $arr_all[$i][$j];
				echo "</td>";
			}
			echo "</tr>";
			echo "</br>";
		}
		echo "</table>";
	}

function show_simple($arr1, $arr2) 
	{
		$count_lines = count($arr1);
		echo "<table>";
		for($i = 0; $i < $count_lines; $i++)
		{
			echo "<tr>";
				echo "<td>";
				echo $arr1[$i];
				echo "</td>";
				echo "<td>";
				echo $arr2[$i];
				echo "</td>";
			echo "</tr>";
		}
		echo "</table>";
	}

function show_simple_3_arrays($arr1, $arr2, $arr3) 
	{
		$count_lines = count($arr1);
		echo '<table style="max-width:700px; border-width:1px;" >';
		echo "<tr><th>Kraj</th><th>Grupa</th><th>Ilość klientów</th></tr>";

		for($i = 0; $i < $count_lines; $i++)
		{
			echo "<tr>";
				echo "<td>";
				echo $arr1[$i];
				echo "</td>";
				echo "<td>";
				echo $arr2[$i];
				echo "</td>";
				echo "<td>";
				echo $arr3[$i];
				echo "</td>";
			echo "</tr>";
		}
		echo "</table>";
	}

?>