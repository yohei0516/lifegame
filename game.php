<?php 
session_start();

function check_around($cell, $cell_x, $cell_y){
	$count = 0;
	for($y=-1; $y<=1; $y++){
		for($x=-1; $x<=1; $x++){
			if($x == 0 && $y == 0) continue;
			if(
				isset($cell[$cell_x + $x][$cell_y + $y]) &&
				$cell[$cell_x + $x][$cell_y + $y] == 1
			){
				$count++;
			}
		}
	}

	$result = 0;

	$current = $cell[$cell_x][$cell_y];

	if($current == 1 && $count <= 1) $result = 0;
	if($current == 1 && $count >= 4) $result = 0;
	if($current == 1 && ($count == 2 || $count == 3)) $result = 1;
	if($current == 0 && $count == 3) $result = 1;

	return $result;
}

$cell = array();

$size_x = 20;
$size_y = 20;

$reset = (!isset($_SESSION['cell'])) ? true : false;

if($reset === true || empty($_SESSION['cell'])){
	$_SESSION['cell'] = array();
	for($y=0; $y<$size_y; $y++){
		for($x=0; $x<$size_x; $x++){
			$cell[$x][$y] = mt_rand(0,1);
		}
	}


} else {
	$cell = $_SESSION['cell'];
}

if($reset !== true){
	$next_cell = array();
	for($y=0; $y<$size_y; $y++){
		for($x=0; $x<$size_x; $x++){
			$next_cell[$x][$y] = check_around($cell, $x, $y);
		}
	}
	$cell = $next_cell;
}

$_SESSION['cell'] = $cell;

header("Content-type:text/html;charset=utf-8");

for($y=0; $y<$size_y; $y++){
	for($x=0; $x<$size_x; $x++){
		if($cell[$x][$y] == 0){
			echo "□";
		} else {
			echo "■";
		}
	}
	echo "<br />\n";
}
?>