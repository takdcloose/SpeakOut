<?php
function show_request($name){
    $request = new PDO('mysql:host=sql;dbname=user_request', 'root', $_ENV['PASS']);
    $sth = $request->prepare('SELECT * FROM '.$name); // person who receives a request
    $sth->execute();
    $person = $sth -> fetchAll(PDO::FETCH_ASSOC); //$person['username']  person who sends a request
    $salt = "stylishrealiwate";
    if(sizeof($person) == 0){
        $msg = get_part("There is no request yet","リクエストはありません");
    }else{
        for($i =0 ; $i <sizeof($person) ;$i++){
            if($person[$i]['how'] == "req"){
                $msg .='
                <div class="uk-tile-default uk-margin-small uk-padding-small uk-box-shadow-small uk-box-shadow-hover-large"> 
                    <div class="uk-grid-match uk-text-center" uk-grid>
                        <div class="uk-width-1-4@m">
                            <p>From: <a href="../'.$person[$i]['username'].'/index.php" class="uk-margin" >'.htmlspecialchars($person[$i]['username'],ENT_NOQUOTES,'UTF-8').'</a></p>
                        </div>
                        <div class="uk-width-1-2@m">
                            <p class="b-keep">
                                '.htmlspecialchars($person[$i]['comment'],ENT_NOQUOTES,'UTF-8').'
                            </p>
                        </div>
                        <div class="uk-width-1-4@m">
                                <form action="index.php" method="POST">
                                    <input type="hidden" name="ans" value="yes">
                                    <input type="hidden" name="post" value="'.htmlspecialchars($person[$i]['username'],ENT_NOQUOTES,'UTF-8').'">
                                    <input type="hidden" name="token" value="'.hash('ripemd128',$salt.$person[$i]['username']).'">
                                    <input class="uk-button uk-button-default uk-button-small uk-margin-small-bottom" type="submit" value="'.get_part("Accept","承認").'">
                                </form>
                                <form action="index.php" method="POST">
                                    <input type="hidden" name="ans" value="no">
                                    <input type="hidden" name="post" value="'.htmlspecialchars($person[$i]['username'],ENT_NOQUOTES,'UTF-8').'">
                                    <input type="hidden" name="token" value="'.hash('ripemd128',$salt.$person[$i]['username']).'">
                                    <input class="uk-button uk-button-default uk-button-small" type="submit" value="'.get_part('Reject','却下').'">
                                </form>
                        </div>
                    </div>
                </div>';
            }else{
                $r_list = array("Skype"=>0,"Line"=>1,"Viber"=>2,"KaKaoTalk"=>3,"Messenger"=>4,"Discord"=>5);
                $db = new PDO('mysql:host=sql;dbname=User', 'root', $_ENV['PASS']);
                $request = new PDO('mysql:host=sql;dbname=user_request', 'root', $_ENV['PASS']);
                $get = $db->prepare("SELECT * FROM `userinfo` WHERE username=:username");
                $get->bindParam(':username',$person[$i]['username']);
                $re = $get->execute();
                $delete = $request->prepare("DELETE FROM `".$name."` WHERE username=:username");
                $delete->bindParam(':username',$person[$i]['username']);
                $re2 = $delete->execute();
                $phones = $get -> fetch(PDO::FETCH_ASSOC);
                $phone_op = unserialize($phones['phone']);
                $phone_i = unserialize($phones['phone_id']);
                $from = $person[$i]['username'];
                if($re && $re2){
                    for($i = 0 ; $i < sizeof($phone_op); $i++){
                        $text .= '<p class="b-keep uk-margin-remove">'.htmlspecialchars($phone_op[$i],ENT_NOQUOTES,'UTF-8').': '.$phone_i[$r_list[$phone_op[$i]]].'</p>';
                    }
                    $msg .='
                        <div class="uk-tile-default uk-margin-small uk-padding-small uk-box-shadow-small uk-box-shadow-hover-large"> 
                            <div class="uk-grid-match uk-text-center" uk-grid>
                                <div class="uk-width-1-4@m">
                                    <p>From: <a href="../'.$from. '/index.php" class="uk-margin" >'.$from.'</a></p>
                                </div>
                                <div class="uk-width-3-4@m">
                                    '.$text.'
                                </div>
                            </div>
                        </div>';
                }
            }
        }
    }
    return $msg;
}
?>
