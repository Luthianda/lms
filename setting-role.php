<?php
function group1(){
    return['9'];
}
function group2(){
    return['8'];
}
function group3(){
    // 5=Admin, 7=PIC, 10=Administrator
    return['5','7','10'];
}

function role_available (){
    // 9= instruktur, 8=siswa
    return ['9', '8'];
}

// in array
function canAddModul($role){
    if(in_array($role, group1())){
        return true;
    }
}


?>