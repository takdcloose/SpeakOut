<?php 
    function validate_set($email_sess,$username,$usermail,$userpassnow="",$userpass="",$userpassconfirm="",$phone_option,$phone_id){
        include_once("../../util/signup_check.php");
        include_once("../..//util/get_part_lang.php");
        $errors = array();
        global $db;
        $sth = $db->prepare("SELECT * FROM userinfo WHERE usermail = :usermail");
        $sth->bindParam(':usermail', $email_sess, PDO::PARAM_STR);
        $sth->execute();
        $row = $sth -> fetch(PDO::FETCH_ASSOC);
        if($userpassnow=="" && $userpass==""){
            $errors = validate_form($username,$row['sex'],$usermail,$row['userpass'],$row['userpass'],$phone_option,$phone_id);
            if($row['username'] == $username){
                unset($errors['user']);
            }
            if($row['usermail'] == $usermail){
                unset($errors['mail']);
            }
        }elseif($userpassnow != "" && $userpass!= ""){
            $errors = validate_form($username,$row['sex'],$usermail,$userpass,$userpassconfirm,$phone_option,$phone_id);
            if($row['userpass'] != hash('sha256',$userpassnow)){
                $errors['passerror']=get_part("Current password doesn't match",'現在のパスワードが異なります');
            }
            if($row['username'] == $username){
                unset($errors['user']);
            }
            if($row['usermail'] == $usermail){
                unset($errors['mail']);
            }
        }else{
            $errors['passno']=get_part('Please enter your current password or new password','現在のパスワード、または新しいパスワードを入力してください');
        }
        return $errors;
    }
    function process_set($email_sess,$username,$usermail,$userpass='',$phone_option,$phone_id,$comment){
        $db = new PDO('mysql:host=sql;dbname=User', 'root', $_ENV['PASS']);
        $re = false;
        try{
            #$sth = $db->prepare('UPDATE userinfo SET `username`=:username,`usermail`=:usermail,`userpass`=:userpass,`phone_option`=:phone_option,`phone_id`=:phone_id,`comment`=:comment) WHERE `usermail`=:mailnow');
            if($userpass==''){
                $sql = "UPDATE userinfo SET username = :username ,`usermail` = :usermail ,phone = :phone_option ,phone_id = :phone_id,comment = :comment WHERE usermail = :mailnow";
                $stmt = $db->prepare($sql);
            }else{
                $sql = "UPDATE userinfo SET username = :username ,`usermail` = :usermail ,userpass = :userpass ,phone = :phone_option ,phone_id = :phone_id,comment = :comment WHERE usermail = :mailnow";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':userpass',hash('sha256',$userpass));
            }
            $stmt->bindParam(':username',$username);
            $stmt->bindParam(':usermail',$usermail);
            $phone_seri = serialize($phone_option);
            $stmt->bindParam(':phone_option',$phone_seri);
            $phone_id_seri = serialize($phone_id);
            $stmt->bindParam(':phone_id',$phone_id_seri);
            $stmt->bindParam(':comment',$comment);
            $stmt->bindParam(':mailnow',$email_sess);
            $re = $stmt->execute();
            #print_r($stmt->errorInfo());
        }catch(Exception $e){
            $re = false;
        }
        return $re;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_FILES ['upfile']) && isset($_POST['profile'])){
        $username = $_POST['username'];
        $usermail = $_POST['usermail'];
        $userpassnow = $_POST['userpassnow'];
        $userpass = $_POST['userpass'];
        $userpassconfirm = $_POST['userpassconfirm'];
        $phone_option = $_POST['phone_option'];
        $phone_id = $_POST['phone_id'];
        if(is_array($phone_option)){
            for($i = 0 ; $i < $num ; $i++){
                if($phone_id[$i] == "" && in_array($list[$i],$phone_option)){
                    unset($phone_option[array_search($list[$i],$phone_option)]);
                }
                if($phone_id[$i] != "" && !in_array($list[$i],$phone_option)){
                    $phone_id[$i] = "";
                }
            }
        }else{
            for($i = 0 ; $i < $num; $i++){
                $phone_id[$i] = "";
            }
        }
        $comment = $_POST['comment'];
        $db = new PDO('mysql:host=sql;dbname=User', 'root', $_ENV['PASS']);
        $db->query('SETNAMES utf8'); 
        //if submited form is correct , proceed to excute. if not, show error.
        $form_errors = validate_set($email_sess,$username,$usermail,$userpassnow,$userpass,$userpassconfirm,$phone_option,$phone_id);
        if(!empty($form_errors)){
            $errors = show_form($form_errors);
        } else{
            $suc = process_set($email_sess,$username,$usermail,$userpass,$phone_option,$phone_id,$comment);
            #var_dump($suc);
            if($suc){
    
                $errors =  get_part("Completed","変更しました。");
                $_SESSION['EMAIL'] = $usermail;
                $salt = "okshjq9ajhiau47yai";
                $_SESSION['token'] = hash('ripemd128',$usermail.$salt.$_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR']);
                if($finduser != $username){
                    $_GET['user'] = $username;
                    rename("../".$finduser,"../".$username);
                    $db = new PDO('mysql:host=sql;dbname=user_request', 'root', $_ENV['PASS']);
                    $sql = 'RENAME TABLE '.$finduser.' TO ' . $username;
                    $db->query($sql);
                    $finduser = $username;
                    echo "<script> location.replace(\"../".$username."/index.php\"); </script>";
                }
            }else{
                $errors = get_part("Unknown error","不明なエラー");
            }
        }
    } else {
        //if form is not submited yet, show form
        $errors = show_form();
    }
?>