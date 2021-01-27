<?php

namespace App\Http\Controllers;

use App\allevamento;
use App\alpaca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AllevamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('grimmadmin.page.allevamenti');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $r = allevamento::all();
        $resp = [];
        foreach ($r as $all) {
            $resp[] = (object)['allevamento'=> $all, 'numero'=>alpaca::getAlpacainAllevamento('allevatore',$all->id)->count()];
        }
        return $resp;
    }
    public function getGeneralData()
    {
        return view('grimmadmin/page/nuovo-allevamento', ['allevamento' => null]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $go = validate($request);
        if ($go['error']) {
            return $go['message'];
        }
        $userId = Auth::user()->id;
        $allevamento = new allevamento();
        $allevamento->nome = $request->nome;
        $allevamento->indirizzo = $request->indirizzo;
        $allevamento->citta = $request->citta;
        $allevamento->provincia = $request->provincia;
        $allevamento->piva = $request->piva;
        $allevamento->cap = $request->cap;
        $allevamento->lon = $request->lng;
        $allevamento->lat = $request->lat;
        $file = File::files( public_path().'/storage/temp/'.$userId);
        if (count($file)>0) {
            File::makeDirectory(base_path().'/storage/app/allevamenti', 0775, true, true);
            File::move( public_path().'/storage/temp/'.$userId.'/'.pathinfo($file[0])['basename'],base_path().'/storage/app/allevamenti/'.pathinfo($file[0])['basename']);
            $allevamento->logo = '/storage/allevamenti/'.pathinfo($file[0])['basename'];
        }
        
        
        if (!File::isDirectory(public_path().'/storage/temp/'.$userId.'/galleria/allevamenti')) {
            $allevamento->save();
            return 'hey.';
        }
        $file = File::files( public_path().'/storage/temp/'.$userId.'/galleria/allevamenti');
        if (count($file)<1) {
            $allevamento->save();
            return 'hey.';
        }
        $gallery = array();
        foreach ($file as $singleFile) {
           File::move( $singleFile,base_path().'/storage/app/allevamenti/'.pathinfo($singleFile)['basename']); 
           array_push($gallery, '/storage/allevamenti/'.pathinfo($singleFile)['basename']);
        }
        $allevamento->galleria = json_encode($gallery);
        $allevamento->save();

        return 'hey.';

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\allevamento  $allevamento
     * @return \Illuminate\Http\Response
     */
    public function show(allevamento $allevamento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\allevamento  $allevamento
     * @return \Illuminate\Http\Response
     */
    public function edit(allevamento $allevamento)
    {
        //
    }

    public function cancella(Request $request)
    {
        $allevamento = allevamento::find($request->allevamento);
        $allevamento->delete();
        $all = allevamento::all();
        $ans = array();
        foreach ($all as $single) {
           $ans[] = (object)['allevamento'=> $single, 'numero'=>alpaca::getAlpacainAllevamento('allevatore',$single->id)->count()];
        }
        return $ans;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\allevamento  $allevamento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $go = validate($request);
        if ($go['error']) {
            return $go['message'];
        }
        $userId = Auth::user()->id;
        $allevamento = allevamento::find($id);
        $allevamento->nome = $request->nome;
        $allevamento->indirizzo = $request->indirizzo;
        $allevamento->citta = $request->citta;
        $allevamento->provincia = $request->provincia;
        $allevamento->piva = $request->piva;
        $allevamento->cap = $request->cap;
        $allevamento->lon = $request->lng;
        $allevamento->lat = $request->lat;
        $file = File::files( public_path().'/storage/temp/'.$userId);
        if (count($file)>0) {
            File::makeDirectory(base_path().'/storage/app/allevamenti', 0775, true, true);
            File::move( public_path().'/storage/temp/'.$userId.'/'.pathinfo($file[0])['basename'],base_path().'/storage/app/allevamenti/'.pathinfo($file[0])['basename']);
            $allevamento->logo = '/storage/allevamenti/'.pathinfo($file[0])['basename'];
        }
        
        
        if (!File::isDirectory(public_path().'/storage/temp/'.$userId.'/galleria/allevamenti')) {
            $allevamento->update();
            return 'hey.';
        }
        $file = File::files( public_path().'/storage/temp/'.$userId.'/galleria/allevamenti');
        if (count($file)<1) {
            $allevamento->update();
            return 'hey.';
        }
        $gallery = array();
        foreach ($file as $singleFile) {
           File::move( $singleFile,base_path().'/storage/app/allevamenti/'.pathinfo($singleFile)['basename']); 
           array_push($gallery, '/storage/allevamenti/'.pathinfo($singleFile)['basename']);
        }
        $oldG = json_decode($allevamento->galleria);
        $gallery = array_merge($oldG,$gallery);
        $allevamento->galleria = json_encode($gallery);
        $allevamento->update();

        return 'hey.';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\allevamento  $allevamento
     * @return \Illuminate\Http\Response
     */
    public function destroy(allevamento $allevamento)
    {
        //
    }
    public function all(){
        $r = allevamento::find()->all();
        $resp = [];
        foreach ($r as $all) {
            $resp[] = (object)['allevamento'=> $all, 'numero'=>alpaca::getAlpacainAllevamento($all->allevatore)];
        }
        return $resp;
    }
    public function getAllevamentoFromName($ricerca){
        return allevamento::cercaConNome('nome',$ricerca)->get();
    }
    public function uploadAllevamentoFoto(Request $request)
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

        $allevamento = allevamento::find($request->id);
        if ($allevamento->immagine != "/img/allevamentoDefault.svg") {
            Storage::delete($allevamento->immagine);
            $allevamento->immagine = "/img/allevamentoDefault.svg";
            $allevamento->update();

        }
        return 'hey.';
    }
    public function modifica(allevamento $allevamento, $id)
    {
        $allevamento = allevamento::find($id);
        return view('grimmadmin/page/nuovo-allevamento', ['allevamento' => $allevamento, 'tastoModifica' => true]);
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
             $file = File::files( public_path().'/storage/temp/'.$userId.'/galleria/allevamenti');
                foreach ($file as $single) {
                    $response[]= '/storage/temp/'.$userId.'/galleria/'.$request->cartella.'/'.pathinfo($single)['basename'];
                }
        }
        $ans = array('nuove' => $response );

        if ($request->id>0) {
            $vecchie = array();
            $all = allevamento::find($request->id);
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
            $all=allevamento::find($request->id);
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
        $foto = $urlElements[0].'storage/app/temp/'.$userId.'/galleria/allevamenti/'.$urlElements[count($urlElements)-1];
        if (File::exists(base_path($foto))) {
            File::delete(base_path($foto));
            if ($request->id>0) {
                $all=allevamento::find($request->id);
                $oldG = json_decode($all->galleria,true) ;
                $newG = array();
                $oldFiles = File::files(base_path($urlElements[0].'storage/app/temp/'.$userId.'/galleria/allevamenti/'));
                foreach ($oldFiles  as $singleOldFile) {
                    //return pathinfo($singleOldFile)['basename'];
                    $newG[]='/storage/temp/1/galleria/allevamenti/'.pathinfo($singleOldFile)['basename'];
                }
                $newG = array_merge($newG,$oldG);
                return $newG;
            }else{
                $newG = array();
                $oldFiles = File::files(base_path($urlElements[0].'storage/app/temp/'.$userId.'/galleria/allevamenti/'));
                foreach ($oldFiles  as $singleOldFile) {
                    //return pathinfo($singleOldFile)['basename'];
                    $newG[]='/storage/temp/1/galleria/allevamenti/'.pathinfo($singleOldFile)['basename'];
                }
                return $newG;
            }

        }
        return base_path($foto);
    }
    public function count(Request $request){
        if (isset($request->giorni)) {
            $u = allevamento::whereDate('created_at', '>=', Carbon::now()->subDays($request->giorni))->get();
            return count($u);
        }
        return allevamento::count();
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