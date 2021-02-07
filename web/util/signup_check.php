<?php
    function show_form($errors = ''){
        if(is_array($errors)){
            $error_text = '<tr><td>You need to correct the following errors:';
            $error_text .= '<tr><td><ul><li class="uk-text-danger">';
            $error_text .= implode('</li><li class="uk-text-danger">',$errors);
            $error_text .= '</li></ul></td></tr>';
        } else {
            $error_text = '';
        }
        return $error_text;
    }

    function validate_form($username,$sex,$usermail,$userpass,$userconfirmpass,$phone_option,$phone_id){
        $errors = array();
        #include("get_part_lang.php");
        if(!isset($username,$sex,$usermail,$userpass)){ //make sure these parameter are not empty
            $errors['nothing']= get_part('Some fields are not filled','記入していない箇所があります');
        }
        $set_other = false;
        if(is_array($phone_option)){
            for($i = 0 ; $i <sizeof($phone_option) ; $i++){
                if($phone_option[$i] == "other"){
                    $set_other = true;
                }
            }
        }
        $set_id = false;
        for($i = 0 ;$i < sizeof($phone_id) ; $i++){
            if($phone_id[$i] != ""){
                $set_id = true;
            }
        }
        if(!$set_id && !$set_other){
            $errors['id']=get_part('Please input ID','IDを入力してください');
        }
        global $db;
        $sth = $db->prepare("SELECT COUNT(*) FROM userinfo WHERE username = :username");
        $sth->bindParam(':username', $username, PDO::PARAM_STR);
        $sth->execute();
        $aryList = $sth -> fetchAll(PDO::FETCH_ASSOC);
        if($aryList[0]["COUNT(*)"] != 0){
            $errors['user']=get_part('The username has been already used','ユーザー名が既に使用されています。');
        }
        $sth = $db->prepare("SELECT COUNT(*) FROM userinfo WHERE usermail = :usermail");
        $sth->bindParam(':usermail', $usermail, PDO::PARAM_STR);
        $sth->execute();
        $aryList = $sth -> fetchAll(PDO::FETCH_ASSOC);
        if($aryList[0]["COUNT(*)"] != 0){
            $errors['mail']= get_part('The mail address has been already used','メールアドレスが既に使用されています。');
        }
        if(preg_match('/\A[[:^cntrl:]]{1,100}\z/u',$username) !== 1){
            $errors['str_username']= get_part("Your username contains invalid characters.",'ユーザーネームに不正な文字が含まれています');
        }
        if(preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/',$usermail) !== 1){
            $errors['str_mail']= get_part("Your mail address contains invalid characters.",'メールアドレスに不正な文字が含まれています');
        }
        if(preg_match('/\A[[:^cntrl:]]{1,100}\z/u',$userpass) !== 1){
            $errors['str_pass']= get_part("Your password contains invalid characters.",'パスワードに不正な文字が含まれています');
            
        }
        if($userpass != $userconfirmpass){
            $errors['nomatch']= get_part("Password doesn't match.",'パスワードが一致しません.');
        }
        return $errors;
    }
    function process_form($username,$sex,$age,$usermail,$userpass,$phone_option,$phone_id,$comment){
        //$_SESSION['data'] = ['name'=>$username,'mail'=>$usermail,'pass'=>$userpass];
        global $db;
        $re = false;
        try{
            $sth = $db->prepare('INSERT INTO userinfo (username,sex,age,usermail,userpass,phone,phone_id,comment) VALUES (:username,:sex,:age,:usermail,:userpass,:phone_option,:phone_id,:comment)');
            $sth->bindParam(':username', $username, PDO::PARAM_STR);
            $sth->bindParam(':sex', $sex, PDO::PARAM_STR);
            $sth->bindParam(':age', $age, PDO::PARAM_STR);
            $sth->bindParam(':usermail', $usermail, PDO::PARAM_STR);
            $sth->bindParam(':userpass', hash('sha256',$userpass), PDO::PARAM_STR);
            $phone_seri = serialize($phone_option);
            $sth->bindParam(':phone_option', $phone_seri, PDO::PARAM_STR);
            $phone_id_seri = serialize($phone_id);
            $sth->bindParam(':phone_id', $phone_id_seri, PDO::PARAM_STR);
            $sth->bindParam(':comment', $comment, PDO::PARAM_STR);
            $re = $sth->execute();
            $db = new PDO('mysql:host=sql;dbname=user_request', 'root', $_ENV['PASS']);
            $sql = 'CREATE TABLE '.$username.'( `id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT ,`how` VARCHAR(5) NOT NULL ,`username` VARCHAR(100) NOT NULL , `usermail` VARCHAR(100) , `starttime` VARCHAR(50) , `comment` VARCHAR(100)  ,PRIMARY KEY (`id`)) ENGINE = InnoDB;';
            $re = $db->query($sql);
        }catch(Exception $e){
            echo "error";
            $suc = false;
        }
        return $re;
    }
?>
