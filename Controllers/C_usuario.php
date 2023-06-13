<?
date_default_timezone_set("America/Lima"); //Zona horaria de Peru
require_once("../Models/M_usuario.php");
class HomeController
{
    private $MODEL;
    public function __construct()
    {

        $this->MODEL = new homeModel();
    }
    public function guardarUsuario($usuario, $contrasena, $email)
    {
        $valor = $this->MODEL->AgregarUsuario($this->Limpiarcadena($usuario), $this->encriptarcontrasen($this->Limpiarcadena($contrasena)), $this->LimpiarEmail($email));
        return $valor;
    }
    public function Limpiarcadena($campo)
    {
        $campo = strip_tags($campo);
        $campo = filter_var($campo, FILTER_UNSAFE_RAW);
        $campo = htmlspecialchars($campo);
        return $campo;
    }
    public function LimpiarEmail($campo)
    {
        $campo = strip_tags($campo);
        $campo = filter_var($campo, FILTER_SANITIZE_EMAIL);
        $campo = htmlspecialchars($campo);
        return $campo;
    }
    public function encriptarcontrasen($contrasena)
    {
        return password_hash($contrasena, PASSWORD_DEFAULT);
    }
}
