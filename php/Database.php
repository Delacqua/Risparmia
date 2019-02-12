<?php

class Database {

    protected $conn;
    protected $risultato = array();


//----------------------------------------    

    public function __construct() {
        //error_reporting(0);
        
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->database);

        if ($this->conn->connect_errno) {
            http_response_code(500);
            throw new Exception("MySQL error $this->conn->connect_errno", $this->conn->errno);
            exit();
        }
    }

    public function __destruct() {
        $this->conn->close();
    }

//---------------------------------------


    public function verificaLogin ($login) {
      
      $_login = mysqli_real_escape_string($this->conn, $login);

      $result = $this->conn->query("SELECT * FROM sito_login WHERE login='$_login' limit 1");

      //$result = $this->conn->query($sql);

      if (!$result) {
            http_response_code(500);
            error_reporting(0);
            echo "SQL error: ". $this->conn->sqlstate."\n";
            echo "Connection error: ". $this->conn->errno;
            exit();
       } 

      $this->risultato = $result->fetch_all(MYSQLI_ASSOC);
     
        return($this->risultato);
    }


    public function prendeTabella($tabella) {

      $result = $this->conn->query("SELECT * FROM $tabella");

      if (!$result) {
          http_response_code(404);
          throw new Exception("MySQL error", $this->conn->errno);
          exit();
      }
        else {
            $this->risultato = $result->fetch_all(MYSQLI_ASSOC);
        }

          return($this->risultato);
    }

    public function aggiornaTabella2($sql) {

        if(mysqli_query($this->conn, $sql)){
            http_response_code(200);
            return "Aggiornato";

        } else {
            echo "ERROR:  $sql. " . mysqli_error($this->conn);
        }

    }



    public function aggiunge2($sql) {

        if(mysqli_query($this->conn, $sql)){
            http_response_code(200);
            $last_id = $this->conn->insert_id;
            $conferma = (object) ['id' => $last_id];
            return $conferma;
        } 

          else {
              echo "ERROR:  $sql. " . mysqli_error($this->conn);
          }
        
    }

    public function delete($tabella, $id) {

        $sql = "DELETE FROM $tabella WHERE id='$id'";

        if(mysqli_query($this->conn, $sql)){
              http_response_code(200);
              return "Eliminato con successo";
          } else {
              echo "Error $sql. " . mysqli_error($this->conn);
          }

    }

}