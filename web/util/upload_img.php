<?php
function upload_image($finduser){
    $msg = null;
    if (isset ( $_FILES ['upfile'] ) && is_uploaded_file ( $_FILES ['upfile']['tmp_name'] )) {
        $old_name = $_FILES ['upfile'] ['tmp_name'];
        $new_name = date ( "YmdHis" );
        $new_name .= mt_rand ();
        list($img_width, $img_height, $mime_type, $attr) = getimagesize($_FILES ['upfile']['tmp_name']);
        switch ($mime_type) {
            case IMAGETYPE_JPEG :
                $original_image = imagecreatefromjpeg($_FILES ['upfile']['tmp_name']);
                $new_name .= '.jpg';
                break;
            case IMAGETYPE_PNG :
                $original_image = imagecreatefrompng($_FILES ['upfile']['tmp_name']);
                $new_name .= '.png';
                break;
            default :
                $msg = get_part("Only JPG or PNG images can be uploaded.","JPGイメージまたはPNGイメージのみアップロードできます。");
                return $msg;
        }
        $resize_path = './img/'.$new_name;
        $gazou = basename ( $_FILES ['upfile'] ['name'] );
        $images= glob('./img/*');
        for($i=0 ; $i < sizeof($images) ; $i++){
            if($images[$i] != "./img/".$new_name){
                if(unlink($images[$i])){
                    if (move_uploaded_file ( $old_name, './img/'. $new_name )) {
                        $width = 90;
                        $height = 90;
                        $canvas = imagecreatetruecolor($width, $height);
                        imagecopyresized($canvas,$original_image , 0, 0, 0, 0, $width, $height, $img_width, $img_height);
                        switch ($mime_type) {
                            case IMAGETYPE_JPEG:
                                imagejpeg($canvas, $resize_path);
                                break;
                            case IMAGETYPE_PNG:
                                imagepng($canvas, $resize_path, 9);
                                break;
                            }
                        unset($canvas);
                        unset($original_image);
                        $msg = $gazou . get_part('is uploaded','のアップロードに成功しました');
                    }else {
                        $msg = get_part('Failed to upload','アップロードに失敗しました');
                    }
                }else{
                    $msg = get_part('Failed to upload','アップロードに失敗しました');
                }
            }
        }
        return $msg;
    }
}