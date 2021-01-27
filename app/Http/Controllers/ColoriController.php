<?php

namespace App\Http\Controllers;

use App\colori;
use Illuminate\Http\Request;

class ColoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return colori::all();
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
        $colore = new colori;
        $colore->titolo = $request->titolo;
        $colore->descrizione = $request->descrizione;
        $colore->save();
        return colori::all();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\colori  $colori
     * @return \Illuminate\Http\Response
     */
    public function show(colori $colori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\colori  $colori
     * @return \Illuminate\Http\Response
     */
    public function edit(colori $colori)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\colori  $colori
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, colori $colori)
    {
        $colore = colori::find($request->id);
        $colore->titolo = $request->titolo;
        $colore->descrizione = $request->descrizione;
        $colore->update();
        return colori::all();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\colori  $colori
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        colori::find($request->id)->delete();
        return colori::all();
    }
}
