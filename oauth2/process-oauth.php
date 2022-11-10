<?php

    define("CLIENT_ID", "YOUR_CLIENT_ID");
    define("CLIENT_SECRET", "YOUR_CLIENT_SECRET");
    define("REDIRECT_URI", "YOUR_REDIRECT_URI");

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $decoded["server_name"]?></title>
    <link rel="stylesheet" href="cfg/colors.css">
    <link rel="stylesheet" href="../dashboard/nl.css">
    <script src="https://kit.fontawesome.com/19fb4a503f.js" crossorigin="anonymous"></script>
</head>
<body>
<?php

if(!isset($_GET['code'])) 
{
    echo "Error: No Code";
    exit();
}

$discord_code = $_GET['code'];


$payload = [
    "code" => $discord_code,
    "client_id" => CLIENT_ID,
    "client_secret" => CLIENT_SECRET,
    "grant_type" => "authorization_code",
    "redirect_uri" => REDIRECT_URI,
    "scope" => "identify%20email",
];

$payload_string = http_build_query($payload);
$discord_token_url = "https://discordapp.com/api/oauth2/token";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $discord_token_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

$result = curl_exec($ch);

if(!$result)
{
    echo curL_error($ch);
}

$result = json_decode($result, true);
$access_token = $result["access_token"];

$discord_users_url = "https://discordapp.com/api/users/@me";
$header = ["Authorization: Bearer $access_token", "Content-Type: application/x-www-form-urlencode"];

$ch = curl_init();

curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_URL, $discord_users_url);
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

$result = curl_exec($ch);
$result = json_decode($result, true);

session_start();

$_SESSION['logged'] = true;
$_SESSION['userData'] = [
    "username" => $result["username"],
    "id" => $result["id"],
    "avatar" => $result["avatar"],
    "email" => $result["email"],
    "tag" => $result['discriminator'],
    "color" => $result["banner_color"]
];

header("location: ../dashboard");
exit();

?>
</body>
</html>