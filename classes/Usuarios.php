<?php
require_once 'Conecta.php';

class Usuarios{
    private $pdo;
    private $id;
    private $usuario;
    private $senha;

    public function __construct(){
        $this->pdo = Conecta::getConexao();
    }

    protected function setId($id){
        $this->id = $id;
    }
    protected function setUsuario($user){
        $this->usuario = $user;
    }

    public function getId(){
        return $this->id;
    }

    public function getUsuario(){
        return $this->usuario;
    }

    public function getSenha(){
        return $this->senha;
    }

    public function cadastrarUsuario($usr,$psw){
        if(!$this->verificarUsuario($usr)){
            $sql = "INSERT INTO usuarios (usuario, senha) VALUES (:usern,:pass)";
            $psw = md5($psw);
            if($this->cadastrarUsuarioBanco($usr,$psw,$sql)){
                return true;
            }else{
                return false;
            }
        }
    }

    public function login($usr,$senha){
        $senha = md5($senha);
        if($this->verificarUsuario($usr)){
            if($this->loginBancoValidar($usr,$senha)){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }


    protected function verificarUsuario($usr){
        $sql = "SELECT * FROM usuarios WHERE usuario = :usr";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":usr",$usr);
        $sql->execute();
        if ($sql->rowCount() > 0){
            return true;
        }
        else{
            return false;
        }
    }

    protected function cadastrarUsuarioBanco($usr,$psw,$sql){
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":usern",$usr);
        $sql->bindValue(":pass",$psw);
        $sql->execute();
        if($this->pdo->lastInsertId() > 0 ){
            return true;
        }
        else{
            return false;
        }
    }

    protected function loginBancoValidar($usr,$psw){
        $sql = "SELECT * FROM usuarios WHERE usuario = :usr AND senha = :pass";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":usr",$usr);
        $sql->bindValue(":pass",$psw);
        $sql->execute();
        if ($sql->rowCount() > 0){
            $dados = $sql->fetch();
            $this->setId($dados['id']);
            $this->setUsuario($dados['usuario']);
            return true;
        }
        else{
            return false;
        }
    }

    public function listarUsers(){
        $test = "SELECT * FROM usuarios WHERE status = ?";
        $test = $this->pdo->prepare($test);
        $test->bindValue(1,1);
        $test->execute();

    }



}