<?php
/**
 * @demo_description: 对指定目录下的图片文件 生成 base64 并写入JS
 * @remark:

生成JS文件格式如下 ：

	var base64_data = {};
	base64_data['csss/abds/abds/icon.png'] = 'data:image/png;base64,iVBORw0KGgoAAAA;';

key对应目录 不包括根目录
html使用方法
1. img标签设置data-base64data="csss/abds/abds/icon.png"
2. js读img的data-base64data
3. 读到的路径来作为base64_data的key 读出对应的值

 * 
 * */

$pathinfo = pathinfo($_SERVER['SCRIPT_FILENAME']);
define('ROOT',$pathinfo['dirname']);

$img_path = ROOT; // 指定目录
$img_root_name = 'icon'; // 根文件夹名字

$output_content = "var base64_data = {};\n";

directory_tree_generator($img_path,$img_root_name);


function directory_tree_generator($img_path, $item, $item_path = '') {
	global $output_content;

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
	
	foreach($file_arr as $row){ // 遍历读到的文件并保存到数组
	
		$pathinfo = pathinfo($row);

		//判断文件类型 这里只允许 png jpg gif文件生成base64
		if($pathinfo['extension'] !== 'png' && $pathinfo['extension'] !== 'jpg' &&
		$pathinfo['extension'] !== 'gif'){
			continue;
		}
	
		
		$key = $item_path !== '' ? "$item_path/$item/$row" : $row;
		
		$temp_base64_data = base64_encode(file_get_contents("$img_path/$item/$row"));
		$output_content .= "base64_data['{$key}'] = 'data:image/{$pathinfo['extension']};base64,{$temp_base64_data}';\n";
		//echo $temp_base64_data;
	}
	
	foreach($directory_arr as $row){ // 遍历读到的文件夹 将文件夹往下层级递归
 
		directory_tree_generator("$img_path/$item",$row,$item_path?"$item_path/$row":$row);
	}

}

$file_icon_base64 = fopen("icon_base64.js", "w");
fwrite($file_icon_base64, $output_content);
fclose($file_icon_base64);

