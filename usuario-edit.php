<?php 

require __DIR__.'/vendor/autoload.php';



$alertaCadastro = '';

define('TITLE','Editar Usuários');
define('BRAND','Editar Usuários');

use \App\Entidy\Usuario;
use   \App\Session\Login;


Login::requireLogin();



if(!isset($_GET['id']) or !is_numeric($_GET['id'])){
 
    header('location: index.php?status=error');

    exit;
}

$usuarios = Usuario::getUsuariosID($_GET['id']);


if(!$usuarios instanceof Usuario){
    header('location: index.php?status=error');

    exit;
}



if(isset($_POST['senha'])){
    
    $usuarios->senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $usuarios-> atualizar();

    header('location: usuario-list.php?status=success');

    exit;
}



include __DIR__.'/includes/layout/header.php';
include __DIR__.'/includes/layout/top.php';
include __DIR__.'/includes/layout/menu.php';
include __DIR__.'/includes/layout/content.php';
include __DIR__.'/includes/usuario/usuario-form-edit.php';
include __DIR__.'/includes/layout/footer.php';