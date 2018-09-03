<?php

require_once('functions/load_functions.php');

// ----------------------------------------------------------
// Funkcja wyświetlająca dane o lekach
// ----------------------------------------------------------

$arr_orders = array_merge($json["orders_json"], $csv["orders_csv"],$ldif["orders_ldif"]);

sort($arr_orders);
$arr_orders_count = count($arr_orders);
$counter = 0;
$arr_orders_counts = array();

for ($i = 0; $i < $arr_orders_count; $i++)
{
	$counter++;
	if ($i+1 < $arr_orders_count)
	{
		if ($arr_orders[$i] != $arr_orders[$i+1])
		{
			$arr_orders_counts += [$arr_orders[$i]=>$counter]; 
			$counter = 0;
		}
	} 

	if ($i+1 == $arr_orders_count)
	{
		$arr_orders_counts += [$arr_orders[$i]=>$counter]; 
		$counter = 0;
	} 
}

$arr_orders_count = count($arr_orders_counts);

array_multisort($arr_orders_counts, SORT_DESC, array_keys($arr_orders_counts));

echo "</br>Wyświetlam listę najczęściej zamawianych leków z wszystrkich plików:</br>";

$i = 1;
foreach($arr_orders_counts as $x => $x_value) 
{
	if ($i == 31) break;
    echo $i. " : " . $x . ", Ilość zamówionych: " . $x_value;
    echo "<br>";
    $i++;
}

?>