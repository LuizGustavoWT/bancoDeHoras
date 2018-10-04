<?php

require 'Conecta.php';

class Relatorios
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Conecta::getConexao();
    }

    /*Funcionando*/
    public function saldoPorFucionario()
    {
       $sql = "SELECT cpd,nome,saldo FROM funcionarios WHERE status = 1";
       $sql = $this->pdo->prepare($sql);
       $sql->execute();
       if($sql->rowCount() > 0){
           return $sql->fetchAll(PDO::FETCH_ASSOC);
       }else{
           return 0;
       }
    }

    /*Funcionando*/
    public function saldoPorFuncionarioDecCres($campo, $ordem){
        $campo = addslashes($campo);
        $ordem = addslashes($ordem);
        $sql = "SELECT cpd,nome,saldo FROM funcionarios WHERE status = 1  ORDER BY ".$campo." ".$ordem;
        $sql = $this->pdo->prepare($sql);
        $sql->execute();
        if($sql->rowCount() > 0 ){
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return 0;
        }
    }

    /*Funcionando*/
    public function historicoCpd($cpd){
        $sql = "SELECT
                    funcionarios.nome,
                    centro_de_custo.descricao AS centro_de_custo,
                    tipo_hora.descricao AS tipo_de_hora,
                    usuarios.usuario,
                    historico.qtd_horas,
                    historico.data_mov
                FROM
                    funcionarios,
                    centro_de_custo,
                    tipo_hora,
                    usuarios,
                    historico
                WHERE
                    id_funcionario = funcionarios.id
                    AND id_centro_de_custo = centro_de_custo.id
                    AND id_usuario = usuarios.id
                    AND id_tipo_hora = tipo_hora.id
                    AND funcionarios.cpd = ? ";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(1,$cpd);
        $sql->execute();
        if($sql->rowCount() > 0) {
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        else{
            return 0;
        }

    }

    /*Funcionando*/
    public function historicoNome($nome){
        $like = "'%".addslashes($nome)."%'";
        $sql = "SELECT
                    funcionarios.nome,
                    centro_de_custo.descricao AS centro_de_custo,
                    tipo_hora.descricao AS tipo_de_hora,
                    usuarios.usuario,
                    historico.qtd_horas,
                    historico.data_mov
                FROM
                    funcionarios,
                    centro_de_custo,
                    tipo_hora,
                    usuarios,
                    historico
                WHERE
                    historico.id_funcionario = funcionarios.id
                    AND historico.id_usuario = usuarios.id
                    AND historico.id_tipo_hora = tipo_hora.id
                    AND funcionarios.nome like $like";
        $sql = $this->pdo->prepare($sql);
        $sql->execute();
        if($sql->rowCount() > 0) {
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return array("falha");
        }

    }

    /*Funcionando*/
    public function relatorioCentroDeCusto($cc){
        $sql = "SELECT
                    funcionarios.nome,
                    centro_de_custo.descricao AS centro_de_custo,
                    tipo_hora.descricao AS tipo_de_hora,
                    usuarios.usuario,
                    historico.qtd_horas,
                    historico.data_mov
                FROM
                    funcionarios,
                    centro_de_custo,
                    tipo_hora,
                    usuarios,
                    historico
                WHERE
                    id_funcionario = funcionarios.id
                    AND id_centro_de_custo = centro_de_custo.id
                    AND id_usuario = usuarios.id
                    AND id_tipo_hora = tipo_hora.id
                    AND centro_de_custo.cod_cc like '%?%' ";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(1,$cc);
        $sql->execute();
        if($sql->rowCount() > 0) {
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return 0;
        }
    }

    public  function gerarExcel($ret){
        $nome = md5(time().rand(0,99)).".csv";
        $file = "arquivos/".$nome;
        $f = fopen($file,"a+");

        for($i = 0; $i < count($ret); $i++){

            if ($i == 0) {
                fwrite($f, implode(";", array_keys($ret[$i])) . "\n");
            }
            fwrite($f, implode(";", array_values($ret[$i])) . "\n");

        }
        return $nome;
    }





}