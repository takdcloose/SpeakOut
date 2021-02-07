<?php
session_start();
#header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Speakout</title>
        <link rel="shortcut icon" href="image/icon.png" type="image/png">
        <meta name="viewport" content="width=device-width" >
        <script src="js/uikit.min.js"></script>
        <script src="js/uikit-icons.min.js"></script>
        <link rel="stylesheet" href="css/uikit.min.css">
        <script src="uikit/dist/js/uikit-icons.min.js"></script>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-160833806-1"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-160833806-1');
        </script>
    </head>
    <body>
        <?php 
        include_once("util/get_lang.php");
        include_once("util/navi.php");
        ?>
        <div class="uk-container">
            <div class="uk-section uk-padding uk-section-muted">
                        <p><?php echo $thissite ;?></p>
                    
                        <p></p>
                    
                        <p></p>
            </div>
        </div>
        <hr class="uk-divider-icon">
        <div class="uk-container uk-margin-top">
            <div class="uk-card uk-card-default uk-card-body uk-text-center uk-align-center" uk-grid>
                <div class="uk-text-secondary uk-padding-small">
                    <p class="uk-text-lead"><strong>Speakout</strong></p>
                    <ul class="uk-list uk-list-divider">
                        <li><span class="uk-margin-small-right" uk-icon="check"></span><ins><?php echo $speakout1 ;?></ins></li>
                        <li><span class="uk-margin-small-right" uk-icon="check"></span><ins><?php echo $speakout2 ;?></ins></li>
                        <li><span class="uk-margin-small-right" uk-icon="check"></span><ins><?php echo $speakout3 ;?></ins></li>
                        <li><span class="uk-margin-small-right" uk-icon="check"></span><ins><?php echo $speakout4 ;?></ins></li>
                    </ul>
                </div>               
            </div>
            <hr class="uk-divider-icon">
            <div class="uk-card uk-card-default uk-card-body uk-text-center uk-align-center" uk-grid>
                <div class="uk-text-secondary uk-padding-small">
                    <p class="uk-text-lead"><?php echo $rule5title ;?></p>
                    <div class="uk-padding-large uk-padding-remove-vertical">
                        <p class="uk-text-muted"><?php echo $rule5explain ;?></p>
                    </div>
                    <div class="uk-child-width-1-3@m uk-flex-center" uk-grid uk-scrollspy="cls: uk-animation-fade; target: .uk-card; delay: 500; repeat: true">
                        <div>
                            <div class="uk-card uk-card-default">
                                <div class="uk-card-body">
                                    <h3 class="uk-card-title"><dfn><?php echo $rule1 ;?></dfn></h3>
                                    <p class="uk-text-meta"><?php echo $rule1ex ;?></p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="uk-card uk-card-default">
                                <div class="uk-card-body">
                                    <h3 class="uk-card-title"><dfn><?php echo $rule2 ;?></dfn></h3>
                                    <p class="uk-text-meta"><?php echo $rule2ex ;?></p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="uk-card uk-card-default">
                                <div class="uk-card-body">
                                    <h3 class="uk-card-title"><dfn><?php echo $rule3 ;?></dfn></h3>
                                    <p class="uk-text-meta"><?php echo $rule3ex ;?></p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="uk-card uk-card-default">
                                <div class="uk-card-body">
                                    <h3 class="uk-card-title"><dfn><?php echo $rule4 ;?></dfn></h3>
                                    <p class="uk-text-meta"><?php echo $rule4ex ;?></p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="uk-card uk-card-default">
                                <div class="uk-card-body">
                                    <h3 class="uk-card-title"><dfn><?php echo $rule5 ;?></dfn></h3>
                                    <p class="uk-text-meta"><?php echo $rule5ex ;?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>               
            </div>
            <hr class="uk-divider-icon">
            <div class="uk-card uk-card-default uk-card-body">
                <div uk-grid>
                    <div class="uk-width-2-3@l">
                            <div class="uk-text-secondary uk-padding-small">
                                <p class="uk-text-lead"><?php echo $whyfree ;?></p>
                                <ul class="uk-list uk-list-bullet">
                                    <li><?php echo $reason1 ;?></li>
                                    <li><?php echo $reason2 ;?></li>
                                    <li><?php echo $reason3 ;?></li>
                                    <li><?php echo $reason4 ;?></li>
                                </ul>
                            </div>
                    </div>
                    <div class="uk-width-1-3@l">
                        <div class="uk-align-center uk-text-center">
                            <img class="uk-margin-remove-adjacent uk-background-muted" src="image/speak_en.JPG" height="350" width="400" alt="sample">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="uk-container uk-margin-top uk-margin-bottom">  
            <div class="uk-child-width-1-2@s uk-grid-match" uk-grid>
                <div>
                    <div class="uk-card uk-card-default uk-card-hover uk-card-body">
                        <h3 class="uk-card-title"><?php echo $notice ;?></h3>
                        <p><?php echo $notice1;?></p>
                        <p><?php echo $notice2;?></p>
                    </div>
                </div>
                <div>
                    <div class="uk-card uk-card-default uk-card-hover uk-card-body">
                        <h3 class="uk-card-title"><?php echo $alert;?></h3>
                        <ul class="uk-list uk-list-bullet">
                            <li><?php echo $alert1 ;?></li>
                            <li><?php echo $alert2 ;?></li>
                            <li><?php echo $alert3 ;?></li>
                            <li><?php echo $alert4 ;?></li>
                        </ul>
                    </div>
                </div>
            </div>
            <br>
        </div>
        <br>
        <br>
    </body>
</html>
