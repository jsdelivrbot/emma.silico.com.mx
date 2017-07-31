<?php

namespace EMMA5\Http\Controllers;

use EMMA5\Center;
use Illuminate\Http\Request;

class CentersController extends Controller
{
    public function __construct()
    {
        $this->crudView = 'management.crud.centers.';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $centers = Center::orderBy('name')->get();
        return view('management.crud.centers.index', compact('centers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view($this->crudView.'create_form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            [
                'name' => 'required|min:10',
                'short_name' => 'required|min:2'
            ]);
        $this->validate($request, $rules);
        try {
            $center = new Center($request->all());
            $center->save();
        } catch (\Exception $e) {
            flash()->overlay('Error al crear la sede académica', 'Crear sede académica');
        }
        return back(302);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Center $center)
    {
        //
        return view('management.crud.centers.edit_form')->with('center', $center);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Center $center
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Center $center)
    {
        //TODO validation

        $center->update($request->all());

        flash('Sede académica actualizada', 'success')->important();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
