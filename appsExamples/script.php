<?php

function getExample($questions)
{

$json = file_get_contents("../questions/".$questions);

$json_decoded = json_decode($json, JSON_OBJECT_AS_ARRAY);

$array = [];

if(isset($json_decoded['ooc']))
{
    $ooc = $json_decoded['ooc'];
    $cnt = count($ooc);


    for($i=0; $i < $cnt; $i++)
{
    if($ooc['q'.$i]["length"] == "short")
    {
        $array['ooc'][$i] = [
            $ooc['q'.$i]["title"], 
            $ooc['q'.$i]["length"],
            $ooc['q'.$i]["type"]
        ];
    }
    else if($ooc['q'.$i]["length"] == "long")
    {
        $array['ooc'][$i] = [
            $ooc['q'.$i]["title"], 
            $ooc['q'.$i]["length"]
        ];
    }
}
}

if(isset($json_decoded['ic']))
{
    $ic = $json_decoded['ic'];
    $cnt2 = count($ic);


    for($i=0; $i < $cnt2; $i++)
{
    if($ic['q'.$i]["length"] == "short")
    {
        $array['ic'][$i] = [
            $ic['q'.$i]["title"], 
            $ic['q'.$i]["length"],
            $ic['q'.$i]["type"]
        ];
    }
    else if($ic['q'.$i]["length"] == "long")
    {
        $array['ic'][$i] = [
            $ic['q'.$i]["title"], 
            $ic['q'.$i]["length"]
        ];
    }
}
}

return $array;
}