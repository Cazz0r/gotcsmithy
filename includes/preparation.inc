<?php

//Include the functions
require_once "functions.inc";

//Store the request time in a variable for later.
$RequestTime = $_SERVER['REQUEST_TIME'];

//Consider a server setting somewhere to hold these values.
$SessionTimeout = 600; //We want sessions to last at *least* 10 minutes (600 seconds).

//Start the session with our settings!
$SessionSettings = [
    'name' => 'SelfTagMeSessionID',    
    'gc_maxlifetime' => $SessionTimeout,
    'cookie_lifetime' => $SessionTimeout
];
session_start($SessionSettings);

//Check if we had a previous Session Activity value, if we do, see if we started more than 10 minutes ago.
$NewSession = true;
if(isset($_SESSION['Session Activity'])){
    if(
        $RequestTime - $_SESSION['Session Activity'] < $SessionTimeout //Check for inactivty
        //$RequestTime - $_SESSION['Session Start'] < $SessionTimeout //Check for total session time
    ){ 
        $NewSession = false; //Don't start a new session if we haven't had 10 minutes of activity.
    }
}

if($NewSession){ //Start a new session.
    session_start($SessionSettings);
    $_SESSION['Session Start'] = $RequestTime;        
}

//Always update the Session Activity time so that we can check it next time.
$_SESSION['Session Activity'] = $RequestTime;

//Get some database tables out.
//Materials
$sql = "SELECT * FROM gotc.material ORDER BY FIELD(TYPE, 'Basic', 'Advanced', 'Trinket'), material";
$rs = $GLOBALS['mysqli']->query($sql) or die("Unable to Query Materials Configuration Table");
if($rs->num_rows > 0){
    $Materials = array();
    while($row = $rs->fetch_array(MYSQLI_ASSOC)){
        $Materials[$row['material']] = $row;
        $MaterialsID[$row['id']] = $row;
    }
}else{
    die('Configuration Invalid: No Materials Found.');
}
//Qualities
$sql = "SELECT * FROM gotc.quality";
$rs = $GLOBALS['mysqli']->query($sql) or die("Unable to Query Quality Configuration Table");
if($rs->num_rows > 0){
    $Qualities = array();
    while($row = $rs->fetch_array(MYSQLI_ASSOC)){
        $Qualities[$row['quality']] = $row;
    }
}else{
    die('Configuration Invalid: No Qualities Found.');
}
//Levels
$sql = "SELECT * FROM gotc.level";
$rs = $GLOBALS['mysqli']->query($sql) or die("Unable to Query Level Configuration Table");
if($rs->num_rows > 0){
    $Levels = array();
    while($row = $rs->fetch_array(MYSQLI_ASSOC)){
        $Levels[] = $row['level'];
    }
}else{
    die('Configuration Invalid: No Qualities Found.');
}
//Slots
$sql = "SELECT * FROM gotc.gear_slot";
$rs = $GLOBALS['mysqli']->query($sql) or die("Unable to Query Level Configuration Table");
if($rs->num_rows > 0){
    $Slots = array();
    while($row = $rs->fetch_array(MYSQLI_ASSOC)){
        $Slots[$row['id']] = $row['slot'];
    }
}else{
    die('Configuration Invalid: No Slots Found.');
}

$GLOBALS['Development'] = isset($_GET['Cazz']) ? true : (ClientIP() == '103.192.82.17' ? true : false);


//Clean up some variables that won't be used past here.
unset($RequestTime, $SessionSettings, $NewSession, $Minutes);

?>