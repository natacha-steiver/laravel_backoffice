<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Text;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $page= Page::all();
       return response()->json($page, 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $request->validate([
     'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      ]);

      $imageName = $request->file('photo')->getClientOriginalName();

      $request->photo->move(public_path('images'), $imageName);

      if(intval($request->get("id"))>0){
        $page=Page::where('id', $request->get("id"))
      ->update(["name"=>$request->get("name"),"photo"=>$request->file('photo')->getClientOriginalName()]);
      return response()->json([
        'photo' => $imageName,
        'id' => intval($request->get("id")),
        'name' => $request->get('name')
      ],200);

      }else{
        $page=Page::create(["name"=>$request->get("name"),"photo"=>$request->file('photo')->getClientOriginalName()]);
        return response()->json($page, 201);

      }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $id)
    {
      $page_res=Page::find($id);
      $texts = Text::where('page', $id);


        return response()->json([
          'pages' =>$page_res,
          'texts' =>$texts,

        ],200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $id)
    {


      $id->update($request->all());
      return response()->json([
        'photo' => $request->get('photo'),
        'id' => $id,
        'name' => $request->get('name')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $id)
    {


         $id->delete();
         return response()->json([
           'id' => $id,
         ],204);

    }
}
