<?php

namespace App\Http\Controllers;


use App\alpaca;
use Auth;
use Illuminate\Http\Request;
use App\colori;
use App\tipologia;
use App\allevamento;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\NotificationController;


class AlpacaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('grimmadmin.page.alpaca');
        
    }
    public function get(Request $request){
        $skip = $request->pag;
        
        $alpacas = alpaca::skip($skip)->take(3)->orderBy('created_at', 'DESC')->get();
        foreach ($alpacas as $alpaca) {
            if ($alpaca->allevatore > 0) {
               $allevamento = allevamento::find($alpaca->allevatore);
               $alpaca->allevatore = $allevamento;
            }else{
                $alpaca->allevatore = (object) [
                    'id'=>0,
                    'immagine'=>"/img/NoAllevamento.svg",
                    'nome'=>"L'allevamento non é presente nel DataBase"
                ];
            };
        }
        return $alpacas;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        

    }
    public function getGeneralData()
    {
        $colori = colori::all(); 
        $tipologie = tipologia::all();  
        return view('grimmadmin/page/nuovo-alpaca', ['colori' => $colori, 'tipologie' => $tipologie,'alpaca' => null]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $allevamento = ($request->allevamento != 0) ? $request->allevamento : null ;
        $userId = Auth::user()->id;
        $nuovo_alpaca = new alpaca();
        $nuovo_alpaca->nome = $request->nome;
        $nuovo_alpaca->dna = $request->nome;
        $nuovo_alpaca->colore = $request->colore;
        $nuovo_alpaca->madre = $request->madre;
        $nuovo_alpaca->padre = $request->padre;
        $nuovo_alpaca->allevatore = $allevamento;
        $nuovo_alpaca->nascita = Carbon::parse($request->nascita)->toDateTimeString();
        $nuovo_alpaca->morte = Carbon::parse($request->morte)->toDateTimeString();
        $nuovo_alpaca->tipologia = $request->tipo;
        if (strlen($request->microchip)) {
            $nuovo_alpaca->microchip = $request->microchip;
        }
        $nuovo_alpaca->sesso = $request->sesso;
        $file = File::files( public_path().'/storage/temp/'.$userId);
        if (count($file)>0) {
            File::makeDirectory(base_path().'/storage/app/alpaca', 0775, true, true);
            File::move( public_path().'/storage/temp/'.$userId.'/'.pathinfo($file[0])['basename'],base_path().'/storage/app/alpaca/'.pathinfo($file[0])['basename']);
            $nuovo_alpaca->immagine = '/storage/alpaca/'.pathinfo($file[0])['basename'];
        }
        if (!File::isDirectory(public_path().'/storage/temp/'.$userId.'/galleria/alpaca')) {
            try{
                 $nuovo_alpaca->save(); 
            }catch(\Exception $e){
               // do task when error
                   return $e->errorInfo[1];   // insert query
            }
            $req = [
                'testo'=>'Ha aggiunto un alpaca di nome '.$nuovo_alpaca->nome,
                'modello'=>'alpaca'
            ];
            $n = new NotificationController();
            $n->nuovaNotifica($req);
            return 'hey.';
        }
        $file = File::files( public_path().'/storage/temp/'.$userId.'/galleria/alpaca');
        if (count($file)<1) {
            try{
                 $nuovo_alpaca->save(); 
            }catch(\Exception $e){
               // do task when error
                   return $e->errorInfo[1];   // insert query
            }
            $req = [
                'testo'=>'Ha aggiunto un alpaca di nome '.$nuovo_alpaca->nome,
                'modello'=>'alpaca'
            ];
            $n = new NotificationController();
            $n->nuovaNotifica($req);
            return 'hey.';
        }
        $gallery = array();
        foreach ($file as $singleFile) {
           File::move( $singleFile,base_path().'/storage/app/alpaca/'.pathinfo($singleFile)['basename']); 
           array_push($gallery, '/storage/alpaca/'.pathinfo($singleFile)['basename']);
        }
        $nuovo_alpaca->galleria = json_encode($gallery);
        try{
           $nuovo_alpaca->save(); 
        }catch(\Exception $e){
       // do task when error
           return $e->errorInfo[1];   // insert query
        }

        $nuovo_alpaca->save();
        $req = [
            'testo'=>'Ha aggiunto un alpaca di nome '.$nuovo_alpaca->nome,
            'modello'=>'alpaca'
        ];
        $n = new NotificationController();
        $n->nuovaNotifica($req);

        return 'hey.';
    }
    public function getAlpacaFromName($ricerca, Request $request){
        if ($request->sex == '0') {
            $resp = alpaca::cercaConNome('nome',$ricerca)->separaMaschi()->get();
            return $resp;
        }else if($request->sex == '1'){
            return alpaca::cercaConNome('nome',$ricerca)->separaFemmine()->get();
        }
        return alpaca::cercaConNome('nome',$ricerca)->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\alpaca  $alpaca
     * @return \Illuminate\Http\Response
     */
    public function show(alpaca $alpaca)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\alpaca  $alpaca
     * @return \Illuminate\Http\Response
     */
    public function modifica(alpaca $alpaca, $id)
    {
        $alpaca = alpaca::find($id);
        $colore = colori::find($alpaca->colore);
        $alpaca->colore = $colore;
        if ($alpaca->padre > 0) {
           $padre = alpaca::find($alpaca->padre);
           $alpaca->padre = $padre;
        }else{
            $alpaca->padre = (object) [
                'id'=>0,
                'immagine'=>"/img/NoAlpaca.svg",
                'nome'=>"Il Padre non é presente nel DataBase"
            ];
        }
        if ($alpaca->madre > 0) {
           $madre = alpaca::find($alpaca->madre);
           $alpaca->madre = $madre;
        }else{
            $alpaca->madre = (object) [
                'id'=>0,
                'immagine'=>"/img/NoAlpaca.svg",
                'nome'=>"La madre non é presente nel DataBase"
            ];
        }
        if ($alpaca->allevatore > 0) {
           $allevamento = allevamento::find($alpaca->allevatore);
           $alpaca->allevatore = $allevamento;
        }else{
            $alpaca->allevatore = (object) [
                'id'=>0,
                'immagine'=>"/img/NoAllevamento.svg",
                'nome'=>"L'allevamento non é presente nel DataBase"
            ];
        };
        $alpaca->sesso = $this->completeSesso($alpaca->sesso);

        $colori = colori::all(); 
        $tipologie = tipologia::all(); 
        return view('grimmadmin/page/nuovo-alpaca', ['colori' => $colori, 'tipologie' => $tipologie, 'alpaca' => $alpaca, 'tastoModifica' => true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\alpaca  $alpaca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $alpaca = alpaca::find($id);
        $userId = Auth::user()->id;
        $allevamento = ($request->allevamento != 0) ? $request->allevamento : null ;
        $alpaca->nome = $request->nome;
        $alpaca->colore = $request->colore;
        $alpaca->madre = $request->madre;
        $alpaca->padre = $request->padre;
        $alpaca->allevatore = $allevamento;
        $alpaca->nascita = Carbon::parse($request->nascita)->toDateTimeString();
        $alpaca->morte = Carbon::parse($request->morte)->toDateTimeString();
        $alpaca->tipologia = $request->tipo;
        $alpaca->sesso = $request->sesso;
        $file = File::files( public_path().'/storage/temp/'.$userId);
        if (count($file)>0) {
            File::makeDirectory(base_path().'/storage/app/alpaca', 0775, true, true);
            File::move( public_path().'/storage/temp/'.$userId.'/'.pathinfo($file[0])['basename'],base_path().'/storage/app/alpaca/'.pathinfo($file[0])['basename']);
            $alpaca->immagine = '/storage/alpaca/'.pathinfo($file[0])['basename'];
        }
        if (!File::isDirectory(public_path().'/storage/temp/'.$userId.'/galleria/alpaca')) {
            $alpaca->update();
            $req = [
                'testo'=>'Ha aggiunto modificato d i nome'.$alpaca->nome,
                'modello'=>'alpaca'
            ];
            $n = new NotificationController();
            $n->nuovaNotifica($req);
            return 'hey.';
        }
        $file = File::files( public_path().'/storage/temp/'.$userId.'/galleria/alpaca');
        if (count($file)<1) {
            $alpaca->update();
            $req = [
                'testo'=>'Ha aggiunto modificato d i nome'.$alpaca->nome,
                'modello'=>'alpaca'
            ];
            $n = new NotificationController();
            $n->nuovaNotifica($req);
            return 'hey.';
        }
        $gallery = array();
        foreach ($file as $singleFile) {
           File::move( $singleFile,base_path().'/storage/app/alpaca/'.pathinfo($singleFile)['basename']); 
           array_push($gallery, '/storage/alpaca/'.pathinfo($singleFile)['basename']);
        }
        $alpaca->galleria = json_encode($gallery);
        $alpaca->update();
        $req = [
            'testo'=>'Ha aggiunto modificato d i nome'.$alpaca->nome,
            'modello'=>'alpaca'
        ];
        $n = new NotificationController();
        $n->nuovaNotifica($req);
        return 'hey.';

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\alpaca  $alpaca
     * @return \Illuminate\Http\Response
     */
    public function cancella(Request $request)
    {
        $alpaca = alpaca::find($request->alpaca);
        $alpaca->delete();
        $all = alpaca::take($request->alpaca)->get();
        return $all;
    }

    public function all(){
        $r = alpaca::find()->all();
        return $r;
    }
    public function uploadAlpacaFoto(Request $request)
    {
        $userId = Auth::user()->id;

        if(!$request->hasFile('photos')) {
            return response()->json(['upload_file_not_found'], 400);
        }

        $outsidePath = $request->file('photos');
        if(!$outsidePath->isValid()) {
            return response()->json(['invalid_file_upload'], 400);
        }
        $file = $outsidePath->storeAs('temp/'.$userId, $outsidePath->getClientOriginalName());
        $outsidePath = '/storage/temp/'.$userId.'/'.$outsidePath->getClientOriginalName();
        return response()->json(compact('outsidePath'));
    }
    public function resettaFoto(Request $request){

        $alpaca = alpaca::find($request->id);
        if ($alpaca->immagine != "/img/AlpacaDefaultProfile.svg") {
            Storage::delete($alpaca->immagine);
            $alpaca->immagine = "/img/AlpacaDefaultProfile.svg";
            $alpaca->update();

        }
        return 'hey.';
    }
    private function completeSesso($value){
        if ($value == 0) {
            return (object)[
                'value'=>0,
                'label'=>'Maschio'
            ];
        }else{
            return (object)[
                'value'=>1,
                'label'=>'Femmina'
            ];
        }
    }
        public function uploadMultipleFoto(Request $request){
        $response = array();
        $userId = Auth::user()->id;

        if ($request->hasFile('gallery')) {
            File::makeDirectory(public_path().'/storage/temp/'.$userId.'/galleria/'.$request->cartella, 0775, true, true);
            foreach ($request->gallery as $file) {
                $storeFile = $file->storeAs('temp/'.$userId.'/galleria/'.$request->cartella, $file->getClientOriginalName());
                
                $path = '/storage/temp/'.$userId.'/galleria/'.$request->cartella.'/'.$file->getClientOriginalName();
                
            }
             $file = File::files( public_path().'/storage/temp/'.$userId.'/galleria/alpaca');
                foreach ($file as $single) {
                    $response[]= '/storage/temp/'.$userId.'/galleria/'.$request->cartella.'/'.pathinfo($single)['basename'];
                }
        }
        $ans = array('nuove' => $response );

        if ($request->id>0) {
            $vecchie = array();
            $all = alpaca::find($request->id);
            $galleria = json_decode($all->galleria);
            if(strlen($galleria)){
                foreach ($galleria as $single) {
                    $vecchie[] = $single;
                } 
                $ans['vecchie'] = $vecchie;
            }
            
        }

        return $ans;
    }
    public function eraseFromMultipleFoto(Request $request){
        $foto = $request->name;
        $foto = substr($foto, 1);
        $userId = Auth::user()->id;
         
        $urlElements = explode('/', $foto);
        $foto = $urlElements[0].'/app/'.$urlElements[1].'/'.$urlElements[count($urlElements)-1];
        
        if (File::exists(base_path($foto))) {
            File::delete(base_path($foto));
            $all=alpaca::find($request->id);
            $oldG = json_decode($all->galleria,true) ;
            $newG = array();
            foreach ($oldG as $oldS) {
                if ($oldS != $request->name) {
                    $newG[]=$oldS;
                }
            }
            
            $all->galleria = json_encode($newG);
            $all->update();
            return $all->galleria;
        }
        $urlElements = explode('/', $request->name);
        $foto = $urlElements[0].'storage/app/temp/'.$userId.'/galleria/alpaca/'.$urlElements[count($urlElements)-1];
        if (File::exists(base_path($foto))) {
            File::delete(base_path($foto));
            if ($request->id>0) {
                $all=alpaca::find($request->id);
                $oldG = json_decode($all->galleria,true) ;
                $newG = array();
                $oldFiles = File::files(base_path($urlElements[0].'storage/app/temp/'.$userId.'/galleria/alpaca/'));
                foreach ($oldFiles  as $singleOldFile) {
                    //return pathinfo($singleOldFile)['basename'];
                    $newG[]='/storage/temp/1/galleria/alpaca/'.pathinfo($singleOldFile)['basename'];
                }
                $newG = array_merge($newG,$oldG);
                return $newG;
            }else{
                $newG = array();
                $oldFiles = File::files(base_path($urlElements[0].'storage/app/temp/'.$userId.'/galleria/alpaca/'));
                foreach ($oldFiles  as $singleOldFile) {
                    //return pathinfo($singleOldFile)['basename'];
                    $newG[]='/storage/temp/1/galleria/alpaca/'.pathinfo($singleOldFile)['basename'];
                }
                return $newG;
            }

        }
        return base_path($foto);
    }
    public function count(Request $request){
        if (isset($request->giorni)) {
            $u = alpaca::whereDate('created_at', '>=', Carbon::now()->subDays($request->giorni))->get();
            return count($u);
        }
        return alpaca::count();
    }
}
function validate($req){
        $answer = array('error' => false);
        switch ($req) {
            case strlen($req->nome)<3:
                $answer['error'] = true;
                $answer['message'] = 'Devi inserire un nome di almeno 3 lettere';
                break;
            case strlen($req->indirizzo)<1:
                $answer['error'] = true;
                $answer['message'] = 'Devi selezionare uno degli indirizzi proposti nella finestra di selezione';
                break;
            case strlen($req->citta)<1:
                $answer['error'] = true;
                $answer['message'] = 'Devi Selezionare una Citta valida';
                break;
            case strlen($req->provincia)<1:
                $answer['error'] = true;
                $answer['message'] = 'La citta che hai indicato non sembra avere una provincia, sei sicuro che sia in Italia?';
                break;
            case strlen($req->piva)<1:
                $answer['error'] = true;
                $answer['message'] = 'Non hai messo la partita Iva';
                break;
            case strlen($req->cap)<1:
                $answer['error'] = true;
                $answer['message'] = 'La citta che hai indicato non sembra avere un CAP, potrebbe non essere in Italia o essere molto grande ed averne piu di uno. Ricontrolla.';
                break;
            
            default:
                # code...
                break;
        }
        return $answer;
    }
