<?php
require_once 'Configurar.php'; // requiere_once incluye el archivob y si no lo encuentra ROMPE TODO


class DataBase extends mysqli{
    public function __construct(){
    mysqli_connect(parent::__construct(Configurar::$host, Configurar::$user, Configurar::$pass, Configurar::$db));
    if($this->connect_errno){
      die ('Error en la conexion a la base de datos');
    }
  }

    
     /*
    
  public function chequearCampo($tabla, $columna, $valor){
    $query = "SELECT * FROM `$tabla` WHERE `$columna` = '$valor'";
    $sql = $this->query($query);
    $filas = $sql->num_rows;
    return $filas;
  }

  public function getId($tabla, $columna, $valor){
    $query = "SELECT `id` FROM `$tabla` WHERE `$columna` = '$valor'";
    $sql = $this->query($query);
    $id = $sql->fetch_assoc()["id"];
    return $id;
  }
   
public function getLogin($tabla, $columnaEmail, $columnaPass $email, $pass){
    $query = "SELECT `id` FROM `$tabla` WHERE `$columnaEmail` = '$email' and `$columnaPass` = '$pass'";
    $sql = $this->query($query);
    $filas = $sql->num_rows;
    return $filas;
  }*/
      
}

?>