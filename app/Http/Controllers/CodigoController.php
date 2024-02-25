<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Codigo;
use Illuminate\Http\Request;

/**
 * Class CodigoController
 * @package App\Http\Controllers
 */
class CodigoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $codigos = Codigo::paginate();

        return view('codigo.index', compact('codigos'))
            ->with('i', (request()->input('page', 1) - 1) * $codigos->perPage());
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $codigo = new Codigo();
        return view('codigo.create', compact('codigo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Codigo::$rules);

        $codigo = Codigo::create($request->all());

        return redirect()->route('codigos.index')
            ->with('success', 'Codigo created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $product = Product::find($id);

        $codigos = Codigo::where('product_id',$id)->orderBy('id', 'asc')->paginate(15);
        
        return view('codigo.index', compact('product','codigos') );

        /*
        $codigo = Codigo::find($id);

        return view('codigo.show', compact('codigo'));
        */
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $codigo = Codigo::find($id);

        return view('codigo.edit', compact('codigo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Codigo $codigo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Codigo $codigo)
    {
        request()->validate(Codigo::$rules);

        $codigo->update($request->all());

        return redirect()->route('codigos.index')
            ->with('success', 'Codigo updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $codigo = Codigo::find($id)->delete();

        return redirect()->route('codigos.show/'.$id)
            ->with('success', 'Codigo deleted successfully');
    }
}
