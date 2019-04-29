<?php
$serverName = "10.7.48.6";
$connectionInfo = array("Database"=>"DB_TICKET","UID"=>"sa","PWD"=>"0nc0c4r3c\$b","CharacterSet"=>"UTF-8");
$conn = sqlsrv_connect($serverName,$connectionInfo);

$query = "exec DB_Aliada_Production.[ONCO].[SYS_CONSULTAS_USUARIO] @VAROPCION=1,@VARSUBOPCION=0,@USUARIO='anibalzv'";
$result = sqlsrv_query($conn,$query, array(), array('Scrollable' => 'buffered')) or die("error x1");

$datos = (sqlsrv_fetch_array($result));
//var_dump($datos);

    $data['CLAVE']  = $datos['CLAVE'];
    $data['USUARIO']= $datos['USUARIO'];
    $data['NOMBRE'] = $datos['NOMBRE'];
    $data['PERSONA']= $datos['Persona'];
    $data['CMP']    = $datos['CMP'];
    $data['INICIALES']= $datos['INICIALES'];
    //$data['ApellidoPaterno'] = $datos['ApellidoPaterno'];
    //$data['Nombres']    = $datos['Nombres'];

 $clave=$data['CLAVE'];
    $query2 = "select [DB_Aliada_Production].[ONCO].[SF_CLAVE]('$clave')";
    
    $result2 = sqlsrv_query($conn,$query2) or die("Error x2");
    $clave = sqlsrv_fetch_array($result2);
    echo $clave[0];

///////    
// $rpta = "";
// $conta=1;
//        for($i=0;$i< strlen($clave);$i++){
//            $caracter = substr($clave, $i,1);//obtener caracter por caracter        
//            settype($caracter, "integer");
//            echo $caracter."->".gettype($caracter)."<br>";
//            $asc=$caracter; //guarda en la variable $asc
//            $rpta.=($asc-$conta);
//            $conta++;
//        }
//        echo "<br><br>".$rpta;
////        {
//            char letra;
//            letra = varcadena.charAt(i);
//            int asc = (int)letra;
//             varrespuesta += (char)(asc-conta);
//             //varrespuesta += String.valueOf(asc)+"-";
//             conta+=1;
//        }
//        return varrespuesta;
//    