<?php
/**
 * @demo_description: 将指定目录下树级 目录/文件 生成对应的树级array
 * */

$pathinfo = pathinfo($_SERVER['SCRIPT_FILENAME']);
define('ROOT',$pathinfo['dirname']);

$img_path = ROOT; // 指定目录
$img_root_name = 'icon'; // 根文件夹名字
$final_arr = array(); // 最终输出对应的arr

directory_tree_generator($img_path,$img_root_name,$final_arr);


function directory_tree_generator($img_path, $item, &$item_arr) {

    $directory_iterator = new DirectoryIterator("$img_path/$item");
	
	$file_arr = array(); // 保存读到的文件
	$directory_arr = array(); // 保存读到的目录
	
    foreach ($directory_iterator as $fileRow) {
        if ($fileRow->isDot()) continue;

        $filename = $fileRow->getFilename();

        if ($fileRow->isDir()){ // 文件夹处理
			$directory_arr[] = $filename;

        }else{ //文件处理
			$file_arr[] = $filename;
        }
    }

	$item_arr[$item] = array(); // 创建arr 防止空对象
	
	foreach($file_arr as $row){ // 遍历读到的文件并保存到数组
		$item_arr[$item][$row] = '';
	}
	
	foreach($directory_arr as $row){ // 遍历读到的文件夹 将文件夹往下层级递归
		$item_arr[$item][$row] = array();

		directory_tree_generator("$img_path/$item",$row,$item_arr[$item]);
	}

}

echo '<pre>';
print_r($final_arr);
