<?php

/**
 * 
 */
include_once('../st_ModuloSeguridad/vistas/Pagina.php');
class RecursosController extends Pagina
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
        
        public function getUsuario(){

            $dataUser['usuario_nombre'] = $_SESSION['usuario_nombre'];
            $dataUser['usuario_id']     = $_SESSION['usuario_id'];
            $dataUser['usuario_tipo']   = $_SESSION['usuaruio_tipo'];
            $dataUser['USUARIO']        = $_SESSION['USUARIO'];
            $dataUser['Persona']        = $_SESSION['Persona'];

            return $dataUser;
        }       
        
        public function RegistrarArchivo($data,$dataUser){
            
            //var_dump($_FILES["archivo"]['tmp_name']);
            $i=0;
            
            include_once('../st_ModuloSeguridad/entidades/Archivo.php');
            $Archivo = new Archivo();
            
            foreach($_FILES["archivo"]['tmp_name'] as $key => $tmp_name)
            {                
                if($_FILES["archivo"]["error"][$key]>0){
                    return "Error al cargar archivo: ".$_FILES["archivo"]["name"][$key];
                }else{
                
                    //$permitidos = array("image/*","image/png","application/pdf");
                    $permitidos = array("*");
                    $limite_mb = 8;      
                    
                    $size=$this->TamanioArchivo($_FILES['archivo']['size'][$key]);
                    
                    //in_array($_FILES["archivo"]["type"][$key], $permitidos) &&
                    if($_FILES["archivo"]["size"][$key]/(1024*1024) <= $limite_mb){
                        
                        $data['size_kb'] = round($_FILES["archivo"]["size"][$key]/1024,3);
                        $data['nombre'] = $_FILES["archivo"]["name"][$key];
                        /////////
                       
                        $data['extension'] = ($this->ObtenerExtensionDeArchivo($data['nombre']));
                        ////////
                        $data['fechaRegistro'] = $this->FechaHoraLima();
                        $data['nombreRegistro'] = $data['codigo'].'_'.$data['fechaRegistro'].'_'.$key.'.'.$data['extension'];
                        $source = $_FILES["archivo"]["tmp_name"][$key];

                        $data['directorio'] = "../st_includes/files/".$data['codigo'].'/';

                        if(!file_exists($data['directorio'])){
                                mkdir($data['directorio'], 0777) or die("No se puede crear el directorio de extracci&oacute;n");	
                        }                

                        $dir=opendir($data['directorio']); //Abrimos el directorio de destino
                        $data['target_path'] = $data['directorio'].$data['nombre']; //Indicamos la ruta de destino, así como el nombre del archivo

                        if(@move_uploaded_file($source, $data['target_path'])){
                            
                            if($Archivo->RegistrarArchivo($data,$dataUser)){
                               $i++; 
                            }                            
                        } else {	
                            return "Ha ocurrido un error en el archivo: ".$data['nombre'];
                        }
                        closedir($dir);                         
                    }else{
                        //echo round($_FILES["archivo"]['size'][$key]/(1024*1024),2)."<br><br>";

                        return "El archivo:".$_FILES["archivo"]['name'][$key]." supera el tamaño permitido de 8 mb: ".$size['NUM'].' '.$size['UND']." <br>";
                    }                    
                }     
                
            }
//            var_dump($i);
//            echo "-";
//            var_dump($data['count']);
            if($data['count']==$i){
                return TRUE;
            }
            else{
                return FALSE;
            }            
        }
        
        public function FechaHoraLima(){
            date_default_timezone_set('America/Lima');
            return date("Y-m-d H:i:s");
        }

        public function EnviarEmail($data){
            
            
            
        }
}

?>