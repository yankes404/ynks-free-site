<?php

    session_start();
    if(isset($_SESSION['logged'])){extract($_SESSION['userData']);}
    else {header("location: notlogged.php"); exit();};

    $json = file_get_contents("../cfg/config.json");
    $decoded = json_decode($json, JSON_OBJECT_AS_ARRAY);

    $avtar_url = "https://cdn.discordapp.com/avatars/$id/$avatar.jpg";

    if(!isset($_GET['t'])) 
        {$t = $decoded['apps']['app1']["name"];
        header("location: apps.php?t=$t");
    }
    else $t = $_GET['t'];

    $apps_all = $decoded['apps'];
    $apps_allCount = count($apps_all);

    $lang = $decoded["lang"];
    $lang_file = file_get_contents("../cfg/langs/".$lang);
    $declang = json_decode($lang_file, JSON_OBJECT_AS_ARRAY);


    function checkT($apps_all, $apps_allCount, $t)
    {
        for($i=1; $i <= $apps_allCount; $i++) {
            $string = 'app'.(string)$i;

            if($t == $apps_all[$string]['name'] && $apps_all[$string]["available"] == true) return $apps_all[$string];
            else if($i == $apps_allCount ) return false;
        }
    }

    if(!checkT($apps_all, $apps_allCount, $t)) {header("location: apps.php?t=".$decoded['apps']["app1"]["name"]); exit();}
    else
    {
        $app = checkT($apps_all, $apps_allCount, $t);
        $name = $app['name'];
        $title = $app['title'];
        require_once("../appsExamples/script.php");

        $example = getExample($app['questions_file']);
        if(isset($example['ooc']))$qCountOoc = count($example['ooc']);
        if(isset($example['ic']))$qCountIc = count($example['ic']);
        if(isset($_POST['ooc0']) || isset($_POST['ic0']))
        {
            $webhook = require_once("../".$app['webhook']);
            $color = $app['embed_color'];
            require_once("../php/sendEmbed.php");

            if((isset($_POST['ooc0'])|| isset($_POST['ic0'])) && !isset($errs))
            {
                header('Location: ../thanks.php');
            }
        }
    }
    
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
        <title><?= $decoded["server_name"]." | ".$declang["navbar_apps"]?></title>
        <link rel="stylesheet" href="../cfg/colors.css">
        <link rel="stylesheet" href="../css/ui.css">
        <script src="https://kit.fontawesome.com/19fb4a503f.js" crossorigin="anonymous"></script>
        <link rel="shortcut icon" <?= 'href="'.$decoded['server_icon'].'"'?> type="image/x-icon">
        <meta name="description" <?= 'content='.$decoded["description"].'"'?>>
        </script>
        <style>
            .header {
                height: 20vh;
            }
            
            .paragraph {
                height: 0;
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
            <a href="profile" <?= 'title="'.$declang["navbar_profile"].'"'?> >
                <div class="navbar-icon">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="navbar-text"><?= $declang["navbar_profile"]?></div>
            </a>
        </div>
        <div class="navbar-row">
            <a href="apps" <?= 'title="'.$declang["navbar_apps"].'"'?> class="active-dashboard">
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
            <nav>
                <ul class="app-ul">
                    <?php 
                    foreach($apps_all as $app) {
                        if($app['available'] == true)
                        {
                            echo '<li>
                                <button class="button-app" button-'.$app['name'].'  ><a href="apps.php?t='.$app['name'].'">'.$app['title'].'</a>
                                </button>
                            </li>';
                        }
                    }
                ?>
                </ul>
            </nav>
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
        <main>
            <div class="form-box" class="form">
                <form method="post">
                    <?php
                    echo '<div class="blocked-input" name="dsc-id">'.$username."#".$tag.'</div>';

                    if(isset($qCountOoc))
                    {
                    echo '<label for="ooc0">Out of Character</label>';

                    for($i=0; $i < $qCountOoc; $i++)
                        {
                            if($example['ooc'][$i][1] == "short")
                            {
                                $string = (string)$i;
                                if(isset($_POST['ooc'.$string])) $value = $_POST['ooc'.$string];
                                else $value = "";
                                echo '<input type="'.$example['ooc'][$i][2].'" id="ooc'.$i.'" name="ooc'.$i.'" placeholder="'.$example['ooc'][$i][0].'" class="input-text-ooc" value="'.$value.'">';
                            }
                            else if($example['ooc'][$i][1])
                            echo '<textarea id="ooc'.$i.'" name="ooc'.$i.'" placeholder="'.$example['ooc'][$i][0].'" class="input-text-ooc">'.$value.'</textarea>';
                        }
                    }
                    if(isset($qCountIc))
                    {
                        echo '<label for="ic0">In Character</label>';

                        for($i=0; $i < $qCountIc; $i++)
                            {
                                if($example['ic'][$i][1] == "short")
                                {
                                    $string = (string)$i;
                                    if(isset($_POST['ic'.$string])) $value = $_POST['ic'.$string];
                                    else $value = "";
                                    echo '<input type="'.$example['ic'][$i][2].'" id="ic'.$i.'" name="ic'.$i.'" placeholder="'.$example['ic'][$i][0].'" class="input-text-ic" value="'.$value.'">';
                                }
                                else if($example['ic'][$i][1])
                                echo '<textarea id="ic'.$i.'" name="ic'.$i.'" placeholder="'.$example['ic'][$i][0].'" class="input-text-ooc">'.$value.'</textarea>';
                            }
                    }
                    ?>
                        <button type="submit"><?= $declang['send_app']?></button>
                        <div class="errs">
                            <?= isset($errs) ? $errs : ""?>
                        </div>
                </form>
                <div>
        </main>
        <?php unset($errs);?>
        <script src="navbar.js"></script>
    </body>

    </html>