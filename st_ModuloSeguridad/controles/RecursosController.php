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
            $permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_.@ñÑ "; 
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
            
            date_default_timezone_set("America/Lima");

            $dataUser['usuario_nombre'] = $_SESSION['usuario_nombre'];
            $dataUser['usuario_id']     = $_SESSION['usuario_id'];
            $dataUser['usuario_tipo']   = $_SESSION['usuaruio_tipo'];
            $dataUser['USUARIO']        = $_SESSION['USUARIO'];
            $dataUser['Persona']        = $_SESSION['Persona'];
            $dataUser['sistema_id']     = $_SESSION['sistema_id'];

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
                    ?><script>alert("Error al cargar archivo: "<?php echo $_FILES["archivo"]["name"][$key]?>)</script><?php
                    return "Error al cargar archivo: ".$_FILES["archivo"]["name"][$key];
                }else{
                
                    //$permitidos = array("image/*","image/png","application/pdf");
                    $permitidos = array("*");
                    $limite_mb = 8;      
                    
                    $size=$this->TamanioArchivo($_FILES['archivo']['size'][$key]);
                    
                    //in_array($_FILES["archivo"]["type"][$key], $permitidos) &&
                    if($_FILES["archivo"]["size"][$key]/(1024*1024) <= $limite_mb){
                        
                        $data['size_kb'] = round($_FILES["archivo"]["size"][$key]/1024,3);
                        $data['nombre'] = ($_FILES["archivo"]["name"][$key]);
                        /////////
                        //var_dump($data['nombre']);
                        $data['extension'] = ($this->ObtenerExtensionDeArchivo($data['nombre']));
                        ////////
                        $data['fechaRegistro'] = $this->FechaHoraLima();
                        $data['nombreRegistro'] = $data['codigo'].'_'.$data['fechaRegistro'].'_'.$key.'.'.$data['extension'];
                        $source = ($_FILES["archivo"]["tmp_name"][$key]);
                        //var_dump($source);
                        $data['directorio'] = "../st_includes/files/".$data['codigo'].'/';

                        if(!file_exists($data['directorio'])){
                                mkdir($data['directorio'], 0777) or die("No se puede crear el directorio de extracci&oacute;n");	
                        }                

                        $dir=opendir($data['directorio']); //Abrimos el directorio de destino
                        $data['target_path'] = $data['directorio'].$data['nombre']; //Indicamos la ruta de destino, así como el nombre del archivo
                        //var_dump($data['target_path']);
                        if(@move_uploaded_file($source, $data['target_path'])){
                            
                            if($Archivo->RegistrarArchivo($data,$dataUser)){
                               $i++; 
                            }                            
                        } else {	
                            ?><script>alert("Ha ocurrido un error en el archivo: "<?php echo $data['nombre']?>)</script><?php
                            return "Ha ocurrido un error en el archivo: ".$data['nombre'];
                        }
                        closedir($dir);                         
                    }else{
                        //echo round($_FILES["archivo"]['size'][$key]/(1024*1024),2)."<br><br>";
                        ?><script>alert("Tamaño no permitido: "<?php echo $_FILES["archivo"]["name"][$key]?>)</script><?php
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
            
            $para = "aliada.helpdesk@aliada.com.pe";
            $mensaje = $this->FormatoRegistrarTicket($data);
            $titulo = $data['asunto'];
            
            // Para enviar un correo HTML, debe establecerse la cabecera Content-type
            $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
            $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            // Cabeceras adicionales
            $cabeceras .= 'To: Helpdesk System <aliada.helpdesk@aliada.com.pe>' . "\r\n";
            $cabeceras .= 'From: Helpdesk System <aliada.helpdesk@aliada.com.pe>' . "\r\n";
            $cabeceras .= 'Cc: anibal.zambrano@aliada.com.pe, kyoto.flores@aliada.com.pe,miguel.portuguez@aliada.com.pe,lizet.pretel@aliada.com.pe ,luis.burgos@aliada.com.pe ' . "\r\n";
            //$cabeceras .= 'Bcc: anibal.zambrano@aliada.com.pe, kyoto.flores@aliada.com.pe,miguel.portuguez@aliada.com.pe,lizet.pretel@aliada.com.pe ,luis.burgos@aliada.com.pe ' . "\r\n";
            
            if(mail($para,$titulo,$mensaje,$cabeceras)){
                echo "<script>alert('Ha sido reportado a los Adminsitradores');</script>";
            }else{
                echo "<script>alert('no se envió el correo')</script>";
            }

            
        }
        
        public function FormatoRegistrarTicket($data){
            
            $ip     = $data['ip'];
            $usuario= $data['usuario_nombre'];
            $asunto = $data['asunto'];
            $descripcion = html_entity_decode(stripslashes($data['descripcion']));
            
            $mensaje='
                <html>
                <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                <title>Ticket Registrado</title>
                </head>
                <body style="margin:0;padding:0;">
                <table width="100%" align="center" bgcolor="#dfdfdf" cellpadding="0" cellspacing="0" style="text-align:center;font-family:Arial, Helvetica, sans-serif;color:#666666; font-size:12px;">
                <tbody>
                <tr>
                <td>
                    <table width="600" cellpadding="0" cellspacing="0" bgcolor="#e97d7d" align="center" style="font-size:12px;"><tbody>
                    <tr><td height="28" align="center" style="color:#ffffff;">&nbsp;&nbsp;Problemas para visualizar | <a href="https://atheism-dyes.000webhostapp.com/" style="color:#FF0; text-decoration:none;" target="_blank">Visitar web</a></td>
                    </tr>
                    </tbody>
                    </table>
                </td>
                </tr>
                <tr>
                <td>
                <table cellpadding="0" cellspacing="0" width="600" bgcolor="#FFFFFF" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
                <tr><td height="5" bgcolor="#e97d7d"></td></tr>
                <tr><td height="155" align="center" style="font-family:Arial, Helvetica, sans-serif; text-align:center;">
                <p style="color:#666666; font-size:22px; font-weight:700;">'.$asunto.'</p>
                <p style="color:#666666; font-size:16px; width:540px;">'.$descripcion.'</p>
                </td></tr>
                <tr><td>
                <table cellpadding="0" cellspacing="0" width="600">
                <tr>
                  <td width="300"><img src="https://atheism-dyes.000webhostapp.com/medicos.jpg" width="300" height="210" border="0" style="display:block;"></td>
                <td width="300" bgcolor="#ffdfdf">
                <table cellpadding="0" cellspacing="0" width="300">
                <tr><td width="300" bgcolor="#ffc3c3" height="40" style="color:#000000; font-size:15px; padding:0 20px;">Inoformación Adicional</td></tr>
                <tr><td height="170" valign="top" style="color:#666666; font-size:12px; padding:10px 20px 0 20px; line-height:18px;">
                <strong>Usuario: </strong>'.$usuario.'<br>
                <strong>Dirección IP:<strong>'.$ip.'<br>                    
                </td></tr>
                </table>
                </td></tr>
                </table>
                </td></tr>
                <tr><td height="140">
                <table width="180" height="36" cellpadding="0" cellspacing="0" bgcolor="#e97d7d" align="center" style="text-align:center; font-size:16px; border-bottom:3px solid #df5050; text-align:center;"><tr><td>

                <a href="http://10.7.16.3:8080/Intranet/AzvAcceso.jsp" target="_blank" style="color:#FFFFFF; text-decoration:none;">VER TÍCKET</a>
                </td></tr></table><br/>
                <p style="text-align:center; color:#666666; font-size:11px;">*Se ha registrado un Ticket en el sistema, <br>usted puede acceder con sus credenciales de spring para resolver el Ticket.</p>
                </td></tr>
                </table>
                </td>
                </tr>
                <tr><td>
                <table cellpadding="0" cellspacing="0" width="600" bgcolor="#999999" align="center">
                <tr>
                <td height="85" width="30"></td>
                <td height="85" width="465" align="left" style="font-family:Arial, Helvetica, sans-serif; color:#FFFFFF; font-size:12px; text-align:left;">
                <strong style="font-size:14px;">ONCOCARE SAC</strong><br />
                Av. Gálvez Barrenechea 1044, San Isidro -Lima<br />
                Anexos de Sistemas: Jefe: 1700, Lizet: 1701, Soporte: 1703
                </td>
                <td width="30"><a href="https://www.facebook.com/AliadacontraelCancer" target="_blank" style="border:none;"><img src="https://atheism-dyes.000webhostapp.com/facebook.gif" border="0" /></a></td>
                <td width="15"></td>
                <td width="30"><a href="https://www.youtube.com/user/Aliadacontraelcancer" target="_blank" style="border:none;"><img src="https://atheism-dyes.000webhostapp.com/youtube.gif" border="0" /></a></td>
                <td height="80" width="30"></td>
                </tr>
                </table>
                </td></tr>
                </tbody>
                </table>
                </body>
                </html>';
            
            return $mensaje;
            
        }
        
    public function getDatosTransaccion($dataUser){
                
        $data['usuario_id'] = isset($_POST['usuario_id'])?$_POST['usuario_id']:$dataUser['usuario_id'];//$dataUser['usuario_id'];//
        $data['ticket_id']  = isset($_POST['ticket_id'])?$_POST['ticket_id']:NULL;
        $data['hostname']   = $this->getHostName();
        $data['so']         = $this->getSistemaOperativo();
        $data['ip']         = $this->getUserIpAddr();        
        
        return $data;
    }        
}

?>