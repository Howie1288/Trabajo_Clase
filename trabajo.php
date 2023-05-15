<?php
// Este código se utiliza para configurar el manejo de errores en PHP.

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Se define la clase abstracta "CuentaBancaria"
abstract class CuentaBancaria {
    // Se definen los atributos protegidos "$saldo" y "$titular"
    protected $saldo;
    protected $titular;
    
    // Se define el constructor de la clase "CuentaBancaria"
    public function __construct($saldoInicial, $titular) {
        $this->saldo = $saldoInicial;
        $this->titular = $titular;
    }
    
    // Se define el método abstracto "calcularInteres"
    abstract protected function calcularInteres();
    
    // Se define el método estático "getMoneda"
    final public static function getMoneda() {
        return "pesos";
    }
    // Se define el método público "depositar"
    public function depositar($monto) {
        $this->saldo += $monto;
        echo "Se depositó $" . $monto . " en la cuenta de " . $this->titular . "El saldo actual es de $" . $this->saldo . ".";
        echo "<br>";
    }
    // Se define el método público "retirar"
     public function retirar($monto) {
         if ($monto > $this->saldo) {
            echo "No se puede retirar $" . $monto . " de la cuenta de " . $this->titular;
            echo " porque el saldo actual es insuficiente.";
        } else {
            $this->saldo -= $monto;
            echo "Se retiró $" . $monto . " de la cuenta de " . $this->titular . ". El saldo actual es de $" . $this->saldo . ".";
        }
   }
}
// Se define la clase "CuentaCorriente" que extiende de "CuentaBancaria"
class CuentaCorriente extends CuentaBancaria {
    // Se define el atributo protegido "$acuerdo"
    protected $acuerdo;
    
    // Se define el constructor de la clase "CuentaCorriente"
    public function __construct($saldoInicial, $titular, $acuerdo) {
        // Se llama al constructor de la clase padre
        parent::__construct($saldoInicial, $titular);
        $this->acuerdo = $acuerdo;
    }
    
    // Se redefine el método abstracto "calcularInteres" de la clase padre
    protected function calcularInteres() {
        return $this->saldo * 0.02;
    }
    
    // Se redefine el método público "depositar" de la clase padre
    public function depositar($monto) {
        // Se aplica el acuerdo de sobregiro si el monto depositado supera el saldo actual
        if ($monto > $this->saldo) {
            $sobregiro = ($monto - $this->saldo) * $this->acuerdo;
            echo "Se depositó $" . $monto . " en la cuenta de " . $this->titular . ". El saldo actual es de $" . ($this->saldo - $sobregiro) . ".";
        } else {
            parent::depositar($monto);
        }
    }
}

// Se crea una instancia de la clase "CuentaCorriente" con un saldo inicial de $1000, un titular "Howard" y un acuerdo de sobregiro del 10%
$cuentaHoward = new CuentaCorriente(100, "Howard", 0.1);
// Se deposita $500 en la cuenta de Howard
$cuentaHoward->depositar(500);
// Se retiran $200 de la cuenta de Howard
$cuentaHoward->retirar(200);
// Se llama al método estático "getMoneda" de la clase "CuentaBancaria"
echo "<br>La moneda utilizada es: " . CuentaBancaria::getMoneda() . ".";