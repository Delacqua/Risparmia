<?php

/*
    $ref = $_SERVER['HTTP_REFERER'];

    if($ref !== 'http://www.risparmiafacile.net/db/') {
          http_response_code(401);
          throw new Exception('Access Not Allowed');
            exit;
    }
*/

   //Get a json from angular
    $postdata = json_decode(file_get_contents("php://input"));


    include_once(dirname(__FILE__) . '/urls.php');

    $dataDB = new DatabaseLuce();


   if($_SERVER["REQUEST_METHOD"] == "POST") {
   // username and password sent from form 

      $_login = stripslashes($postdata->login);

      $user = $dataDB->verificaLogin($_login);

      if (count($user)!=1) {
          $outp = (object) ['verifica' => false, 'erro' => 1 ];
      }
        else {
            if ($user[0]['password'] == $postdata->password) {
                $outp = (object) ['verifica' => true, 'user' => $user[0]['nome'] ];
            }
              else {
                $outp = (object) ['verifica' => false, 'erro' => 2 ];
              }
        }

   }



//------------- Risposta  -----------------------

    echo json_encode($outp); //output json

// -------------------------------