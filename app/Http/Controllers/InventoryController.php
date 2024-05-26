<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;

class InventoryController extends Controller
{

    // Método para añadir al inventario
    public function addToInventory($data) {

        Inventory::create([
            'product_id' => $data['product_id'],
            'quantity' => $data['quantity'],
            'entry_date' => $data['entry_date'] ?? now()  // Asigna la fecha actual si no se proporciona
        ]);
    
        return true;  // Retorna true para indicar éxito

        // Inventory::create($request->all());
        // return response()->json(['message' => 'Inventory added successfully']);
    }

    // Método para procesar salidas del inventario (FIFO)
    public function removeFromInventory($product_code, $quantity_needed) {
        $inventory_items = Inventory::where('product_id', $product_code)
        ->orderBy('entry_date', 'asc')
        ->get();

        foreach ($inventory_items as $item) {
            if ($quantity_needed <= 0) break;

            $available_quantity = $item->quantity;
            if ($available_quantity > $quantity_needed) {
                $item->quantity -= $quantity_needed;
                $item->save();
                $quantity_needed = 0;
            } else {
                $quantity_needed -= $available_quantity;
                $item->delete(); // Eliminar el registro si el producto ha sido totalmente utilizado
            }
        }

        return response()->json(['message' => 'Inventory processed successfully']);
    }    

} // class
