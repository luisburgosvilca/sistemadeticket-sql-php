<?php

include_once('../st_ModuloSeguridad/Conexion.php');
class Archivo extends Conexion {
    
    public function RegistrarArchivo($data,$dataUser){
        
        $nombre         = $data['nombre'];
        //$nombreRegistro = $data['nombreRegistro'];
        $size_kb        = $data['size_kb'];
        $url_file       = $data['target_path'];
        $ticket_id      = $data['ticket_id'];
        $extension      = $data['extension'];
        $usuario_id     = $dataUser['USUARIO'];
        
        $conn = $this->AbrirConexion();
        
            $query = "INSERT INTO st_file (nombre, url_file, size_kb,fechaRegistro,usuario_id, ticket_id, extension)
                        values ('$nombre','$url_file','$size_kb',GETDATE(),'$usuario_id','$ticket_id','$extension')";
            //$result = mysqli_query($cn,$query) or die(mysqli_errno($cn).": ".mysqli_error($cn));
            $result = sqlsrv_query($conn,$query) or die("Error x1: Archivo");
            
            return ($result);
            
        $this->CerrarConexion($result, $conn);            
    }
    
}