<?php
namespace EMMA5\Http\Controllers;

use EMMA5\Http\Requests;
use EMMA5\Http\Controllers\Controller;

use EMMA5\Micropost;
use Illuminate\Http\Request;

class MicropostController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $microposts = Micropost::orderBy('id', 'desc')->paginate(10);

        return view('microposts.index', compact('microposts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('microposts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $micropost = new Micropost();

        $micropost->title = $request->input("title");
        $micropost->body = $request->input("body");

        $micropost->save();

        return redirect()->route('microposts.index')->with('message', 'Item created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $micropost = Micropost::findOrFail($id);

        return view('microposts.show', compact('micropost'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $micropost = Micropost::findOrFail($id);

        return view('microposts.edit', compact('micropost'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $micropost = Micropost::findOrFail($id);

        $micropost->title = $request->input("title");
        $micropost->body = $request->input("body");

        $micropost->save();

        return redirect()->route('microposts.index')->with('message', 'Item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $micropost = Micropost::findOrFail($id);
        $micropost->delete();

        return redirect()->route('microposts.index')->with('message', 'Item deleted successfully.');
    }
}
