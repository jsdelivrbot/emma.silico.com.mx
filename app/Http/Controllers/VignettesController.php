<?php

namespace EMMA5\Http\Controllers;

use EMMA5\Vignette;
use Illuminate\Http\Request;

class VignettesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $vignettes = Vignette::all();
        return view('management.crud.vignettes.index', compact('vignettes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $vignette = new Vignette();
        return view('management.crud.vignettes.create_form', compact('vignette'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //TODO validation
        $vignette = Vignette::create(\Input::all());
        return back(200);
    }

    /**
     * Display the specified resource.
     *
     * @param    Vignette $vignette
     * @return \Illuminate\Http\Response
     */
    public function show(Vignette $vignette)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param    Vignette $vignette
     * @return \Illuminate\Http\Response
     */
    public function edit(Vignette $vignette)
    {
        //
        return view('management.crud.vignettes.edit_form')
            ->with('vignette', $vignette);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param    Vignette $vignette
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vignette $vignette)
    {
        //
        $vignette->update($request->all());
        flash('Viñeta actualizada', 'success')->important();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    Vignette $vignette
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vignette $vignette)
    {
        //
        try {
            $vignette->delete();
        } catch (\Exception $e) {
            return back(550);
        }
        $message = 'Viñeta borrada';
        flash($message, 'info')->important();
        return redirect('vignettes');
    }
}
