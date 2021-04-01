070345<?php

$listProdutos = '';
$resultados   = '';

foreach ($produtos as $item) {

  if(empty($item->foto)){
  
    $foto = 'imgs/sem.jpg';
    
  }else{
    
    $foto = $item->foto;

  }

  $listProdutos .= '

                <tr>
                  <td>   
                            
                        <div class="icheck-red ">
                        <input type="checkbox" value="' . $item->id . '" name="id[]" id="[' . $item->id . ']">
                        <label for="[' . $item->id . ']"></label>
                        </div>   
                        </td>
                                
                        <td>
                        
                        <div class="product-img">
                        <img src="' .$foto. '" class="img-size-50" class="img-thumbnail">
                        </div>
                        </td>
                        <td>' . $item->codigo . '</td>
                        <td>' . $item->nome . '</td>
                        <td style="text-align:center">
                      
                        <span style="font-size:16px" class="' . ($item->estoque <= 3 ? 'badge badge-danger' : 'badge badge-success') . '">' . $item->estoque . '</span>
                        
                        </td>
                        <td> R$ ' . number_format($item->valor_venda, "2", ",", ".") . '</td>
                        <td>

                        <a href="?acao=add&id=' . $item->id . '">
                         <i class="fas fa-plus-circle" style="font-size:28px;color:#30da04"></i>
                       </a>
                        
                  </td>
                </tr>

';




}

$resultados = strlen($resultados) ? $resultados : '<tr>
                                                     <td colspan="6" class="text-center" > Nenhuma Vaga Encontrada !!!!! </td>
                                                     </tr>';

unset($_GET['pagina']);
$gets = http_build_query($_GET);

//PAGINAÇÂO

$paginacao = '';
$paginas = $pagination->getPages();

foreach ($paginas as $key => $pagina) {
   $class = $pagina['atual'] ? 'btn-primary' : 'btn-dark';
   $paginacao .= '<li class="page-item"><a href="?pagina=' . $pagina['pagina'] . '&' . $gets . '">

                  <button type="button" class=" btn ' . $class . '">' . $pagina['pagina'] . '</button>
                  &nbsp; </a></li>';
}


?>



<div class="content-wrapper" style="margin-top: 30px;">

    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?=TITLE?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?=BRAND?></li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">

<div class="container-fluid">
 
        <div class="row">
           
           <!-- LISTA DE PRODUTOS -->

          <div class="col-lg-8 col-6">
              <div class="card card-dark">
              <div class="card-header">
                <h3 class="card-title">Atendente: &nbsp; <span style="text-transform: uppercase; color:yellow"><?= $usuario?></span></h3>

                <div class="card-tools">
                  <ul class="pagination pagination-sm float-right">
                    <?= $paginacao  ?>
                  </ul>
                </div>
              </div>

             
              <div class="card-body">
              <form method="get">
                <h3 class="card-title">
                <div class="input-group input-group-sm" style="width: 350px;">
                <input type="text" name="buscar" class="form-control float-right" placeholder="Pesquisar...." autofocus>

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </h3>
               </form>
               <form>
               <div class="card-header">
               
                <div class="card-tools">
                <button  type="button" class="btn btn-flat btn-warning ">Adicionar todos &nbsp; <i class="fas fa-chevron-right"></i></button>
                </div>
                
              </div>

              <div class="card-body table-responsive p-0" style="height: 430px;">
                <table class="table table-head-fixed text-nowrap">
                  <thead>
                  <th>
                    <div class="icheck-warning d-inline">
                    <input type="checkbox" id="select-all" >
                    <label for="select-all">
                    </label>
                    </div>

                    </th>
                    <th>IMAGEM</th>
                    <th>CÓDIGO</th>
                    <th>PRODUTO</th>
                    <th style="text-align:center">ESTOQUE</th>
                    <th>VALOR</th>
                    <th>AÇÃO</th>
                  </thead>
                  <tbody>
                     <?= $listProdutos ?>
                  </tbody>
                </table>
              </div>


              </form>
            </div>

        
              </div>

          </div>

          <!-- CAIXA -->

          <div class="col-lg-4 col-6">
          <?php
           
           use   \App\Entidy\Produto;

           $listItem = '';
           $total = 0;

           foreach ($_SESSION['carrinho'] as $id => $qtd) {
              
            $item = Produto::getID($id);
        
            $nome = $item->nome;
        
            $valor_venda = $item->valor_venda;
        
            $qtd;
             
            $sub = $qtd * $item->valor_venda;
        
            $total += $sub;
        
            $listItem .=' 
                
            <tr>
                    
            <td style="text-transform:uppercase; font-size:small">' . $nome . '</td>
      
            <td style="width:80px">
      
            <input type="text" size="1" name="prod[' .$id. ']" value="'.$qtd.'" style="width:50px" />
      
           
            
            </td>
      
            <td style="width:150px">R$
      
            <input type="text" size="2" name="val['.$id.']" value="'.$valor_venda.'" />
      
            <button type="submit"><i class="fas fa-pen"></i></button>
             
            &nbsp;&nbsp;
      
            <a href="?acao=del&id=' . $id . '"
          
            <i class="fas fa-times" style="color:#ff0000"></i>
            </a>
            
            </td>
            <td> R$ ' . number_format($sub, "2", ",", ".") . '</td>
      
            
            </tr>
            
            ';
        
          }
        
        

    ?>
            

            <div class="card card-danger">
            <div class="card-header">
                <h1 class="card-title"><span style="font-size: xx-large; font-weight:600;">R$ &nbsp;
                 
                 <?= number_format($total,"2",",",".") ?>
                 
                 </span></h1>

                <div class="card-tools">
                  <ul class="pagination pagination-sm float-right">
                    <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                  </ul>
                </div>
              </div>
              
                  <div class="card-body">

                  <div class="tab-content p-0 direct-chat-messages" style="height: 250px;">
                  <form action="?acao=up" method="post">
                  <table class="table table-hover table-dark table-striped table-sm" >
                  <thead>
                  <tr>
                    <th style="width:200px; text-align:LEFT"> PRODUTO </th>
                    <th> QTD </th>
                    <th style="width:200px; text-align:center"> VALOR </th>
                    <th style="width:100px"> SUBTOTAL </th>
                    </tr>
                  </thead>
                  <tbody>
                 
                   <?= $listItem ?>  
                  
                  </tbody>
                  </table>
                  </form>
                  </div>

            </div>

          </form>
              </div>

          </div>

          <!-- FIM -->

        </div>
      </div>