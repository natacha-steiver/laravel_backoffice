<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Langue;
use App\Models\Page;
use App\Models\Text;
use Illuminate\Http\Request;

class LangueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $langue=Langue::all();
      $pages=Page::all();


      $arr=array();
      foreach ($langue as $langues) {

             array_push($arr, ["langue_name"=>$langues->name,"short_name"=>$langues->short_name,"langue_id"=>$langues->id,"langue_iso"=>$langues->iso,$langues->page]);

      }





      return response()->json(
        $arr
        , 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      if(intval($request->get("id"))>0){
        $langue=Langue::where('id', $request->get("id"))
      ->update(["name"=>$request->get("name"),"short_name"=>$request->get("short_name"),"iso"=>$request->get("iso")]);

      $jsons=json_decode($request->get('name_page'),true);
      $photo=json_decode($request->get('photo'),true);
      $ids_page=json_decode($request->get('id_page'),true);


      $t=0;

      foreach ( $jsons as $pages) {
        $photoID='photo'.$t;
        if($request->file($photoID) !== null){
          $imageName =$request->file($photoID)->getClientOriginalName();
          $photos= array($imageName);
          array_push($photos,$imageName);
          $request->file($photoID)->move(public_path('images'), $imageName);

          $langue=Page::where('id', $ids_page[$t])
            ->update(["name"=>$jsons[$t],'photo' => $request->file($photoID)->getClientOriginalName()]);

          $t++;
          }
        }


        $langue_res=Langue::all();
        $pages_res=Page::all();
      //  $cpagesByPlangue= Plangue::has('cpagess')->get();


        $arr=array();
        foreach ($langue_res as $langues) {
          // array_push($arr, [$plangues,$plangues->cpagess[0]]);
          if($langues->id == $request->get("id") ){
            array_push($arr, ["langue_name"=>$langues->name,"langue_id"=>$langues->id,"langue_iso"=>$langues->iso,$langues->page]);

          }

        }


        return response()->json(
          $arr
          , 200);

      }else{

              $langue = Langue::create($request->all());

              $json=json_decode($request->get('page'),true);
              $photo=json_decode($request->get('photo'),true);

              $t=0;

              foreach ( $json["names"] as $pages) {
                $photoID='photo'.$t;
                $imageName =$request->file($photoID)->getClientOriginalName();
                $request->file($photoID)->move(public_path('images'), $imageName);



                    $pages_id = Page::select("id")->where('name', $json["names"][$t])->first();

                    if ($pages_id === null) {
                      $langue->pageByLangue()->createMany([
                        ['cpages_id' =>6 ,
                        'name' =>  $json["names"][$t],
                        'photo' => $request->file($photoID)->getClientOriginalName()
                      ]]);
                    }else{
                      $langue->pageByLangue()->attach($pages_id ->id);
                    }
                    $t++;
                }
         $photo=json_encode($request->file('photo'));

                 $langue_res=Langue::all();
                 $pages_res=Page::all();


                 $arr=array();
                 foreach ($langue_res as $langues) {

                        array_push($arr, ["langue_name"=>$langues->name,"langue_id"=>$langues->id,"langue_iso"=>$langues->iso,$langues->page]);

                 }


                 return response()->json(
                   $arr
                   , 201);


      }





    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\langue  $plangue
     * @return \Illuminate\Http\Response
     */
    public function show(Plangue $id)
    {

      $langue_res=Langue::find($id);
      $texts = Text::all();

    //  $cpagesByPlangue= Plangue::has('cpagess')->get();


      $arr=array();
      foreach ($langue_res as $langues) {
        // array_push($arr, [$plangues,$plangues->cpagess[0]]);

             array_push($arr, ["langue_name"=>$langues->name,"short_name"=>$langues->short_name,"langue_id"=>$langues->id,"langue_iso"=>$langues->iso,$langues->page]);

      }


      return response()->json(
        [$arr,$texts]
        , 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Langue  $langue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Langue $id)
    {


      $id->update($request->all());
      return response()->json([
        'id' => $id,
        'name' => $request->get('name'),
        'iso' => $request->get('iso')

        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Langue  $langue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Langue $id)
    {


          $id->delete();
          return response()->json([
            'id' => $id,
          ],204);
    }



}
