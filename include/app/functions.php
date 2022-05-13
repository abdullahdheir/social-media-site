<?php

function getTitle(){
    global $title;
    if(isset($title)):
    echo $title;
    else:
    echo 'Defualt';
    endif;
}