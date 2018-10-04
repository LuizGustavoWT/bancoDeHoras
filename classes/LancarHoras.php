<?php

require_once 'Conecta.php';

class LancarHoras
{
    protected $idUsuario;
    protected $idHora;
    protected $idFuncionario;
    protected $dataMov;
    protected $qtdeHoras;
    protected $id;
    protected $pdo;

    public function __construct()
    {
        $this->pdo = Conecta::getConexao();
    }

    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    public function getIdHora()
    {
        return $this->idHora;
    }

    public function setIdHora($idHora)
    {
        $this->idHora = $idHora;
    }

    public function getIdFuncionario()
    {
        return $this->idFuncionario;
    }

    public function setIdFuncionario($idFuncionario)
    {
        $this->idFuncionario = $idFuncionario;
    }

    public function getDataMov()
    {
        return $this->dataMov;
    }

    protected function setDataMov($dataMov)
    {
        $this->dataMov = $dataMov;
    }

    public function getQtdeHoras()
    {
        return $this->qtdeHoras;
    }

    public function setQtdeHoras($qtdeHoras)
    {
        $this->qtdeHoras = $qtdeHoras;
    }

    public function getId()
    {
        return $this->id;
    }

    protected function setId($id)
    {
        $this->id = $id;
    }

    public function lancarHoras($qtdeHoras,$idFuncionario, $idUsuario, $tipoDeHora,$cpd)
    {
        $sql = "INSERT INTO historico (id_funcionario, data_mov, qtd_horas, id_tipo_hora, id_usuario) VALUES (?, NOW(),?,?,?)";

        $sql =$this->pdo->prepare($sql);

        $sql->bindValue(1, $idFuncionario);

        $sql->bindValue(2, $qtdeHoras);

        $sql->bindValue(3, $tipoDeHora);

        $sql->bindValue(4, $idUsuario);


        $sql->execute();

        if ($this->pdo->lastInsertId() > 0)
        {
            if($this->gravarSaldo($cpd,$tipoDeHora,$qtdeHoras))
            {
                return true;
            }
            else
            {
                $id = $this->pdo->lastInsertId();
                $sql = "DELETE FROM historico WHERE id = ?";
                $sql = $this->pdo->prepare($sql);
                $sql->bindValue(1, $id);
                $sql->execute();
                return false;
            }

        }
        else
        {
            return false;
        }


    }

    public function listarHoras()
    {
        $sql = "SELECT * FROM tipo_hora";

        $sql = $this->pdo->prepare($sql);

        $sql->execute();

        if ($sql->rowCount() > 0)
        {
            return $sql->fetchAll();
        }
    }

    public function listarHoras2($tipo)
    {
        $sql = "SELECT * FROM tipo_hora WHERE id = ?";

        $sql = $this->pdo->prepare($sql);

        $sql->bindValue(1,$tipo);

        $sql->execute();

        if ($sql->rowCount() > 0)
        {
            return $sql->fetch();
        }
    }

    public function gravarSaldo($cpd, $tipo, $qtde)
    {
        $ret = $this->listarHoras2($tipo);

        $qtde1 = $this->calcularSegundos($qtde);

        $sql = "UPDATE funcionarios SET saldo = SEC_TO_TIME(TIME_TO_SEC(saldo) + ?) WHERE cpd = ?";

        $sql = $this->pdo->prepare($sql);

        $sql->bindValue(1, ($qtde1*$ret['porcentagem']));

        $sql->bindValue(2, $cpd);

        $sql->execute();

        if($sql->rowCount() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }


    }

    public function consultarHoras($cpd)
    {
        $sql = "SELECT SEC_TO_TIME(saldo) AS segundos FROM funcionarios WHERE cpd = ?";

        $sql = $this->pdo->prepare($sql);

        $sql->bindValue(1, $cpd);

        $sql->execute();

        if ($sql->rowCount() > 0)
        {
            return $sql->fetch();
        }

    }

    protected function calcularSegundos($qtHoras){

        list($horas,$minutos) = explode(":",$qtHoras);

        return ($horas*60*60) + ($minutos*60);

    }

    public function listarLancamento($cpd){
        $sql = "SELECT
                  tipo_hora.descricao AS tipo_de_hora, 
                  historico.qtd_horas, 
                  historico.data_mov,
                  tipo_hora.porcentagem,
                  historico.id AS id_historico,
                  funcionarios.id
                FROM 
                  funcionarios, 
                  centro_de_custo, 
                  tipo_hora, 
                  historico
                WHERE
                  historico.id_funcionario = funcionarios.id
                  AND id_centro_de_custo = centro_de_custo.id
                  AND id_tipo_hora = tipo_hora.id
                  AND funcionarios.cpd = ?
                  ORDER BY historico.data_mov
                  desc limit 10";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(1,$cpd);
        $sql->execute();
        if ($sql->rowCount() > 0){
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        else{
            return array("Falha");
        }
    }

    public function corrigirLancamento($qtdeHoras,$idHistorico, $porcentagem, $cpd){
        $sec = $this->calcularSegundosCorrige($qtdeHoras);


        if($this->gravarSaldoCorrige($porcentagem,$cpd,$sec))
        {

            $sql = "DELETE FROM historico WHERE id = ?";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(1,$idHistorico);
            $sql->execute();
            if ($sql->rowCount() > 0){
                return true;
            }
            else{
                return false;
            }
        }
        else
        {
            return false;
        }

    }

    protected function calcularSegundosCorrige($tempo){
        $tempoArr = explode(":",$tempo);

        list($horas, $minutos, $segundos) = $tempoArr;

        return ($horas*60*60) + ($minutos*60) + $segundos;
    }

    protected function gravarSaldoCorrige($porcentagem, $cpd, $qtde){
        $sql = "UPDATE funcionarios SET saldo = SEC_TO_TIME(TIME_TO_SEC(saldo) + ?) WHERE cpd = ?";

        $sql = $this->pdo->prepare($sql);

        $sql->bindValue(1, ($qtde*($porcentagem*-1)));

        $sql->bindValue(2, $cpd);

        $sql->execute();

        if($sql->rowCount() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}