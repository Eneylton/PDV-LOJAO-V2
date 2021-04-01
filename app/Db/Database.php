<?php

namespace App\Db;

use \PDO;
use \PDOException;

class Database
{

    const HOST = 'localhost';
    const NAME = 'db_pdv2';
    const USER = 'root';
    const PASS = '';


    private $table;

    /**
     * @var PDO
     */
    private $connection;


    public function __construct($table = null)
    {

        $this->table = $table;
        $this->setConnection();
    }

    private function setConnection()
    {

        try {
            $this->connection = new PDO('mysql:host=' . self::HOST . ';dbname=' . self::NAME, self::USER, self::PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {

            die('ERROR: ' . $e->getMessage());
        }
    }


    /**
     * @param string
     * @param array
     * @return PDOStatement
     */

    public function execute($query, $params = [])
    {

        try {
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;
        } catch (PDOException $e) {

            die('ERROR: ' . $e->getMessage());
        }
    }



    public function select($where = null, $order = null, $limit = null, $fields = '*')
    {

        $where = strlen($where) ? 'as p WHERE ' . $where : '';
        $order = strlen($order) ? 'ORDER BY ' . $order : '';
        $limit = strlen($limit) ? 'LIMIT ' . $limit : '';

        $query = 'SELECT ' . $fields . ' FROM ' . $this->table . ' ' . $where . ' ' . $order . ' ' . $limit;

        return $this->execute($query);
    }


    public function rank()
    {

        $query = 'SELECT 
        e.nome AS nome, COUNT(e.produtos_id) AS contagem
                  FROM estatisticas AS e GROUP BY e.nome order by contagem DESC LIMIT 10';

        return $this->execute($query);
    }

    public function despesas()
    {

        $query = 'SELECT sum(e.subtotal) as total FROM estatisticas as e ';

        return $this->execute($query);
    }


    public function receber($where = null, $order = null, $limit = null, $fields = '*')
    {

        $where = strlen($where) ? 'AND ' . $where : '';
        $order = strlen($order) ? 'ORDER BY ' . $order : '';
        $limit = strlen($limit) ? 'LIMIT ' . $limit : '';

        $query = 'SELECT ' . $fields . ' FROM ' . $this->table . ' as p WHERE p.status = 1 ' . $where . ' ' . $order . ' ' . $limit;

        return $this->execute($query);
    }



    public function qtd($where = null, $order = null, $limit = null, $fields = '*')
    {
        $where = strlen($where) ? 'WHERE ' . $where : '';
        $order = strlen($order) ? 'ORDER BY ' . $order : '';
        $limit = strlen($limit) ? 'LIMIT ' . $limit : '';


        $query = 'SELECT ' . $fields . '
        
    FROM
        produtos AS p
            INNER JOIN
            categorias AS c ON (p.categorias_id = c.id)
            ' . $where . ' ' . $order . ' ' . $limit;

        return $this->execute($query);
    }


    public function qtdBaixo($where = null, $order = null, $limit = null, $fields = '*')
    {
        $where = strlen($where) ? ' AND ' . $where : '';
        $order = strlen($order) ? 'ORDER BY ' . $order : '';
        $limit = strlen($limit) ? 'LIMIT ' . $limit : '';


        $query = 'SELECT ' . $fields . '
        
    FROM
        produtos AS p
            INNER JOIN
            categorias AS c ON (p.categorias_id = c.id) WHERE p.estoque <= 3
            ' . $where . ' ' . $order . ' ' . $limit;

        return $this->execute($query);
    }


    public function relacionadas($where = null, $order = null, $limit = null)
    {

        $where = strlen($where) ? 'WHERE ' . $where : '';
        $order = strlen($order) ? 'ORDER BY ' . $order : '';
        $limit = strlen($limit) ? 'LIMIT ' . $limit : '';


        $query = 'SELECT 
        p.id as id,
        p.codigo as codigo,
        p.barra as barra,
        p.data as data,
        p.nome as nome,
        p.foto as foto,
        p.estoque as estoque,
        p.valor_compra as valor_compra,
        p.valor_venda as valor_venda,
        c.nome as categoria
        
    FROM
        produtos AS p
            INNER JOIN
        categorias AS c ON (p.categorias_id = c.id)
        ' . $where . ' ' . $order . ' ' . $limit;

        return $this->execute($query);
    }

    public function baixo($where = null, $order = null, $limit = null)
    {

        $where = strlen($where) ? 'AND ' . $where : '';
        $order = strlen($order) ? 'ORDER BY ' . $order : '';
        $limit = strlen($limit) ? 'LIMIT ' . $limit : '';


        $query = 'SELECT 
        p.id as id,
        p.codigo as codigo,
        p.barra as barra,
        p.data as data,
        p.nome as nome,
        p.foto as foto,
        p.estoque as estoque,
        p.valor_compra as valor_compra,
        c.nome as categoria
        
    FROM
        produtos AS p
            INNER JOIN
        categorias AS c ON (p.categorias_id = c.id) WHERE p.estoque <= 3 ' . $where . '' . $order . ' ' . $limit;

        return $this->execute($query);
    }



    public function insert($values)
    {

        $fields = array_keys($values);
        $binds  = array_pad([], count($fields), '?');

        $query = 'INSERT INTO ' . $this->table . ' (' . implode(',', $fields) . ') VALUE (' . implode(',', $binds) . ')';

        $this->execute($query, array_values($values));

        return $this->connection->lastInsertId();
    }

    public function update($where, $values)
    {

        $fields = array_keys($values);

        $query = 'UPDATE ' . $this->table . ' SET ' . implode('=?,', $fields) . '=? WHERE ' . $where;
        $this->execute($query, array_values($values));
        return true;
    }


    public function delete($where)
    {

        $query = 'DELETE FROM ' . $this->table . ' WHERE ' . $where;
        $this->execute($query);
        return true;
    }

    public function pdf($where = null)
    {

        $where = strlen($where) ? 'WHERE ' . $where : '';


        $query = 'SELECT * FROM ' . $this->table . ' ' . $where . ' ORDER BY id desc';

        return $this->execute($query);
    }

    public function consultar($id)
    {

        $query = 'SELECT * FROM galerias as g WHERE ' . $id;

        return $this->execute($query);
    }
}
