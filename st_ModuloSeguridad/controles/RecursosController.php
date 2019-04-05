<?php

/**
 * 
 */
class RecursosController
{
	
	function __construct()
	{
		# code...
	}


	function ValidarTexto($texto){ 
            //compruebo que el tamaño del string sea válido. 
            if (strlen($texto)<3 || strlen($texto)>20){ 
               //echo $texto . " no es válido<br>"; 
               return false; 
            } 

            //compruebo que los caracteres sean los permitidos 
            $permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_.@ "; 
            for ($i=0; $i<strlen($texto); $i++){ 
               if (strpos($permitidos, substr($texto,$i,1))===false){ 
                  //echo $texto . " no es válido<br>"; 
                  return false; 
               } 
            } 
            //echo $texto . " es válido<br>"; 
            return true; 
        }

        public function getSistemaOperativo(){
            return php_uname();
        }

        public function getHostName(){
            return gethostname();
        }
        
        public function getUserIpAddr(){
            //fuente: https://norfipc.com/web/como-mostrar-direccion-ip-visitantes-paginas-web.php
            
            if(!empty($_SERVER['HTTP_CLIENT_IP'])){
                //IP de un servicio compartido
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
                //IP pass from proxy
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }else{
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            return $ip;                   
        }
        
}

?>