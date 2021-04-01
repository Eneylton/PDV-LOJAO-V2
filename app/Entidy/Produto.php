<?php 

namespace App\Entidy;

use \App\Db\Database;

use \PDO;


class Produto{
    

    public $id;
    public $barra;
    public $codigo;
    public $nome;
    public $qtd;
    public $valor_compra;
    public $valor_venda;
    public $estoque;
    public $status;
    public $foto;
    public $data;
    public $categorias_id;
    public $usuarios_id;
    public $categoria;


    
    public function cadastar(){


        $obdataBase = new Database('produtos');  
        
        $this->id = $obdataBase->insert([
          
            'barra'            => $this->barra, 
            'codigo'           => $this->codigo, 
            'nome'             => $this->nome, 
            'qtd'              => $this->qtd, 
            'valor_compra'     => $this->valor_compra, 
            'valor_venda'      => $this->valor_venda, 
            'estoque'          => $this->estoque, 
            'status'           => $this->status, 
            'foto'             => $this->foto, 
            'categorias_id'    => $this->categorias_id, 
            'usuarios_id'      => $this->usuarios_id 

        ]);

        return true;

    }

public static function getList($where = null, $order = null, $limit = null){

    return (new Database ('produtos'))->select($where,$order,$limit)
                                   ->fetchAll(PDO::FETCH_CLASS, self::class);

}

public static function getRelacinadas($where = null, $order = null, $limit = null){

    return (new Database ('produtos'))->relacionadas($where,$order,$limit)
                                   ->fetchAll(PDO::FETCH_CLASS, self::class);

}


public static function getBaixoEstoque($where = null, $order = null, $limit = null){

    return (new Database ('produtos'))->baixo($where,$order,$limit)
                                   ->fetchAll(PDO::FETCH_CLASS, self::class);

}

public function atualizarPedidos(){
    return (new Database ('produtos'))->update('id = ' .$this-> id, [
 
                                                'valor_compra'      => $this->valor_compra
    ]);
  
}


public static function getQtd($where = null){

    return (new Database ('produtos'))->select($where,null,null,'COUNT(*) as qtd')
                                   ->fetchObject()
                                   ->qtd;

}



public static function qtdCount($where = null){

    return (new Database ('produtos'))->qtd($where,null,null,'COUNT(*) as qtd')
                                   ->fetchObject()
                                   ->qtd;

}

public static function qtdCountBaixo($where = null){

    return (new Database ('produtos'))->qtdBaixo($where,null,null,'COUNT(*) as qtd')
                                   ->fetchObject()
                                   ->qtd;

}


public static function getQtdReal($where = null){

    return (new Database ('produtos'))->relacionadas($where,null,null,'COUNT(*) as qtd')
                                   ->fetchObject()
                                   ->qtd;
}


public static function getID($id){
    return (new Database ('produtos'))->select('id = ' .$id)
                                   ->fetchObject(self::class);
 
}

public function atualizar(){
    return (new Database ('produtos'))->update('id = ' .$this-> id, [

                                               
        'barra'            => $this->barra, 
        'codigo'           => $this->codigo, 
        'nome'             => $this->nome, 
        'qtd'              => $this->qtd, 
        'valor_compra'     => $this->valor_compra, 
        'valor_venda'      => $this->valor_venda, 
        'estoque'          => $this->estoque, 
        'status'           => $this->status, 
        'foto'             => $this->foto,
        'categorias_id'    => $this->categorias_id, 
        'usuarios_id'      => $this->usuarios_id 

    ]);
  
}




public function excluir(){
    return (new Database ('produtos'))->delete('id = ' .$this->id);
  
}


public static function getPdf(){

    return (new Database ('produtos'))->pdf($where = null)
                                   ->fetchAll(PDO::FETCH_CLASS, self::class);

}



}