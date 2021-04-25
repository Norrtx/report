<?php
$simple_data = array(
	0 => 'a',
	1 => 'b',
	2 => 'c',
	3 => 'd',
	4 => 'e',
	5 => 'f',
	6 => 'g',
	7 => 'h',
	8 => 'i',
	9 => 'j',
);

if( isset($_GET['index']) ){
	$index = $_GET['index'];
}
else{
	$index = 0;
}
if( isset($_GET['requestByAjax']) ){
	echo json_encode( array(
		'data1' => $simple_data[$index]
	));
}
else {
	echo $simple_data[$index];
}

?>



