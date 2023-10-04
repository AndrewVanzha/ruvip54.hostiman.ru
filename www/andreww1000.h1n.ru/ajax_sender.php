<?php
require($_SERVER['DOCUMENT_ROOT'].'/config.php');

if(isset($_POST) && isset($_FILES) && $_POST["upload"]=='yes') {
    $uploadDir = $path_to_upload . $upload_dir;

    if(!is_dir($uploadDir)) {
        if(!mkdir($uploadDir, 0777)) {
            die(json_encode($arrErrors['err_create_dir']));
        }
    }
    
    $num_files = count($_FILES["load_file"]["name"]);
    $num_files = ($num_files > 5)? 5 : $num_files;
    if($num_files == 0 || empty($_FILES["load_file"]["name"])) {
        die(json_encode($arrErrors['err_files_transmitted']));
    }

    if($_FILES["load_file"]["error"][0] == UPLOAD_ERR_NO_FILE) {
        die(json_encode($arrErrors['err_no_files']));
    } else {
        for($i=0; $i<$num_files; $i++) {
            if($_FILES["load_file"]["error"][$i] > 0) {
                $arFilesList[$i] = $arrErrors['err_file_upload'] . $_FILES["load_file"]["name"][$i];
                continue;
            }
            //$cond_type = explode('/', mime_content_type($_FILES["load_file"]["tmp_name"][$i]))[0] == $arrSettings['file_type'] && mime_content_type($_FILES["load_file"]["tmp_name"][$i]) != $arrSettings['file_type_bmp'];
            $cond_type = in_array(mime_content_type($_FILES["load_file"]["tmp_name"][$i]), $arrFileTypes);
            if(!$cond_type) {
                $arFilesList[$i] = $i+1 . '. ' . $arrErrors['err_file_type'] . $_FILES["load_file"]["name"][$i];
                continue;
            }
            $cond_size = $_FILES["load_file"]["size"][$i] < $arrSettings['max_file_size'];
            if(!$cond_size) {
                $arFilesList[$i] = $i+1 . '. ' . $arrErrors['err_file_size'] . $_FILES["load_file"]["name"][$i];
                continue;
            }
            if(move_uploaded_file($_FILES["load_file"]["tmp_name"][$i], $uploadDir.rawurlencode($_FILES["load_file"]["name"][$i]))) {
                $arFilesList[$i] = $i+1 . '. Файл ' . $_FILES["load_file"]["name"][$i] . ' перемещен';
            } else {
                $arFilesList[$i] = $i+1 . '. Ошибка перемещения файла ' . $_FILES["load_file"]["name"][$i];
            }
        }
        echo json_encode($arFilesList);
    }

}
