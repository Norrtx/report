<?php

use yii\helpers\Url;

$urlServe = Url::to(['/report/default/test']);

$POS_HEAD = <<< JS
// $(document).ready(function() {
// 	$('#btn').click(function(){
// 		$("#world").html("อันนี้เป็นเนื้อหาใหม่นะ");
// 	});
// });

// $.ajax({
// 	url: '$urlServe',
// 	type: 'get',
// 	data: {
// 		requestByAjax: 1
// 	},
// 	dataType: 'json', //หรือ json หรือ xml
// 	success: function(response){
// 		$("btn").click(function(){
// 		$("#world").html(response.data);
// 	});
// 	}
// });

$.get("$urlServe", function(data1, status){
	$(document).ready(function() {
	$('#btn').click(function(){
		$("#world").html(data1);
	});
});
	// alert(data, '11111');
});

JS;
$this->registerJs($POS_HEAD, static::POS_HEAD);
?>

<div id="world">
	hello
</div>
<button id="btn">กดฉันที!</button>