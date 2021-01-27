<?php

namespace App\Http\Controllers;

use App\tipologia;
use Illuminate\Http\Request;

class TipologiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return tipologia::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $colore = new tipologia;
        $colore->titolo = $request->titolo;
        $colore->descrizione = $request->descrizione;
        $colore->save();
        return tipologia::all();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\tipologia  $tipologia
     * @return \Illuminate\Http\Response
     */
    public function show(tipologia $tipologia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tipologia  $tipologia
     * @return \Illuminate\Http\Response
     */
    public function edit(tipologia $tipologia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tipologia  $tipologia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tipologia $tipologia)
    {
        $colore = tipologia::find($request->id);
        $colore->titolo = $request->titolo;
        $colore->descrizione = $request->descrizione;
        $colore->update();
        return tipologia::all();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tipologia  $tipologia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        tipologia::find($request->id)->delete();
        return tipologia::all();
    }
}
