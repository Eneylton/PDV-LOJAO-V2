<?php 

namespace App\Entidy;

use \App\Db\Database;

use \PDO;


class Usuario{
    

    public $id;

    public $nome;

    public $email;

    public $senha;

    
    public function cadastar(){


        $obdataBase = new Database('usuarios');  
        
        $this->id = $obdataBase->insert([
          
            'nome'         => $this->nome, 
            'email'        => $this->email, 
            'senha'        => $this->senha 

        ]);

        return true;

    }

public static function getVagas($where = null, $order = null, $limit = null){

    return (new Database ('usuarios'))->select($where,$order,$limit)
                                   ->fetchAll(PDO::FETCH_CLASS, self::class);

}

public static function getQuantidadeVagas($where = null){

    return (new Database ('usuarios'))->select($where,null,null,'COUNT(*) as qtd')
                                   ->fetchObject()
                                   ->qtd;

}


public static function getVagasID($id){
    return (new Database ('usuarios'))->select('id = ' .$id)
                                   ->fetchObject(self::class);
 
}

public function atualizar(){
    return (new Database ('usuarios'))->update('id = ' .$this-> id, [

                                               
                                            'nome'         => $this->nome, 
                                            'email'        => $this->email, 
                                            'senha'        => $this->senha 

    ]);
  
}

public function excluir(){
    return (new Database ('usuarios'))->delete('id = ' .$this->id);
  
}


public static function getUsuarioPorEmail($email){

    return (new Database ('usuarios'))->select('email = "'.$email.'"')-> fetchObject(self::class);

}

}