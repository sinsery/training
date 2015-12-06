<?php
/**
 * @demo_description: ��ָ��Ŀ¼�µ�ͼƬ�ļ� ���� base64 ��д��JS
 * @remark:

����JS�ļ���ʽ���� ��

	var base64_data = {};
	base64_data['csss/abds/abds/icon.png'] = 'data:image/png;base64,iVBORw0KGgoAAAA;';

key��ӦĿ¼ ��������Ŀ¼
htmlʹ�÷���
1. img��ǩ����data-base64data="csss/abds/abds/icon.png"
2. js��img��data-base64data
3. ������·������Ϊbase64_data��key ������Ӧ��ֵ

 * 
 * */

$pathinfo = pathinfo($_SERVER['SCRIPT_FILENAME']);
define('ROOT',$pathinfo['dirname']);

$img_path = ROOT; // ָ��Ŀ¼
$img_root_name = 'icon'; // ���ļ�������

$output_content = "var base64_data = {};\n";

directory_tree_generator($img_path,$img_root_name);


function directory_tree_generator($img_path, $item, $item_path = '') {
	global $output_content;

    $directory_iterator = new DirectoryIterator("$img_path/$item");
	
	$file_arr = array(); // ����������ļ�
	$directory_arr = array(); // ���������Ŀ¼
	
    foreach ($directory_iterator as $fileRow) {
        if ($fileRow->isDot()) continue;

        $filename = $fileRow->getFilename();

        if ($fileRow->isDir()){ // �ļ��д���
			$directory_arr[] = $filename;

        }else{ //�ļ�����
			$file_arr[] = $filename;
        }
    }
	
	foreach($file_arr as $row){ // �����������ļ������浽����
	
		$pathinfo = pathinfo($row);

		//�ж��ļ����� ����ֻ���� png jpg gif�ļ�����base64
		if($pathinfo['extension'] !== 'png' && $pathinfo['extension'] !== 'jpg' &&
		$pathinfo['extension'] !== 'gif'){
			continue;
		}
	
		
		$key = $item_path !== '' ? "$item_path/$item/$row" : $row;
		
		$temp_base64_data = base64_encode(file_get_contents("$img_path/$item/$row"));
		$output_content .= "base64_data['{$key}'] = 'data:image/{$pathinfo['extension']};base64,{$temp_base64_data}';\n";
		//echo $temp_base64_data;
	}
	
	foreach($directory_arr as $row){ // �����������ļ��� ���ļ������²㼶�ݹ�
 
		directory_tree_generator("$img_path/$item",$row,$item_path?"$item_path/$row":$row);
	}

}

$file_icon_base64 = fopen("icon_base64.js", "w");
fwrite($file_icon_base64, $output_content);
fclose($file_icon_base64);

