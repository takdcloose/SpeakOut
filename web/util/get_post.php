<?php 
$p = $_GET['p'];
if(is_null($p)){$p=1;}
$page_num = 20;
#var_dump($_GET['your_lang']);
if(isset($_GET['finduser'])){
    $url_query = array();
    $url_query['finduser']= 'finduser='.$_GET['finduser'];
    $url_query['p'] = 'p=';
    $url_querys = join("&",$url_query);
    $sth = $db->prepare("SELECT COUNT(*) FROM bulletin WHERE username=:username ORDER BY id DESC");
    $sth->bindParam(':username',$_GET['finduser']);
    $sth->execute();
    $total = $sth -> fetchAll(PDO::FETCH_ASSOC);
    $num = (int)($total[0]["COUNT(*)"]);
    $offset = ($p-1)*$page_num;
    $start = $offset +1;
    $end = min($offset+$page_num,$total);
    $pages = ceil($num / $page_num);
    $prevlink = ($p > 1) ? '<a href="?'.$url_querys . ($p - 1) . '" uk-slidenav-previous></a>' : '';
    $nextlink = ($p < $pages) ? '<a href="?'.$url_querys . ($p + 1) . '" uk-slidenav-next></a>' : '';
    $stmt = $db->prepare("SELECT * FROM bulletin WHERE username=:username ORDER BY id DESC LIMIT :limit OFFSET :offset");
    $stmt->bindParam(':username',$_GET['finduser'],PDO::PARAM_STR);
    $stmt->bindParam(':limit', $page_num,PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset,PDO::PARAM_INT);
    $re = $stmt->execute();
    $row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
}elseif($_GET['my_lang'] != "" || $_GET['your_lang'] != "" || isset($_GET['video'])){
    $url_query = array();
    $query = "SELECT COUNT(*) FROM bulletin WHERE 1";
    if($_GET['my_lang'] != ""){ $query .= " AND mylang = :mylang"; $url_query["my_lang"] = "my_lang=".$_GET["my_lang"];}
    if($_GET['your_lang'] != ""){ $query .= " AND yourlang = :yourlang"; $url_query["your_lang"] = "your_lang=".$_GET["your_lang"];}
    if(isset($_GET['video'])){ $query .= " AND video = :video";$url_query["video"] = "video=".$_GET["video"];}
    $url_query['p'] = 'p=';
    $url_querys = join("&",$url_query);
    $query .= " ORDER BY id DESC";
    $sth = $db->prepare($query);
    if($_GET['my_lang'] != ""){ $sth->bindParam(':mylang',$_GET['my_lang'],PDO::PARAM_STR);}
    if($_GET['your_lang'] != ""){ $sth->bindParam(':yourlang',$_GET['your_lang']);}
    if(isset($_GET['video'])){ $sth->bindParam(':video',$_GET['video']);}
    $re = $sth->execute();
    #print_r($sth->errorInfo());
    $total = $sth -> fetchAll(PDO::FETCH_ASSOC);
    $num = (int)($total[0]["COUNT(*)"]);
    $offset = ($p-1)*$page_num;
    $start = $offset +1;
    $end = min($offset+$page_num,$total);
    $pages = ceil($num / $page_num);
    $prevlink = ($p > 1) ? '<a href="?'.$url_querys . ($p - 1) . '" uk-slidenav-previous></a>' : '';
    $nextlink = ($p < $pages) ? '<a href="?'.$url_querys . ($p + 1) . '" uk-slidenav-next></a>' : '';
    $query2 = "SELECT * FROM bulletin WHERE 1";
    if($_GET['my_lang'] != ""){ $query2 .= " AND mylang = :mylang";}
    if($_GET['your_lang'] != ""){ $query2 .= " AND yourlang = :yourlang";}
    if(isset($_GET['video'])){ $query2 .= " AND video = :video";}
    $query2 .= " ORDER BY id DESC LIMIT :limit OFFSET :offset";
    $stmt = $db->prepare($query2);
    if($_GET['my_lang'] != ""){ $stmt->bindParam(':mylang',$_GET['my_lang'],PDO::PARAM_STR);}
    if($_GET['your_lang'] != ""){ $stmt->bindParam(':yourlang',$_GET['your_lang'],PDO::PARAM_STR);}
    if(isset($_GET['video'])){ $stmt->bindParam(':video',$_GET['video'],PDO::PARAM_STR);}
    $stmt->bindParam(':limit', $page_num,PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset,PDO::PARAM_INT);
    $re = $stmt->execute();
    $row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
}else{
    $sth = $db->prepare("SELECT COUNT(*) FROM bulletin ORDER BY id DESC");
    $sth->execute();
    $total = $sth -> fetchAll(PDO::FETCH_ASSOC);
    $num = (int)($total[0]["COUNT(*)"]);
    $offset = ($p-1)*$page_num;
    $start = $offset +1;
    $end = min($offset+$page_num,$total);
    $pages = ceil($num / $page_num);
    $prevlink = ($p > 1) ? '<a href="?p=' . ($p - 1) . '" uk-slidenav-previous></a>' : '';
    $nextlink = ($p < $pages) ? '<a href="?p='.$url_querys . ($p + 1) . '" uk-slidenav-next></a>' : '';
    $stmt = $db->prepare("SELECT * FROM bulletin ORDER BY id DESC LIMIT :limit OFFSET :offset");
    $stmt->bindParam(':limit', $page_num,PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset,PDO::PARAM_INT);
    $re = $stmt->execute();
    $row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
}
?>