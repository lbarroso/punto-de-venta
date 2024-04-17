<?php

namespace App\Http\Controllers;
use App\Models\Cierre;
use App\Models\Venta;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CierreController extends Controller
{
    //
    public function index()
    {
        $today = Carbon::today();

        // Total de ventas de hoy
        $ventasDiarias = Venta::whereDate('created_at', $today)->sum('pvtotal');        

        // Inicio de caja de hoy
        $inicio = Transaction::where('type', 'inicio')
        ->whereDate('created_at', $today)
        ->sum('amount'); // Asumiendo que se registra como un monto positivo


        // Total entradas de hoy
        $totalEntradas = Transaction::where('type', 'abono')
        ->whereDate('created_at', $today)
        ->sum('amount');

        // Total salidas de hoy
        $totalSalidas = Transaction::where('type', 'retiro')
        ->whereDate('created_at', $today)
        ->sum('amount');                                    

        // Saldo anterior, asumiendo que 'cierre' guarda el último saldo al final del día
        $saldoAnterior = Cierre::orderBy('created_at', 'desc')
        ->first()
        ->saldo ?? 0;

        // Sumar los montos de las transacciones filtradas
        $totalAmount = Transaction::whereDate('created_at', $today)
        ->sum('amount');    
        
        $saldoActual = $totalAmount + $ventasDiarias;

        return view('cash.cierre',compact('saldoActual','inicio','saldoAnterior','ventasDiarias','totalEntradas','totalSalidas'));
    }

    public function store(Request $request)
    {
        $today = Carbon::today();  // Obtiene la fecha actual

        // Verificar si ya existe un cierre para hoy
        $cierreExistente = Cierre::whereDate('created_at', $today)->first();
        if ($cierreExistente) {
            return redirect()->back()->withErrors('Ya se ha registrado el cierre para hoy.');
        }

        $cierre = Cierre::create([
            'saldo_anterior' => $request->saldo_anterior,
            'entrada' => $request->entrada,
            'salida' => $request->salida,
            'venta' => $request->venta,
            'saldo_actual' => $request->saldo_actual
        ]);

        // Redireccionar o responder de acuerdo al resultado
        if ($cierre) {
            // Puedes redireccionar a una ruta específica o, por ejemplo, devolver una respuesta JSON.
            return redirect()->route('cierre.index')->with('success', 'Cierre guardado correctamente.');
        } else {
            return back()->withInput()->withErrors(['msg' => 'Error al guardar el cierre']);
        }

    } // function

    public function ticket(Request $request)
    {

    } 

    public function sendEmeail()
    {

    }        

} // class
