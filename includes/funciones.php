<?php

session_start();

function autenticado():bool{
    $auth = $_SESSION['login'];
    if($auth){
        return true;
    }
    return false;
}

function zonaHoraria(){
    return date_default_timezone_set('america/mexico_city');
}