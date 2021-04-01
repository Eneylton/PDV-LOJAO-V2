<?php 

require __DIR__.'/vendor/autoload.php';

define('TITLE','Novo Usuário');
define('BRAND','Cadastrar Usuário');

use \App\Entidy\Usuario;
use   \App\Session\Login;

$alertaLogin  = '';
$alertaCadastro = '';

$usuariologado = Login:: getUsuarioLogado();

$usuario = $usuariologado['id'];



$usuarios = Usuario::getUsuarios(null,null,null);

Login::requireLogin();

if(isset($_POST['nome'],$_POST['email'],$_POST['senha'])){

    $userEmail = Usuario:: getUsuarioPorEmail($_POST['email']);

    if($userEmail instanceof Usuario){
        $alertaCadastro = 'Email já está em uso !!!';
        
    }else{

        $userEmail = new Usuario;
        $userEmail->nome = $_POST['nome'];
        $userEmail->email = $_POST['email'];
        $userEmail->senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    
        $userEmail->cadastar();

        header('location: usuario-list.php?status=success');
        exit;
    }
  
   


} 




include __DIR__.'/includes/layout/header.php';
include __DIR__.'/includes/layout/top.php';
include __DIR__.'/includes/layout/menu.php';
include __DIR__.'/includes/layout/content.php';
include __DIR__.'/includes/usuario/usuario-form-insert.php';
include __DIR__.'/includes/layout/footer.php';