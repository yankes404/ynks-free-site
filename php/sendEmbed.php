<?php


$question_ooc = [];
$question_ic = [];

require_once "checkErrs.php";

if(isset($qCountOoc))
{
    for($i=0; $i < $qCountOoc; $i++)
    {

        $string = (string)$i;
        
        $question_ooc[$i] = $_POST['ooc'.$string];
        if(checkErrs($question_ooc[$i]))
        {
            $errs = "Niektóre pola są puste! Uzupełnij je aby wysłać podanie!";
        }

    }
}

if(isset($qCountIc))
{
    for($i=0; $i < $qCountIc; $i++)
    {

        $string = (string)$i;
        
        $question_ic[$i] = $_POST['ic'.$string];
        if(checkErrs($question_ic[$i]))
        {
            $errs = "Niektóre pola są puste! Uzupełnij je aby wysłać podanie!";
        }
    }
}

if(!isset($errs))
{
$fieldOoc = [];
$fieldIc = [];

$dsc[0] = ["name" => "[DISCORD] Discord Username", "value" => '<@'.$id.'>', "inline" => false];

if(isset($qCountOoc))
{
    for($i=0; $i < $qCountOoc; $i++)
    {
        $fieldOoc[$i] = ["name" => "[OOC] ".$example['ooc'][$i][0], "value" => '```'.$question_ooc[$i].'```', "inline" => false];
    }
}

if(isset($qCountIc))
{
    for($i=0; $i < $qCountIc; $i++)
    {
        $fieldIc[$i] = ["name" => "[IC] ".$example['ic'][$i][0], "value" => '```'.$question_ic[$i].'```', "inline" => false];
    }
}

$timestamp = date("c", strtotime("now"));

$json_data = json_encode([

    "tts" => false,

    "embeds" => [
        [
            "title" => "Wysłano nowe podanie!",

            "type" => "rich",

            "timestamp" => $timestamp,

            "color" => hexdec( $color ),

            "footer" => [
                "text" => "Apps writed by yankes404 ( github.com/yankes404 )",
                "icon_url" => "https://avatars.githubusercontent.com/u/106172533?s=400&u=573fe366fa3b974fe68d0674d3f5b75ae8c403ae&v=4"
            ],

           "fields" => array_merge($dsc,$fieldOoc, $fieldIc),
        ]
    ]

], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );


$ch = curl_init( $webhook );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec( $ch );
curl_close( $ch );
}