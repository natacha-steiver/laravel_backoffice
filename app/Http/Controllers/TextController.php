<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Text;
use App\Models\Page;
use Illuminate\Http\Request;

class TextController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $text=Text::all();

      $page=Text::join('pages','texts.page','pages.id')
         ->select(
                  'texts.id as text',
                  'texts.titre as text_titre',
                  'pages.id as page',
                  'pages.name as name'
          )
         ->get();
      return response()->json([
        $text,
      //  $page
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //faire une condition pour ajouter l'id conso
      //sur base du nom renvoyé
      $text=Text::create($request->all());
     
      return response()->json($text, 201);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Text  $text
     * @return \Illuminate\Http\Response
     */
    public function show(Text $text)
    {
       return $text;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Text  $text
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Text $id)
    {


      $id->update($request->all());
      return response()->json([
        'id' => $id,
        'page' => $request->get('page'),
        'titre' => $request->get('titre'),
        'contenu' => $request->get('contenu')

        ]);
      //return response()->json($id, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Text  $text
     * @return \Illuminate\Http\Response
     */
    public function destroy(Text $id)
    {


          $id->delete();
          return response()->json([
            'id' => $id,
          ],204);
    }
}
