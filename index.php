<?php

    session_start();
    if(isset($_SESSION['logged'])){extract($_SESSION['userData']);

    $avtar_url = "https://cdn.discordapp.com/avatars/$id/$avatar.jpg";
    }

    $json = file_get_contents("cfg/config.json");
    $decoded = json_decode($json, JSON_OBJECT_AS_ARRAY);

    $lang = $decoded["lang"];
    $lang_file = file_get_contents("cfg/langs/".$lang);
    $declang = json_decode($lang_file, JSON_OBJECT_AS_ARRAY);

?>

    <!DOCTYPE html>
    <html <?php 
         $lang = substr($decoded["lang"], 0, 2);
         echo 'lang = "'.$lang.'"'
    ?>>

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" <?= 'content='.$decoded["description"].'"'?>>
        <title><?= $decoded["server_name"]." | ".$declang["home"]?></title>
        <script src="https://kit.fontawesome.com/19fb4a503f.js" crossorigin="anonymous" defer></script>
        <link rel="shortcut icon" <?= 'href="'.$decoded['server_icon'].'"'?> type="image/x-icon">
        <link rel="stylesheet" href="css/ui.css">
        <link rel="stylesheet" href="cfg/colors.css">
        
    </head>

    <body>
    <div class="background" aria-hidden="true"></div>
       
            <div class="header">
                <div class="logo">
                    <a href="home">
                        <h1>
                            <?= $decoded['server_name']?>
                                <div class="after">
                                    <?= $decoded['server_name']?>
                                </div>
                        </h1>
                    </a>
                </div>
                <nav>
                    <ul class="index-ul">
                        <li>
                            <a href="home" style="color: var(--color-one); cursor: default; font-weight: 500;">
                                <?= $declang['home']?>
                            </a>
                        </li>
                        <li>
                            <a href="rules">
                                <?= $declang['rules']?>
                            </a>
                        </li>
                        <li>
                            <a href="others/discord.php">Discord</a>
                        </li>
                        <li>
                            <a href="others/donate.php"><?= $declang["donate"]?></a>
                        </li>
                    </ul>
                </nav>
                <?php
                    if(isset($_SESSION['logged']))
                    {
                        echo
                        '
                        <div class="p">
                            <button class="logged-via-dsc">
                                                <div class="dsc-username">'.$declang['hello'].", ".$username.'#'.$tag.'</div>
                                <div class="dsc-avatar"><img src="'.$avtar_url.'" alt=""></div>
                            </button>
                            <nav>
                                <ul>
                                    <li>
                                        <a href="dashboard">'.$declang["dashboard"].'</a>
                                    </li>
                                    <li>
                                        <a class="logout" href="php/logout.php">'.$declang["logout"].'</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        ';
                    }
                    else
                    {
                        echo
                        '<button class="login-via-dsc">
                            <a href="oauth2/init-oauth.php">'.$declang["login_by"].' <i class="fa-brands fa-discord"></i></a>
                        </button>';
                    }
            ?>
            </div>
            <div class="paragraph">
                <h2 id="about_us">
                    <?= $declang['about_us']?>
                </h2>
                <p>
                    <?= 
                    $decoded['about_us'];
               ?>
                </p>
            </div>
    </body>

    </html>