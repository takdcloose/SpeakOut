<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['post']) && isset($_POST['ans']) && isset($_POST['token'])){
    $ans = $_POST['ans'];
    $post = $_POST['post'];
    $salt = "stylishrealiwate";
    $show_id ="";
    if(hash('ripemd128',$salt.$post == $_POST['token'])){
        $sth = $db->prepare('SELECT * FROM userinfo where usermail=:usermail');
        $sth->bindParam(':usermail',$email_sess,PDO::PARAM_STR);
        $sth->execute();
        $name = $sth -> fetch(PDO::FETCH_ASSOC);
        $request = new PDO('mysql:host=sql;dbname=user_request', 'root', $_ENV['PASS']);
        if($ans == "no"){
            try{
                $delete = $request->prepare("DELETE FROM `".$name['username']."` WHERE username=:username");
                $delete->bindParam(':username',$post);
                $re = $delete->execute();
            }catch(Exception $e){
                $re = false;
            }

        }else{
            try{
                $insert = $request->prepare("INSERT INTO `".$post."` (`how`,`username`) VALUES (:how,:username)");
                $insert->bindValue(':how',"reply");
                $insert->bindParam(':username',$name['username']);
                $re1 = $insert->execute();
                $delete = $request->prepare("DELETE FROM `".$name['username']."` WHERE username=:username");
                $delete->bindParam(':username',$post);
                $re2 = $delete->execute();
                $get = $db->prepare("SELECT * FROM `userinfo` WHERE username=:username");
                $get->bindParam(':username',$post);
                $re3 = $get->execute();
                $phones = $get -> fetch(PDO::FETCH_ASSOC);
                $phone_op = unserialize($phones['phone']);
                $phone_i = unserialize($phones['phone_id']);
                $re = $re1 && $re2 && $re3;
                if($re){
                    for($i = 0 ; $i < sizeof($phone_op); $i++){
                        $text .= '<p class="b-keep uk-margin-remove">'.$phone_op[$i].': '.$phone_i[$r_list[$phone_op[$i]]].'</p>';
                    }
                    $show_id .='
                        <div class="uk-tile-default uk-margin-small uk-padding-small uk-box-shadow-small uk-box-shadow-hover-large"> 
                            <div class="uk-grid-match uk-text-center" uk-grid>
                                <div class="uk-width-1-4@m">
                                    <p>From: <a href="../'.$post.'/index.php" class="uk-margin" >'.$post.'</a></p>
                                </div>
                                <div class="uk-width-3-4@m">
                                    '.$text.'
                                </div>
                            </div>
                        </div>';
                }
            }catch(Exception $e){
                $re = false;
            }
            if(!$re){
                $show_id .= get_part('An error has occurred','エラーが発生しました');
            }
        }
    }else{
        $show_id .= get_part('An error has occurred','エラーが発生しました');
    }
    
}
?>
