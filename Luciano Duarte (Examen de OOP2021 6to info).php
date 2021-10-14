<?php

interface Mensaje{
    public function contenido();
    public function fecha();
    public function emisor();
}

interface Grupo{
    public function agregarUsuario(Usuario $usuario);
    public function quitarUsuario(Usuario $usuario);
    public function enviarMensaje(Mensaje $mensaje);
    
}


interface Usuario{
    public function enviarMensajeAUsuario(Usuario $u, Mensaje $m);
    public function enviarMensajeAGrupo(Grupo $grupo, Mensaje $m);
    public function recibirMensaje(Mensaje $mensaje);
}


/*---------------------------------------------------------*/


class Persona implements Usuario{
    
    protected $name;
    protected $id;
    
    public function __construct($nombre, $id){
        $this->name = $nombre;
        $this->id = $id;
        
    }
    
    public function enviarMensajeAUsuario(Usuario $u, Mensaje $m){
        
        $u -> recibirMensaje($m);
        
    }

    public function enviarMensajeAGrupo(Grupo $grupo, Mensaje $m){
        $grupo-> enviarMensaje($m);
        
    }

    public function recibirMensaje(Mensaje $mensaje){
        
        print($this->name . " Recibio el siguiente Mensaje: " .$mensaje->contenido());
        
    }
    
    
    
    public function Identificador(){
        return $this->id;
        
    }
}


class Group implements Grupo{
    protected $fila = [];
    
    
    public function agregarUsuario(Usuario $usuario){
        
        
        $this-> lista[$usuario->identificador()] = $usuario;
    }
    
    public function quitarUsuario(Usuario $usuario){
        
        unset($this->lista[$usuario->identificador()]);
        
    }
    public function enviarMensaje(Mensaje $mensaje){
        
        foreach ($this->lista as $elemento){
            if($elemento != $mensaje->emisor())
                $elemento->recibirMensaje($mensaje);
        }
        
    }
    
  /*   public function mostrarParticipantes(){
        foreach($this->lista as $elemento){
            print ($elemento->Identificador());
        }
    }
    */
}



class Msg implements Mensaje{
    
    protected $cont;
    protected $emisario;
    protected $fecha;
    
    public function __construct($str, $user){
        $this->cont = $str;
        $this->emisario = $user;
        $this->fecha = date('Y-m-d: h:i:s');
    }
    
    
    
    public function contenido(){
        return $this-> cont;
    }
    
    
    
    public function fecha(){
        
        return $this->fecha;
    }
    
    
    
    public function emisor(){
        
        return $this->emisario;
        
    }
    
}    


class Empresa extends Persona{
    
    protected $mensajeauto;
    
    
    public function __construct($nombre, $id){
        $this->name = $nombre;
        $this->id = $id;
        $this->mensajeauto = new Msg("Responderemos a la brevedad. Gracias por su mensaje",$this);
    }
        
    
    public function recibirMensaje(Mensaje $mensaje){
print($this->name . " Recibio el siguiente Mensaje: " .$mensaje->contenido());
$mensaje->emisor()->recibirMensaje($this->mensajeauto);
        
    }
    
}

/*--------------------------------------------------------- */


//  EJERCICIO 1:

$ali = new Persona("Alicia", 1);
$Escuela = new Group();
$Robert = new Persona("Roberto", 2);
$Dami = new Persona("Damian", 3);


$msg1 = new Msg("Nos vemos en la puerta \n", $ali);



$Escuela->agregarUsuario($ali);
$Escuela->agregarUsuario($Robert);
$Escuela->agregarUsuario($Dami);

$ali->enviarMensajeAGrupo($Escuela,$msg1);



//EJERCICIO 2: 

$msg2 = new Msg("Trae la guitarra \n",$Dami);

$Dami->enviarMensajeAUsuario($Robert,$msg2);


//EJERCICIO 3: 

$emp = new Empresa("RemerasOk",4);
$msg3 = new Msg("Hola cuanto cuesta la remera? \n",$ali);
$ali->enviarMensajeAUsuario($emp,$msg3);
print (" \n");


//EJERCICIO 4:

/* 
a) Clase: una clase se puede definir como un molde donde se detallan las propiedades,metodos especificos de cada tipo de clase.


b) Interfaz: La interfaz define los metodos minimos necesarios que deben poseer las clases que implementan dicha interfaz.


c) Objeto: Un objeto es una intancia de una clase especifica el cual es creado y dicho objeto posee las caracteristicas del molde(la clase).

*/


/* --------------------------------------------------------- */


//TESTEOS DE LOS DEMAS METODOS NO USADOS EN LA EVALUACION:

//print ($msg3->emisor()->Identificador());

//$Escuela->mostrarParticipantes(); (METODO COMENTADO EN LA CLASE GRUPO, RECORDAR DESCOMENTARLO PARA USAR EL CASO DE PRUEBA)

//$Escuela->quitarUsuario($ali);

//print ("\n");

//$Escuela->mostrarParticipantes();


/* --------------------------------------------------------- */




?>
