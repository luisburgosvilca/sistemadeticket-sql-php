<?php

class LlenarFormularioDeRegistroPartials{
    
    public function LlenarFormulario($data,$dataUser){
        
        $datos = array(
            'IdAseguradora' => $data['IdAseguradora'],
            'aseguradora'   => $data['aseguradora'],
            'nombrePaciente'=> $data['nombrePaciente'],
            'paciente'      => $data['paciente'],
            'IdGarantia'    => $data['IdGarantia'],
            'fechaRegistro' => $data['fechaRegistro'],
            'usuario'       => $dataUser['USUARIO']
        );
        
        echo json_encode($datos);
                
    }
    
}