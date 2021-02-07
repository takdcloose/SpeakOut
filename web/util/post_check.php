<?php
    function check_post($time,$theme,$video,$my_lang,$your_lang,$other){
        include("./util/get_part_lang.php");
        $errors = array();
        if(!isset($time,$video) || $my_lang == "" || $your_lang == ""){
            array_push($errors,get_part("Some fields are not filled","入力されていない箇所があります。"));
        }else{
            $now = new DateTimeImmutable();
            $nextweek = $now->modify('+1 week');
            $nextweek->format('Y-m-d');
            $date = new DateTimeImmutable($time);
            $interval = $date->diff($nextweek);
            $invert = (int)$interval ->invert;
            $interval_day = (int)$interval->format('%d');
            if ($invert == 1){
                $interval_day = -$interval_day;
            }
            if ($interval_day > 7 || $interval_day < 0){
                array_push($errors,get_part("You must set the start time within 1 week from now","開始可能時間は現在から一週間以内で指定してください"));
            }
            if(preg_match('/\A[\r\n\t[:^cntrl:]]{0,300}\z/u',$other) !== 1){
                array_push($errors,get_part("Your comment contains invalid characters or the character limit (300 characters) has been exceeded.",'コメントに不正な文字が含まれている,又は文字制限(300文字)を超えています。'));
            }
            if(preg_match('/\A[[:^cntrl:]]{0,100}\z/u',$theme) !== 1){
                array_push($errors,get_part("Your theme contains invalid characters or the character limit (100 characters) has been exceeded.",'テーマに不正な文字が含まれている,又は文字制限(100文字)を超えています。'));
            }
        }
        
        return $errors;
    }

    function post_thread($username,$starttime,$theme,$video,$my_lang,$your_lang,$other){
        global $db;
        $re = false;
        try{
            $sth = $db->prepare('INSERT INTO bulletin (username,starttime,theme,video,mylang,yourlang,other) VALUES (:username,:starttime,:theme,:video,:mylang,:yourlang,:other)');
            #$sth->bindParam(':id', $id, PDO::PARAM_INT);
            $sth->bindParam(':username', $username, PDO::PARAM_STR);
            $sth->bindParam(':starttime', $starttime, PDO::PARAM_STR);
            $sth->bindParam(':theme', $theme, PDO::PARAM_STR);
            $sth->bindParam(':video', $video, PDO::PARAM_STR);
            $sth->bindParam(':mylang', $my_lang, PDO::PARAM_STR);
            $sth->bindParam(':yourlang', $your_lang, PDO::PARAM_STR);
            $sth->bindParam(':other', $other, PDO::PARAM_STR);
            $re = $sth->execute();
        }catch(Exception $e){
            $re = false;
        }
        return $re;
    }

    function make_post($row){
        $files= glob('./users/'.$row['username'].'/img/*');
        include("./util/get_part_lang.php");
        $text = '
        <div>
            <div class="uk-card uk-card-default uk-card-hover uk-margin-bottom uk-margin-auto-right">
                <div class="uk-card-header uk-padding-small">
                    <div class="uk-grid-small uk-flex-middle" uk-grid>
                        <div class="uk-width-auto">
                            <img class="uk-border-circle" width="90" height="90" src="'. $files[0] .'">
                        </div>
                        <div class="uk-width-expand">
                            <h3 class="uk-card-title uk-margin-remove-bottom"><a href="users/'.htmlspecialchars($row['username'],ENT_NOQUOTES,'UTF-8').'/index.php" class="uk-margin uk-text-bolder" >'.$row['username'].'</a></h3>
                            <div class="uk-text-meta uk-margin-remove-top"><span uk-icon="user"></span>'.get_part('Poster','投稿者').':'.htmlspecialchars($row['mylang'],ENT_NOQUOTES,'UTF-8').'</div>
                            <div class="uk-text-meta uk-margin-remove-top"><span uk-icon="users"></span>'.get_part('Partner','相手').':'.htmlspecialchars($row['yourlang'],ENT_NOQUOTES,'UTF-8').'</div>
                        </div>
                    </div>
                </div>
                
                <div class="uk-card-body uk-padding-remove-bottom">
                    <div class="">
                        <span class="uk-text-meta">'.get_part('theme','テーマ').': </span>
                        <span class="uk-">' .htmlspecialchars($row['theme'],ENT_NOQUOTES,'UTF-8').'</span>
                    </div>
                    <div class="">
                        <span class="uk-text-meta">'.get_part('Start tine (UTC)','開始時間(UTC)').': </span>
                        <div class="uk-">' .htmlspecialchars( str_replace("T"," ",$row['starttime']) ,ENT_NOQUOTES,'UTF-8').'</div>
                    </div>
                    <div>
                        <div><span class="uk-text-meta">'.get_part('Video call','ビデオ通話').': </span><span>' .$row['video'] .'</span></div>
                    </div>
                    <div class="uk-text-center uk-margin-small-bottom uk-margin-small-top">
                        <form action="confirm.php" method="POST">
                            <input type="hidden" name="post_id" value="'.$row['id'].'">
                            <input class="uk-label uk-button uk-button-default uk-margin-remove-left uk-margin-remove-right" type="submit" value="request">
                        </form>  
                    </div>
                </div>
                <div class="uk-card-footer">
                    <p class="uk-text-meta">comment</p>
                    <div class="uk-text-center">
                    '.htmlspecialchars($row['other'],ENT_NOQUOTES,'UTF-8').'
                    </div>
                </div>
            </div>
        </div>';
        return $text;
    }
?>