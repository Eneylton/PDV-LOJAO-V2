<?php

require __DIR__.'/vendor/autoload.php';

use   \App\Entidy\Produto;
use    \App\Db\Pagination;
use     \App\Session\Login;


define('TITLE', 'Caixa');
define('BRAND', 'Movimentação Finaceira ');

Login::requireLogin();

// USUARIO LOGADO

$usuariologado = Login::getUsuarioLogado();

$usuario = $usuariologado['nome'];

// LISTAR PRODUTOS

$buscar = filter_input(INPUT_GET, 'buscar', FILTER_SANITIZE_STRING);

$condicoes = [
  strlen($buscar) ? 'p.nome LIKE "%' . str_replace(' ', '%', $buscar) . '%" 
                       or 
                       p.codigo LIKE "%' . str_replace(' ', '%', $buscar) . '%"
                       or 
                       c.nome LIKE "%' . str_replace(' ', '%', $buscar) . '%"
                       or 
                       p.barra LIKE "%' . str_replace(' ', '%', $buscar) . '%"
                       or 
                       p.data LIKE "%' . str_replace(' ', '%', $buscar) . '%"' : null
];

$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$qtd = Produto::qtdCount($where);

$pagination = new Pagination($qtd, $_GET['pagina'] ?? 1, 100);

$produtos = Produto::getRelacinadas($where, 'nome ASC', $pagination->getLimit());


if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = array();
  }
  
  
  if(isset($_GET['acao'])){
  
  if ($_GET['acao'] == 'add') {
  $id = intval($_GET['id']);
  
  if (!isset($_SESSION['carrinho'][$id])) {
  
    $_SESSION['carrinho'][$id] = 1;
  } else {
    $_SESSION['carrinho'][$id] += 1;
  }
  }
  }

  if(isset($_GET['acao'])){

    if ($_GET['acao'] == 'add') {
      $id = intval($_GET['id']);
      
      if (!isset($_SESSION['carrinho'][$id])) {
  
          $_SESSION['carrinho'][$id] = 1;
      } else {
          $_SESSION['carrinho'][$id] += 1;
      }
  }

    if ($_GET['acao'] == 'up') {
  
      if (is_array($_POST['prod'])) {
  
         foreach ($_POST['prod'] as $id => $qtd) {
  
            $id = intval($id);
            $qtd = intval($qtd);
  
            if (!empty($qtd) || $qtd != 0) {
  
               $_SESSION['carrinho'][$id] = $qtd;
            } else {
  
               unset($_SESSION['carrinho'][$id]);
            }
         }
      }
  
      if (is_array($_POST['val'])) {
  
         foreach ($_POST['val'] as $id => $preco) {
  
            $item = Produto::getID($id);
  
            $item->valor_venda = $preco;
            $item->atualizar();
         }
      }
   }
  
   if ($_GET['acao'] == 'del') {
      $id = intval($_GET['id']);
  
      if (isset($_SESSION['carrinho'][$id])) {
         unset($_SESSION['carrinho'][$id]);
      }
   }
  
  }
  


include __DIR__.'/includes/header.php';
include __DIR__.'/includes/top.php';
include __DIR__.'/includes/menu.php';
include __DIR__.'/includes/content.php';
include __DIR__.'/includes/pdv/pdv-form.php';
include __DIR__.'/includes/footer.php';


?>