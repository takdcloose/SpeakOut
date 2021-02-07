<?php
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['lan'])){
    if($_POST['lan'] == 'en'){
        $_SESSION['lan'] = 'en';
        $c_language = "日本語";
        $language = 'ja';
    }elseif($_POST['lan'] == 'ja'){
        $_SESSION['lan'] = 'ja';
        $c_language = "English";
        $language = "en";
    }
}
$lan = $_SESSION['lan'];
if(is_null($lan)){$_SESSION['lan'] = "en";}
$lan = $_SESSION['lan'];
if($lan == "ja"){
    $top = "トップページ";
    $c_language = "English";
    $language = "en";
    $bulletin = "掲示板";
    $logout = "ログアウト";
    $login_s = "ログイン";
    $mypage = "マイページ";
    if($_SERVER['PHP_SELF'] == '/top.php'|| $_SERVER['PHP_SELF'] == '/'){
        $thissite = "Speakoutは<span class=\"uk-text-danger\">完全無料</span>で外国語のスピーキング能力を向上させるためのサイトです。";
        $speakout1 = "言語学習を目的とした掲示板サイトです";
        $speakout2 = "お互いが話す言語を指定して通話することでスピークング力を向上させます";
        $speakout3 = "お互いの母国語を指定したり、同じ母国語話者同士で外国語を使って話したりなど使い方は様々です";
        $speakout4 = "相手が見つかったら外部の通話サービスを利用してレッスンを開始します";
        $rule5title = "外国語学習の5つの鉄則";
        $rule5explain = "ニュージーランドの哲学者chris lonsdaleさんは外国語を効率よく学習するのに5つの鉄則があると言います";
        $rule1 = "あなたに深く関係する言語を学ぶ";
        $rule1ex = "その言語があなたに必要であればあるほど習得が早くなります。その言語に意味と重要性を見出しましょう。";
        $rule2 = "言語を道具として学ぶ";
        $rule2ex = "なんの目的もなしに言語を勉強したり試験に受かるために勉強するのは悪くはないですが非効率です。言語はコミニケーションのツールであるということを意識して勉強しましょう。";
        $rule3 = "リラックスして学ぶ";
        $rule3ex = "楽しく、リラックスし脳からα波が出ると言語の習得を早めます。聞き取れなったりうまく喋れなくてもイライラしたり不安がらずに寛容な心で前に進みましょう。";
        $rule4 = "伝達内容を前もって理解して学習する";
        $rule4ex = "「理解によるインプット」と言われるもので、伝達内容を前もって理解していれば無意識のうちに身に付くというものです。是非話をするときは前もってテーマを決めてみてください。";
        $rule5 = "肉体的なトレーニング";
        $rule5ex = "言語を読んだり書いたりするだけでは実践的なコミュニケーションは取ることは出来ません。顔の43個の筋肉を使って他人が理解できる音を作ってください、そうすればあなたのリスニング能力も上がるでしょう。";
        $whyfree = "なぜ完全無料??";
        $reason1 = "利用者が外国語を学ぶと同時に教師となることでGive and Takeの関係が生まれるので授業料は発生しません！";
        $reason2 = "このサイトはWebサイト、ネットワークの勉強のために作成したサイトなので利益化はしません！";
        $reason3 = "(今のところは)サーバーを無料で管理出来ているためサーバー費が掛かりません！";
        $reason4 = "(今のところは)広告などを出してないので広告費が掛かりません！！";
        $notice = "管理人からのお知らせ";
        $notice1 = "このサイトは勉強のために作成したサイトのため予告なくアップデートしたり利用者に迷惑をかける場合があります。ご了承ください。";
        $notice2 = "問合せなどは speakout.lang@gmail.com へお願いします。";
        $alert = "注意";
        $alert1 = "このサイトで知り合った人とのトラブルは一切責任を負いません";
        $alert2 = "出会い目的の利用はお止めください";
        $alert3 = "掲示板への見た人が不快になるような内容の投稿を禁止します";
        $alert4 = "その他不適切であると判断した投稿を発見した場合はアカウントの削除となる可能性があります";
    }elseif($_SERVER['PHP_SELF'] == '/bulletin.php' ){
        $bulletin = "掲示板";
        $post = "投稿する";
        $video_on = "ビデオ通話あり";
        $video_off = "ビデオ通話なし";
        $usersearch = "ユーザー検索";
        $search = "検索";
        $poster = "投稿者";
        $partner = "相手";
    }elseif($_SERVER['PHP_SELF'] == '/login.php' ){
        $login_button = "ログイン";
        $no_account = "アカウントをお持ちでない方は<a class=\"uk-text-primary\" href=\"create_account.php\">こちら</a>から新規登録をお願いします。";
    }elseif($_SERVER['PHP_SELF'] == '/create_account.php'){
        $createaccount = "アカウント作成";
        $username_in = "ユーザーネーム(英数字)";
        $sex_age = "性別・年齢";
        $sex_label = '
        <label><input class="uk-radio" id ="man" type="radio" value="man" name="sex" checked>男性</label>
        <label><input class="uk-radio" id="woman" type="radio" value="woman" name="sex">女性</label>
        <label><input class="uk-radio" id="other" type="radio" value="other" name="sex">その他</label>
        ';
        $age_range = '
        <option value="">指定なし</option>
        <option value="10-">10歳未満</option>
        <option value="10-15">10~15歳</option>
        <option value="16-20">16~20歳</option>
        <option value="21-25">21~25歳</option>
        <option value="26-30">26~30歳</option>
        <option value="31-35">31~35歳</option>
        <option value="36-40">36~40歳</option>
        <option value="41-45">41~45歳</option>
        <option value="46-50">46~50歳</option>
        <option value="51-55">51~55歳</option>
        <option value="56-60">56~60歳</option>
        <option value="61-65">61~65歳</option>
        <option value="65+">65歳超</option>
        ';
        $mailaddress = "メールアドレス";
        $password = "パスワード";
        $confirm_password = "パスワード確認";
        $ableservice = "使用可能な通話サービス(一つ以上,複数選択可能)";
        $ID_video = "各種サービスのID";
        $comment_input = "コメント";
        $confirm = "確定";
    }elseif($_SERVER['PHP_SELF'] == '/post.php' ){
        $bulletin_board = "掲示板";
        $post_notice1 = "・開始可能時間は現時点から一週間以内で設定可能です。";
        $post_notice2 = "・開始可能時間はUTC(協定世界時)を指定してください。日本の場合日本時間の-9時間です。";
        $post_notice3 = "・投稿は開始可能時間の3時間後に自動的に削除されます。";
        $starttime_string = "開始可能時間";
        $theme_on = "話したい事(テーマ)";
        $video_call = "ビデオ通話";
        $video_choice = '
        <label><input type="radio" name="video" value="Yes">可</label>
        <label><input type="radio" name="video" value="No">不可</label>
        ';
        $youspeak = "自分が話す言語";
        $partnerspeak = "相手が話す言語";
        $otherthing = "備考";
        $post_it = "投稿";
    }elseif($_SERVER['PHP_SELF'] == '/confirm.php' || $_SERVER['PHP_SELF'] == '/confirm'){
        $confirm_req = "リクエスト確認";
        $start = "時間(UTC)";
        $theme = "テーマ";
        $video_call = "ビデオ通話";
        $poster_lang = "投稿者が話す言語";
        $your_lang ="あなたが話す言語";
        $comment = "コメント";
        $back = "前に戻る";
        $REQUEST = "リクエスト";
    }elseif($_SERVER['PHP_SELF'] == '/request.php' || $_SERVER['PHP_SELF'] == '/requests'){
        $send_request = "リクエストを送信しました！";
        $error_send = "エラーが発生しました。もう一度リクエストを送信してください。";
        $bulletin = "掲示板";
    }elseif($_SERVER['PHP_SELF'] == '/index.php' || explode("/",$_SERVER['PHP_SELF'])[3] == 'index.php' ){
        $notification = "お知らせ";
        $profile_tab = "プロフィール";
        $request_list = "リクエスト一覧";
        $caution_request = "注意事項";
        $caution1 = "リクエストを承認すると相手の通話IDが表示されます。一度ページを離れると消えるのでご注意ください。";
        $caution2 = "リクエストを承認すると登録した通話IDが相手に送信されます。公開したくないIDがある場合は一度登録解除してからリクエストを承認してください。";
        $caution3 = "リクエストを却下した場合は相手には通知はされません。";
        $caution4 = "相手からリクエストが承認された場合ここに相手の通話IDが表示されます。";
        $uppicture = "アップロード";
        $username_pro = "ユーザーネーム";
        $mailaddress_pro = "メールアドレス";
        $current_pass = "現在のパスワード";
        $new_pass = "新しいパスワード";
        $confirm_new_pass = "新しいパスワード確認";
        $availableserv = "使用可能な通話サービス(一つ以上,複数選択可能)";
        $ID_serv = "各種サービスのID";
        $comment_pro = "コメント";
        $change = "変更する";
        $availableservice = "使用可能のサービス";
    }



}elseif($lan == "en"){
    $top = "top";
    $c_language = "日本語";
    $language= "ja";
    $bulletin = "bulletin";
    $logout = "logout";
    $login_s = "login";
    $mypage = "mypage";
    if($_SERVER['PHP_SELF'] == '/top.php'|| $_SERVER['PHP_SELF'] == '/'){
        $thissite = '"Speakout" is a site for improving your speaking ability for <span class=\'uk-text-danger\'>completely free!</span>';
        $speakout1 = "This is a bulletin board site for language learners";
        $speakout2 = "You can improve your speaking ability by speaking each other's native language";
        $speakout3 = "There are various ways to use this, such as speaking each other's native language, or speaking foreign language with the same native speakers.";
        $speakout4 = "You can start a lesson using an external calling service when the conversation partner is found";
        $rule5title = "5 rules for learning foreign languages";
        $rule5explain = "New Zealand philosopher, chris lonsdale , says there are five rules for learning foreign languages ​​efficiently and easily";
        $rule1 = "Focus on language content that is relevant to you";
        $rule1ex = "The more you need that language, the faster you learn. Find out the meaning and importance of that language.";
        $rule2 = "Use your new language as a tool to communicate";
        $rule2ex = "Studying a language to take an exam is not bad, but inefficient.Be aware that language is a communication tool";
        $rule3 = "Psycho-physiological state matters";
        $rule3ex = "If you're happy and relaxed in an Alpha brain state, you can learn really quickly. Even if you can't hear or speak well, you should move on with a generous heart without being frustrated or anxious";
        $rule4 = "Understand the subject of conversation in advance";
        $rule4ex = "This is called 'comprehensible input'. When you first understand the message, you will acquire the language unconsciously. You should decide on a theme before you talk.";
        $rule5 = "Physiological training";
        $rule5ex = "Only reading and writing languages are not enough to communicate pratically. Pronounce properly using the 43 muscles of your face, and your listening skills will also improve.";
        $whyfree = "Why is this completely free??";
        $reason1 = "Don't need to pay tuition fees because a student learns a foreign language and at the same time becomes a teacher, building a Give-and-Take relationship!";
        $reason2 = "This site is created for studying websites and networks, so it will not be profitable!";
        $reason3 = "I can manage this server for free, so there is no server cost!(so far)";
        $reason4 = "There is no advertising, so no advertising costs!(so far)";
        $notice = "Notice from manager";
        $notice1 = "This site is created for studying so may be updated without notice. I hope you will understand this";
        $notice2 = "Please send a mail to 'speakout.lang@gmail.com' for any inquiries";
        $alert = "Cautions";
        $alert1 = "I do not take any responsibility for any troubles with people you get to know on this site";
        $alert2 = "Please do not use this site for meeting in real life";
        $alert3 = "Do not post to the bulletin board that makes viewers uncomfortable";
        $alert4 = "If I find other posts that I consider it inappropriate, it's possible that the account will be deleted";
    }elseif($_SERVER['PHP_SELF'] == '/bulletin.php' ){
        $bulletin = "Bulletin";
        $post = "POST";
        $video_on = "Video call";
        $video_off = "No video call";
        $usersearch = "User Search...";
        $search = "Search";
        $poster = "Poster";
        $partner = "Parter";
    }elseif($_SERVER['PHP_SELF'] == '/login.php' ){
        $login_button = "login";
        $no_account = "If you don't have an account, please register <a class=\"uk-text-primary\" href=\"create_account.php\">here</a>";
    }elseif($_SERVER['PHP_SELF'] == '/create_account.php' ){
        $createaccount = "Create Account";
        $username_in = "Username (alphanumeric)";
        $sex_age = "Sex・Age";
        $sex_label = '
        <label><input class="uk-radio" id ="man" type="radio" value="man" name="sex" checked>male</label>
        <label><input class="uk-radio" id="woman" type="radio" value="woman" name="sex">female</label>
        <label><input class="uk-radio" id="other" type="radio" value="other" name="sex">other</label>
        ';
        $age_range = '
        <option value="">Unspecified</option>
        <option value="10-">Under 10 years old</option>
        <option value="10-15">10~15 years old</option>
        <option value="16-20">16~20 years old</option>
        <option value="21-25">21~25 years old</option>
        <option value="26-30">26~30 years old</option>
        <option value="31-35">31~35 years old</option>
        <option value="36-40">36~40 years old</option>
        <option value="41-45">41~45 years old</option>
        <option value="46-50">46~50 years old</option>
        <option value="51-55">51~55 years old</option>
        <option value="56-60">56~60 years old</option>
        <option value="61-65">61~65 years old</option>
        <option value="65+">over 65 years old</option>
        ';
        $mailaddress = "Mail address";
        $password = "Password";
        $confirm_password = "Confirm password";
        $ableservice = "Available calling services(One or more)";
        $ID_video = "ID per services";
        $comment_input = "Comment";
        $confirm = "Create";
    }elseif($_SERVER['PHP_SELF'] == '/post.php' ){
        $bulletin_board = "Bullentin board";
        $post_notice1 = "・The start time can be set within 1 week from now.";
        $post_notice2 = "・Please set UTC (Coordinated Universal Time) for the start time.";
        $post_notice3 = "・Posts are automatically deleted 3 hours after the start time.";
        $starttime_string = "Start time";
        $theme_on = "Things that you want to talk. (theme)";
        $video_call = "Video call";
        $video_choice = '
        <label><input type="radio" name="video" value="Yes">Available</label>
        <label><input type="radio" name="video" value="No">Unavailable</label>
        ';
        $youspeak = "Language you will speak";
        $partnerspeak = "Language your partner will speak";
        $otherthing = "Comment";
        $post_it = "POST";
    }elseif($_SERVER['PHP_SELF'] == '/confirm.php' || $_SERVER['PHP_SELF'] == '/confirm'){
        $confirm_req = "Confirm a request";
        $start = "time(UTC)";
        $theme = "theme";
        $video_call = "Video call";
        $poster_lang = "language the poster will speak";
        $your_lang ="language you will speak";
        $comment = "comment";
        $back = "Back";
        $REQUEST = "Request";
    }elseif($_SERVER['PHP_SELF'] == '/request.php' || $_SERVER['PHP_SELF'] == '/requests'){
        $send_request = "Complete to send a request!";
        $error_send = "Fail to send a request! Please try again";
        $bulletin = "BULLETIN";
    }elseif($_SERVER['PHP_SELF'] == '/index.php' || explode("/",$_SERVER['PHP_SELF'])[3] == 'index.php'){
        $notification = "Notification";
        $profile_tab = "Profile";
        $request_list = "Request List";
        $caution_request = "Caution";
        $caution1 = "If you approve the request, the partner's call ID will be displayed. Please note that it disappears once you leave this page.";
        $caution2 = "If you approve the request, your registered call ID will be sent to the partner, so if there is an ID that you do not want to disclose, please unregister it temporarily and approve the request.";
        $caution3 = "If you decline the request, the partner will not be notified.";
        $caution4 = "If the request is approved by the partner, their call ID will be displayed here.";
        $uppicture = "Upload";
        $username_pro = "Username";
        $mailaddress_pro = "Mail address";
        $current_pass = "Current password";
        $new_pass = "New password";
        $confirm_new_pass = "Confirm new password";
        $availableserv = "Available calling services(One or more)";
        $ID_serv = "ID per services";
        $comment_pro = "Comment";
        $change = "Change";
        $availableservice = "Available Service";
    }
}
?>
