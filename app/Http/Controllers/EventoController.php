<?php

namespace App\Http\Controllers;

use App\evento;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Http\Controllers\NotificationController;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return view('grimmadmin.page.eventi');
    }
    public function get(Request $request){
        return evento::all();
    }
    public function getNumber($numero)
    {
        //return $numero;
        $response = evento::where('approved',false)->take($numero)->get();
        foreach ($response as $single) {
            $user = User::find($single->user);
            $single->user = $user;
        }

        return $response;
    }
    public function approva(Request $request)
    {
        $ev = evento::find($request->id);
        $ev->approved = true;
        $ev->update();
        $response = evento::where('approved',false)->take($request->numero)->get();
        foreach ($response as $single) {
            $user = User::find($single->user);
            $single->user = $user;
        }
        $req = [
            'testo'=>'É stato approvato l\'evento '.$ev->titolo,
            'modello'=>'evento'
        ];
        $n = new NotificationController();
        $n->nuovaNotifica($req);

        return $response;
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
    public function modifica(evento $evento, $id){
        $evento = evento::find($id);
        return view('grimmadmin/page/nuovo-evento', ['evento' => $evento]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $evento = new evento();
        $evento->titolo = $request->titolo;
        $evento->contenuto = $request->contenuto;
        $evento->indirizzo = $request->indirizzo;
        $evento->lat = $request->lat;
        $evento->lon = $request->lon;
        $evento->data = Carbon::parse($request->data)->toDateTimeString();
        $evento->user = Auth::id();
        if (isset($request->categoria)) {
            $evento->categoria = $request->categoria;
        }
        $file = File::allFiles( public_path().'/storage/temp');
        if (count($file)<1) {
            $evento->save();
            $req = [
                'testo'=>'É stato aggiunto l\'evento '.$evento->titolo,
                'modello'=>'evento'
            ];
            $n = new NotificationController();
            $n->nuovaNotifica($req);
            return 'hey.';
        }
        File::move( public_path().'/storage/temp/'.pathinfo($file[0])['basename'],base_path().'/storage/app/eventi/'.pathinfo($file[0])['basename']);        
        $evento->immagine = '/storage/eventi/'.pathinfo($file[0])['basename'];
        $evento->save();
        $req = [
            'testo'=>'É stato aggiunto l\'evento '.$evento->titolo,
            'modello'=>'evento'
        ];
        $n = new NotificationController();
        $n->nuovaNotifica($req);
        return 'hey.';
    }
    public function elimina(Request $request)
    {
        $ev = evento::find($request->id);
        $req = [
            'testo'=>'É stato eliminato l\'evento '.$ev->titolo,
            'modello'=>'evento'
        ];
        $ev->delete();
        $response = evento::where('approved',false)->take($request->numero)->get();
        foreach ($response as $single) {
            $user = User::find($single->user);
            $single->user = $user;
        }
        
        $n = new NotificationController();
        $n->nuovaNotifica($req);

        return $response;
    }
    public function cancella(Request $request)
    {
        $evento = evento::find($request->alpaca);
        $req = [
            'testo'=>'É stata respinta l\'approvazione dell\'evento '.$evento->titolo,
            'modello'=>'evento'
        ];
        $n = new NotificationController();
        $n->nuovaNotifica($req);
        $evento->delete();
        $all = evento::all();
        return $all;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function show(evento $evento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function edit(evento $evento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $evento = evento::find($id);
        $evento->titolo = $request->titolo;
        $evento->contenuto = $request->contenuto;
        $evento->indirizzo = $request->indirizzo;
        $evento->lat = $request->lat;
        $evento->lon = $request->lon;
        $evento->data = Carbon::parse($request->data)->toDateTimeString();
        $evento->user = Auth::id();
        if (isset($request->categoria)) {
            $evento->categoria = $request->categoria;
        }
        $file = File::allFiles( public_path().'/storage/temp');
        if (count($file)<1) {
            $evento->update();
            return 'hey.';
        }
        File::move( public_path().'/storage/temp/'.pathinfo($file[0])['basename'],base_path().'/storage/app/eventi/'.pathinfo($file[0])['basename']);        
        $evento->immagine = '/storage/eventi/'.pathinfo($file[0])['basename'];
        $req = [
            'testo'=>'É stato aggiornato l\'evento '.$evento->titolo,
            'modello'=>'evento'
        ];
        $n = new NotificationController();
        $n->nuovaNotifica($req);
        $evento->update();
        return 'hey.';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function destroy(evento $evento)
    {
        //
    }
    public function uploadFoto(Request $request)
    {
        if(!$request->hasFile('photos')) {
            return response()->json(['upload_file_not_found'], 400);
        }

        $outsidePath = $request->file('photos');
        if(!$outsidePath->isValid()) {
            return response()->json(['invalid_file_upload'], 400);
        }
        $file = $outsidePath->storeAs('temp', $outsidePath->getClientOriginalName());
        $outsidePath = '/storage/temp/'.$outsidePath->getClientOriginalName();
        return response()->json(compact('outsidePath'));
    }
     public function resettaFoto(Request $request){
        $evento = evento::find($request->id);
        if ($evento->immagine != "/img/EventDefaultPicture.svg") {
            Storage::delete($evento->immagine);
            $evento->immagine = "/img/EventDefaultPicture.svg";
            $evento->update();
        }
        return 'hey.';
    }
}
