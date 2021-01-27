<?php

namespace App\Http\Controllers;

use App\post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('grimmadmin.page.post');
    }
    public function get(Request $request){
        return post::all();
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

        $post = new post();
        $post->titolo = $request->titolo;
        $post->sottotitolo = $request->sottotitolo;
        $post->testo = $request->testo;
        $post->user = Auth::id();
        if (isset($request->categoria)) {
            $post->categoria = $request->categoria;
        }
        $file = File::allFiles( public_path().'/storage/temp');
        if (count($file)<1) {
            $post->save();
            return 'hey.';
        }
        File::move( public_path().'/storage/temp/'.pathinfo($file[0])['basename'],base_path().'/storage/app/post/'.pathinfo($file[0])['basename']);        
        $post->immagine = '/storage/post/'.pathinfo($file[0])['basename'];
        $post->save();
        return 'hey.';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(post $post)
    {
        //
    }
     public function cancella(Request $request)
    {
        $post = post::find($request->alpaca);
        $post->delete();
        $all = post::all();
        return $all;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = post::find($id);
        $post->titolo = $request->titolo;
        $post->sottotitolo = $request->sottotitolo;
        $post->testo = $request->testo;
        $post->user = Auth::id();
        if (isset($request->categoria)) {
            $post->categoria = $request->categoria;
        }
        $file = File::allFiles( public_path().'/storage/temp');
        if (count($file)<1) {
            $post->update();
            return 'hey.';
        }
        File::move( public_path().'/storage/temp/'.pathinfo($file[0])['basename'],base_path().'/storage/app/post/'.pathinfo($file[0])['basename']);        
        $post->immagine = '/storage/post/'.pathinfo($file[0])['basename'];
        $post->update();
        return 'hey.';
    }
    public function modifica(post $post, $id){
        $post = post::find($id);
        return view('grimmadmin/page/nuovo-articolo', ['post' => $post]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(post $post)
    {
        //
    }

    public function uploadPostFoto(Request $request)
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

        $post = post::find($request->id);
        if ($post->immagine != "/img/postDefault.svg") {
            Storage::delete($post->immagine);
            $post->immagine = "/img/postDefault.svg";
            $post->update();

        }
        return 'hey.';
    }

}
