<?php
/* 递归数组方法 */
function makefc($arr){
	foreach($arr as $key=>$value){
		if(is_array($value)){
			$value=makefc($value);
			$arr[$key] =$value;
		}else{
			$arr[$key] =handle($value);
		}
	}
	return $arr;
}
/* 处理值方法 */
function handle($value){
	$value=strtoupper($value);
	return $value;
}

/* 测试数据 */
$testDataArr=['ccs','asf','csdd'];
$testDataArr1=['qq','xx'=>$testDataArr,'csdd'];
$testDataArr2=['aa','bb' => $testDataArr1,'casd'];

print_r(makefc($testDataArr3));