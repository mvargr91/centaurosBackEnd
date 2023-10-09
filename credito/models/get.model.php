<?php

require_once "connection.php";

class GetModel{

      
    //buscamos lista negra
    static public function traerDocumentoListaNegra($documento){       
        
        $sql = "SELECT documento FROM lista_negra WHERE documento = $documento";

        // preparamos la consulta a la base de datos
        $stmt = Connection::connect()->prepare($sql);
        // ejecutamos la consulta a la base de datos
        $stmt ->execute(); 
        // retornamos la respuesta que nos da MySQL con la consulta enviada.
        return $stmt -> fetch(PDO::FETCH_ASSOC);       
        $stmt->closeCursor(); // opcional en MySQL, dependiendo del controlador de base de datos puede ser obligatorio
        $stmt = null; // obligado para cerrar la conexión

    } 
    
        //buscamos usuario
        static public function traerDocumentoUsuario($documento){       
        
            $sql = "SELECT documento FROM usuarios WHERE documento = $documento";
    
            // preparamos la consulta a la base de datos
            $stmt = Connection::connect()->prepare($sql);
            // ejecutamos la consulta a la base de datos
            $stmt ->execute(); 
            // retornamos la respuesta que nos da MySQL con la consulta enviada.
            return $stmt -> fetch(PDO::FETCH_ASSOC);       
            $stmt->closeCursor(); // opcional en MySQL, dependiendo del controlador de base de datos puede ser obligatorio
            $stmt = null; // obligado para cerrar la conexión
    
        }  

    
        //buscamos usuario en sus solicitudes
        static public function envioDatoCredito($documento, $codigo){       
        
            $sql = "SELECT s.documento_usuario , s.cod_solicitud, t.nombre AS 'tipo_producto' , e.nombre AS 'estado_solicitud' , s.fecha 
            FROM solicitudes s
            INNER JOIN estados_solicitud e ON s.estado_solicitud = e.id 
            INNER JOIN tipos_producto t ON s.tipo_producto = t.id
            WHERE s.documento_usuario  = $documento AND s.cod_solicitud = $codigo ";
    
            // preparamos la consulta a la base de datos
            $stmt = Connection::connect()->prepare($sql);
            // ejecutamos la consulta a la base de datos
            $stmt ->execute(); 
            // retornamos la respuesta que nos da MySQL con la consulta enviada.
            return $stmt -> fetch(PDO::FETCH_ASSOC);       
            $stmt->closeCursor(); // opcional en MySQL, dependiendo del controlador de base de datos puede ser obligatorio
            $stmt = null; // obligado para cerrar la conexión
    
        }  


}

