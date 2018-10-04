<?php

require_once 'Conecta.php';

class Funcionario
{
    private $pdo;

    private $id;

    private $nome;

    private $cpd;

    private $saldo;

    private $status;


    public function __construct()
    {
        $this->pdo = Conecta::getConexao();
    }

    public function getNome()
    {
        return $this->nome;
    }

    protected function setNome($nome)
    {
        $this->nome = $nome;
    }

    protected function setCpd($cpd)
    {
        $this->cpd = $cpd;
    }

    public function getCpd()
    {
        return $this->cpd;
    }

    public function cadastrarNovoFuncionario($Nome,$CPD,$cc)
    {
        $this->setNome($Nome);

        $this->setCpd($CPD);

        if($this->cadastraFuncionarioNovoNoBD($Nome, $CPD,$cc))
        {
            return true;
        }
        else
        {
            return false;
        }
    }


    protected function cadastraFuncionarioNovoNoBD($nome,$cpd,$cc)
    {

        if (!$this->verificaCpd($cpd))
        {
            $sql = "INSERT INTO funcionarios (nome,cpd,id_centro_de_custo) VALUES (:nomefun,:cod,:idCen)";

            $sql = $this->pdo->prepare($sql);

            $sql->bindValue(':nomefun', strtoupper($nome));

            $sql->bindValue(":cod", $cpd);

            $sql->bindValue(":idCen", $cc);

            $sql->execute();

            if ($this->pdo->lastInsertId() > 0)
            {
                return true;
            }
            else
            {
                return false;
            }

        }
        else
        {
            return false;
        }

    }

    protected function verificaCpd($cpd)
    {
        if(isset($cpd) && !empty($cpd))
        {

            $sql = "SELECT * FROM funcionarios WHERE cpd = :cpd";

            $sql = $this->pdo->prepare($sql);

            $sql->bindValue(':cpd', $cpd);

            $sql->execute();

            if ($sql->rowCount() > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }


    public function listarFuncionarios()
    {
        $sql = "SELECT * FROM funcionarios WHERE status = 1 ORDER BY nome ASC";

        $sql = $this->pdo->prepare($sql);

        $sql->execute();

        if($sql->rowCount() > 0)
        {
            return $sql->fetchAll();
        }

    }

    public function listarCentroDeCusto()
    {

        $sql = "SELECT * FROM centro_de_custo";

        $sql = $this->pdo->prepare($sql);

        $sql->execute();

        if($sql->rowCount() > 0)
        {
            return $sql->fetchAll();
        }
    }

    public function consultarHoras($cpd)
    {
        $sql = "SELECT * FROM funcionarios WHERE cpd = ?";

        $sql = $this->pdo->prepare($sql);

        $sql->bindValue(1, $cpd);

        $sql->execute();

        if ($sql->rowCount() > 0)
        {
            return $sql->fetch();
        }

    }

    public function listagemEdicao($cpd){
        $sql = "SELECT * FROM funcionarios WHERE cpd = ?";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(1,$cpd);
        $sql->execute();
        if ($sql->rowCount() > 0){
            return $sql->fetch();
        }
    }

    public function atualizarFuncionario($cpd, $nome, $status, $cdc){
        $sql = "UPDATE funcionarios SET nome = ?, status = ?, id_centro_de_custo = ? WHERE cpd = ?";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(1, strtoupper($nome));
        $sql->bindValue(2, strtoupper($status));
        $sql->bindValue(3, strtoupper($cdc));
        $sql->bindValue(4,strtoupper($cpd));
        $sql->execute();
        if ($sql->rowCount() > 0){
            return true;
        }
        else{
            return false;
        }
    }





}