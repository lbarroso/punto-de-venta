<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;  // Incluir Carbon
use App\Models\Venta;

class CashRegisterController extends Controller
{
    
    public function __construct()
    {
        date_default_timezone_set('America/Mexico_City');
    }    

    public function index()
    {
    
        $today = Carbon::today();  // Obtiene la fecha actual

        // Filtrar las transacciones por la fecha de hoy
        $transactions = Transaction::whereDate('created_at', $today)->get();

        // Sumar los montos de las transacciones filtradas
        $totalAmount = $transactions->sum('amount');     
        
        // Filtrar las ventas por la fecha de hoy
        $ventas = Venta::whereDate('created_at', $today)->get();

       // Calcular el total de las ventas de hoy
       $totalSales = $ventas->sum('pvtotal');        

        return view('cash.index', compact('transactions','totalAmount','totalSales'));
    }    
    
    public function startCash(Request $request)
    {


        $transaction = Transaction::create([
            'type' => 'inicio',
            'amount' => $request->amount,
            'description' => 'Inicio de caja'
        ]);

        return back()->with('success','Inicio de caja guardado');
    }    

    public function withdrawCash(Request $request)
    {


        $transaction = Transaction::create([
            'type' => 'retiro',
            'amount' => -$request->amount,
            'description' => $request->description
        ]);

        return back()->with('success','Retiro de caja guardado');
    }

    public function recordSale(Request $request)
    {
  

        $transaction = Transaction::create([
            'type' => 'abono',
            'amount' => $request->amount,
            'description' => 'Abono a caja'
        ]);

        return back()->with('success','Abono de caja guardado');
    }    

} // class
