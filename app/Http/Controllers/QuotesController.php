<?php

namespace EMMA5\Http\Controllers;

use EMMA5\Quote;
use Illuminate\Http\Request;
use EMMA5\Cat;
use EMMA5\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class QuotesController extends Controller
{
    public function store(Request $request, Cat $cat)
    {
        //        $quote = New Quote();
        //        $quote->quote = $request->quote;
        //        $cat->quotes()->save($quote);

        //Another style
        //        $cat->quotes()->create(
        //            $request->all()
        //        );

        //Yet another style
        //dd($request);
        //dd(Input::all());



        $this->validate($request, [
            'quote' => 'bail|required|min:10',
        ]);
        $quote = new Quote($request->all());
        $user = Auth::user();
        //       flash('Quote saved', 'success');
        if ($cat->addQuote($quote, $user->id)) {
            if ($request->ajax()) {
                return $quote->id;
            } else {
                return back();
            }
            flash()->overlay('Modal Message', 'Modal Title');
        } else {
            return abort(500);
        }
        //TODO find what happens with the validations


//        return back();
    }


    public function edit(Quote $quote)
    {
        return view('quotes.edit', compact('quote'));
    }

    public function update(Request $request, Quote $quote)
    {
        //        return  $request->all();
        $quote->update($request->all());
        flash('Quote updated', 'success');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Cat  $cat
     * @return Response
     */
    public function destroy(Quote $quote, Request $request)
    {
        if ($quote->delete()) {
            if ($request->ajax()) {
                return "Quote deleted successfully";
            }
            $cat_id = $quote->cat->id;

            return redirect('/cats/'.$cat_id)
                ->withSuccess('Quote has been deleted.');
        } else {
            return abort(500);
        }
    }
}
