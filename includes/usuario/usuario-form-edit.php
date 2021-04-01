<section class="content">
     <div class="container-fluid">
          <div class="row">
               <div class="col-6">
                    <form method="post">
                         <div class="card card-danger">
                              <div class="card-header ">
                                   <h3 class="card-title">Formulário de edição de usuários...</h3>

                                   <div class="align-items-end" style="margin-left: 86%;">
                                        <button type="submit" class="btn btn-warning">
                                             <i class="fas fa-check"></i> Editar
                                        </button>
                                   </div>

                              </div>
                              <!-- /.card-header -->
                              <div class="card card-primary">

                                  

                                   <div class="alert alert-info alert-dismissible fade show" role="alert">
                                   <strong> <?= $alertaCadastro ?></strong> Por favor digite um nova senha !!!!
                                   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                   </button>
                              </div>


                              <div class="card-body">

                                   <div class="form-group">
                                        <label>Nome</label>
                                        <input type="text" class="form-control" name="nome" disabled value="<?=$usuarios->nome?>">
                                   </div>

                                   <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" disabled value="<?=$usuarios->email?>">
                                   </div>

                                   <div class="form-group">
                                        <label>Senha</label>
                                        <input type="password" placeholder="Senha" id="password" class="form-control" name="senha" required>
                                   </div>

                                   <div class="form-group">
                                        <label>Confirma Senha</label>
                                        <input type="password" placeholder="Confirme Senha" id="confirm_password" class="form-control" required>
                                   </div>
                              </div>
                         </div>

               </div>

          </div>

     </div>
     </form>

     </div>


</section>

</div>
</section>