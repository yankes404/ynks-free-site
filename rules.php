<?php
    session_start();
    if(isset($_SESSION['logged'])){extract($_SESSION['userData']);

    $avtar_url = "https://cdn.discordapp.com/avatars/$id/$avatar.jpg";}

    $json = file_get_contents("cfg/config.json");
    $decoded = json_decode($json, JSON_OBJECT_AS_ARRAY);

    $json_rules = file_get_contents("cfg/rules.json");
    $decoded_rules = json_decode($json_rules, true);

    //print_r($decoded_rules);

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
        <title><?= $decoded["server_name"]." | ".$declang["rules"]?></title>
        <meta name="description" <?= 'content='.$decoded["description"].'"'?>>
        <link rel="stylesheet" href="cfg/colors.css">
        <link rel="stylesheet" href="css/ui.css">
        <script src="https://kit.fontawesome.com/19fb4a503f.js" crossorigin="anonymous"></script>
        <link rel="shortcut icon" <?= 'href="'.$decoded['server_icon'].'"'?> type="image/x-icon">
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
        <div class="header">
            <div class="logo">
                <a href='home'>
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
                        <a href='home'>
                            <?= $declang['home']?>
                        </a>
                    </li>
                    <li>
                        <a href="rules" style="color: var(--color-one); cursor: default; font-weight: 500;">
                            <?= $declang['rules']?>
                        </a>
                    </li>
                    <li>
                        <a <?='href="' .$decoded[ 'discord']. '"'?>>Discord</a>
                    </li>
                    <li>
                        <a <?='href="' .$decoded[ 'donate']. '"'?>><?= $declang['donate']?></a>
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
        <main>
            <div class="rules-box">
                <?php 
                $rules = $decoded_rules['rules'];
                $rules_count = count($rules);

                foreach ($rules as $rule){
                    echo '<div class="l">
                    <label>'.$rule['label'].'</label>
                    <div class="rule-container" style="display:flex; flex-direction:column">';

                    foreach($rule['points'] as $point)
                    {
                        echo '<p class="rule"> '.$point.'</p>';
                    }

                    //print_r($rule);

                    echo '</div></div>';
                }
                ?>
            </div>
        </main>
        <footer>
            <?php
            $date = getdate();
            echo "&copy; ".$date['year'].". ".$decoded['server_name'];
        ?>
        </footer>
    </body>

    </html>