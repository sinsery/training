<?php
/**
 * @demo_description: ��ָ��Ŀ¼������ Ŀ¼/�ļ� ���ɶ�Ӧ������array
 * */

$pathinfo = pathinfo($_SERVER['SCRIPT_FILENAME']);
define('ROOT',$pathinfo['dirname']);

$img_path = ROOT; // ָ��Ŀ¼
$img_root_name = 'icon'; // ���ļ�������
$final_arr = array(); // ���������Ӧ��arr

directory_tree_generator($img_path,$img_root_name,$final_arr);


function directory_tree_generator($img_path, $item, &$item_arr) {

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

	$item_arr[$item] = array(); // ����arr ��ֹ�ն���
	
	foreach($file_arr as $row){ // �����������ļ������浽����
		$item_arr[$item][$row] = '';
	}
	
	foreach($directory_arr as $row){ // �����������ļ��� ���ļ������²㼶�ݹ�
		$item_arr[$item][$row] = array();

		directory_tree_generator("$img_path/$item",$row,$item_arr[$item]);
	}

}

echo '<pre>';
print_r($final_arr);
