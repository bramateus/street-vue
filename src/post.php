<?php
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");
header('content-type: application/json; charset=utf-8');


$_POST = json_decode(file_get_contents("php://input"),true);
echo $_POST;

print_r($_REQUEST);
print_r($_POST);



define('MYSQL_HOST', 'localhost');
define('MYSQL_USER', 'root');
define('MYSQL_PASSWORD', '');
define('MYSQL_DB_NAME', 'synapselabs_db');

// define( 'MYSQL_HOST', 'pleskdb.cxt9ad1y00cb.us-east-1.rds.amazonaws.com' );
// define( 'MYSQL_USER', 'synapselabs_user' );
// define( 'MYSQL_PASSWORD', 'pUji9&07' );
// define( 'MYSQL_DB_NAME', 'synapselabs_db' );

$sqlconex = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB_NAME);
mysqli_set_charset ($sqlconex, 'utf8');

// $sqlcamp = "SELECT * FROM campanha WHERE id_campanha = " . $campanha;
// $resultcamp = mysqli_query($sqlconex, $sqlcamp);
// $rowscamp = $resultcamp->fetch_assoc();
// $status = $rowscamp['campanha_status'];


        $now = gmdate("Y-m-d H:i:s", time() + 3600 * (-3 + date("I")));
        $sql
            = "INSERT INTO matricula (
                  matricula_instituicao,
                  matricula_codigo,
                  matricula_nome,
                  matricula_email,
                  matricula_celular,
                  matriculaCurso_area,
                  matricula_cidade,
                  matricula_tipo,
                  matricula_dataCadastro
              ) VALUES (
                  '{$universidade}',
                  '{$campanha}',
                  '{$_REQUEST['NomeCompleto']}',
                  '{$_REQUEST['Email']}',
                  '{$_REQUEST['Telefone']}',
                  '{$_REQUEST['AreaPretendida']}',
                  '{$_REQUEST['Estado']}',
                  'lp',
                  '{$now}'
              )";



        if (mysqli_query($sqlconex, $sql)) {
            //echo "New record created successfully";
            $lastid = mysqli_insert_id($sqlconex);
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($sqlconex);
        }