<?php

// ----------------------------------------------------------
// Wczytuję dane z json
// ----------------------------------------------------------
$arr_country_json = array();
$arr_group_json = array();

function load_json1()
{
	$string = file_get_contents("functions/dataFeb-2-2017.json");
	$arr = json_decode($string, true);

	$count_cols = count($arr['cols']);
	$count_lines = count($arr['data']);

	for($i = 0; $i < $count_lines; $i++)
	{
		for($j = 0; $j < $count_cols; $j++)
		{
			if ($j == 2)
			{
				$arr_orders[] = $arr['data'][$i][$j]; 
			}

			if($j == 1)
			{
				$arr_country_json[] = $arr['data'][$i][$j]; 
			}

			if($j == 4)
			{
				$arr_group_json[] = $arr['data'][$i][$j]; 
			}
			if($j == 3)
			{
				$arr_status_json[] = $arr['data'][$i][$j]; 
			}
			if($j == 0)
			{
				$arr_cons_json[] = $arr['data'][$i][$j]; 
			}
		}
	}
	return array("country_json"=>$arr_country_json,"group_json"=>$arr_group_json,"orders_json"=>$arr_orders,"status_json"=>$arr_status_json,"cons_json"=>$arr_cons_json);
}


// ----------------------------------------------------------
// Wczytuję dane z csv
// ----------------------------------------------------------
$arr_country_csv = array();
$arr_group_csv = array();

function load_csv1()
{
	$fh = fopen('functions/dataFeb-2-2017.csv', 'r');
	$csv = fgetcsv($fh, 1000, "\t");
	$csv_arr = array();
	while(($row = fgetcsv($fh, 1000, "\t")) !== false)
	{
	    $single = explode("|", $row[0]);
	    $csv_arr[] = $single;
	    //echo "</br>";
	}

	$count = count($csv_arr);
	$csv_arr_orders = array();
	for ($i = 0; $i < $count; $i++)
	{
		$csv_arr_orders[] = $csv_arr[$i][2];
		$arr_country_csv[] = $csv_arr[$i][1];
		$arr_group_csv[] = $csv_arr[$i][4];
		$arr_status_csv[] = $csv_arr[$i][3];
		$arr_cons_csv[] = $csv_arr[$i][0];
	}
	return array("country_csv"=>$arr_country_csv,"group_csv"=>$arr_group_csv,"orders_csv"=>$csv_arr_orders,"status_csv"=>$arr_status_csv,"cons_csv"=>$arr_cons_csv);
}


// ----------------------------------------------------------
// Wczytuję dane z ldif
// ----------------------------------------------------------
$arr_country_ldif = array();
$arr_group_ldif = array();

function load_ldif1()
{
	$file = fopen("functions/dataFeb-2-2017.ldif", "r");
	$length = filesize("functions/dataFeb-2-2017.ldif");

	$arr = array();

	$tabul = false;
	$enter = false;
	$double_enter = false;
	$word = "";
	$category = "";
	$cat_arr = array();
	$cat_load = false;
	
	$counter = 0;
	$cat_counter = 0;

		while(!feof($file))
		{
			$sign = fgetc($file);
			
			if ($sign == ":") $tabul = true;
			if ($sign == "\n") $enter = true;


			if ($sign != ":" && $tabul == true && $enter == false) $word = $word.$sign;

			if ($sign != ":" && $tabul == false && $enter == false) $category = $category.$sign;
			
			if ($sign != ":" && $tabul == true && $enter == true) 
			{				

				if ($cat_load == false)
				{
					$arr[$counter][] = $word;
					$word = "";
					$tabul = false;
					$enter = false;
					$cat_arr[] = $category;
					$cat_counter = 0;
					$category = "";
				}

				if ($cat_load == true)
				{
					if ($cat_arr[$cat_counter] == $category)
					{
						$arr[$counter][] = $word;
						$word = "";
						$tabul = false;
						$enter = false;
						$cat_counter++;
						$category = "";
					} 
					else if ($cat_arr[$cat_counter] != $category)
					{
						$arr[$counter][] = "Single";
						$arr[$counter][] = $word;
						$word = "";
						$tabul = false;
						$enter = false;
						$category = "";
						//$cat_counter++;
						$cat_counter = $cat_counter + 2;
					}
				}
			}

			if ($sign == "\n" && $enter == true) 
			{
				$double_enter = true;
				$cat_load = true;
				$enter = false;
				$counter++;
				$cat_counter = 0;
			}
		}

		$count = count($arr);
		for ($i = 0; $i < $count; $i++)
		{
			$arr_orders[] = $arr[$i][2];
			$arr_country_ldif[] = $arr[$i][1];
			$arr_group_ldif[] = $arr[$i][4];
			$arr_status_ldif[] = $arr[$i][3];
			$arr_cons_ldif[] = $arr[$i][0];
		}
	return array("country_ldif"=>$arr_country_ldif,"group_ldif"=>$arr_group_ldif,"orders_ldif"=>$arr_orders,"status_ldif"=>$arr_status_ldif,"cons_ldif"=>$arr_cons_ldif);
}

?>