<?php

namespace EMMA5\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input as Input;
use EMMA5\Location;

class LocationsController extends Controller
{
    //TODO auth
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $locations = Location::all();
        return view('management.crud.locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function create()
    {
        $location = new Location();
        return view('management.crud.locations.create_form', compact('location'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //TODO validation
        $location = Location::create(Input::all());
        return \Redirect::route('locations.index');
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
     * @param Location $location
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit(Location $location)
    {
        //
        return view('management.crud.locations.edit')
            ->with('location', $location);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Location $location
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(Request $request, Location $location)
    {
        //

        $location->update($request->all());
        flash('Locación actualizada', 'success')->important();

        return redirect('locations');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Location $location
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(Location $location)
    {
        //
        try {
            $location->delete();
        } catch (\Exception $e) {
            return back(550);
        }
        $message = 'Locación borrada';
        flash($message, 'info')->important();
        return redirect('locations');
    }
}
