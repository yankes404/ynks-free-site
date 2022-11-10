<?php
    session_start();

    if(isset($_SESSION['logged'])){extract($_SESSION['userData']);}
    else {header("location: notlogged.php"); exit();}

    $avtar_url = "https://cdn.discordapp.com/avatars/$id/$avatar.jpg";

    $json = file_get_contents("../cfg/config.json");
    $decoded = json_decode($json, JSON_OBJECT_AS_ARRAY);

    $lang = $decoded["lang"];
    $lang_file = file_get_contents("../cfg/langs/".$lang);
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
    <title><?= $decoded["server_name"]." | ".$declang["navbar_profile"]?></title>
    <link rel="stylesheet" href="../cfg/colors.css">
    <link rel="stylesheet" href="../css/ui.css">
    <script src="https://kit.fontawesome.com/19fb4a503f.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" <?= 'href="'.$decoded['server_icon'].'"'?> type="image/x-icon">
    <meta name="description" <?= 'content='.$decoded["description"].'"'?>>
    <style>
        body {
            overflow: hidden;
        }
    </style>
</head>
<body>
    <div class="navbar short-navbar">
        <div class="navbar-row" expanse-collapse>
            <div class="navbar-icon">
                <i class="fa-solid fa-chevron-right" id="expanse-collapse-icon"></i>
            </div>
            <div class="navbar-text"><?= $declang["navbar_collapse"]?></div>
        </div>
        <div class="navbar-row">
            <a class="active-dashboard" href='profile' <?= 'title="'.$declang["navbar_profile"].'"'?>>
                <div class="navbar-icon">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="navbar-text"><?= $declang["navbar_profile"]?></div>
            </a>
        </div>
        <div class="navbar-row">
            <a href="apps" <?= 'title="'.$declang["navbar_apps"].'"'?>>
                <div class="navbar-icon">
                    <i class="fa-solid fa-clipboard-list"></i>
                </div>
                <div class="navbar-text"><?= $declang["navbar_apps"]?></div>
            </a>
        </div>
        <div class="navbar-row-end navbar-row">
            <a href="../home" <?= 'title="'.$declang["home"].'"'?>>
                <div class="navbar-icon">
                    <img src=<?= $decoded["server_icon"]?> alt="">
                </div>
                <div class="navbar-text"><?php $date = getdate();echo "&copy; ".$date['year'].". ".$decoded['server_name'];?></div>
            </a>
        </div>
    </div>
    <header class="dashboard">
    <?=
        '<div class="p">
            <button class="logged-via-dsc">
                <div class="dsc-username">'.$declang['hello'].", ".$username.'#'.$tag.'</div>
                <div class="dsc-avatar"><img src="'.$avtar_url.'" alt=""></div>
            </button>
            <nav>
                <ul>
                    <li>
                        <a href="apps.php">'.$declang["dashboard"].'</a>
                    </li>
                    <li>
                    <a class="logout" href="../php/logout.php">'.$declang["logout"].'</a>
                    </li>
                </ul>
            </nav>
        </div>';
    ?>
    </header>
    <main class="profile">
        <div class="profile-box">
            <div class="color-bar" class="dashboard" style=<?= '"position: relative;height: 120px; width: 100%; background: '.$color.'"' ?>>
                <?='<div class="dsc-avatar"><img src="'.$avtar_url.'" alt=""></div>'?>
            </div>
            <div class="info-profile-box">
                <div class="profile-row">
                    <h3><?= $declang['discord_id']?></h3>
                    <div class="profile-box-mini">
                        <?=$id?>
                    </div>
                </div>
                <div class="profile-row">
                <h3><?= $declang['discord_username']?></h3>
                    <div class="profile-box-mini">
                        <?=$username?>
                    </div>
                </div>
                <div class="profile-row">
                <h3><?= $declang['discord_tag']?></h3>
                    <div class="profile-box-mini">
                        <?=$tag?>
                    </div>
                </div>
                <div class="profile-row">
                <h3><?= $declang['email_adress']?></h3>
                    <div class="profile-box-mini">
                        <?=$email?>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="navbar.js"></script>
</body>
</html>