<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Photo::all();
    }

    public function estudioPhotos(){
        return Photo::where('category', 'estudio')->orderBy('id', 'desc')->get();
    }

    public function exteriorPhotos(){
        return Photo::where('category', 'exterior')->orderBy('id', 'desc')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['photo' => 'required|image|max:4000']);
        $data = $request->all();
        $photoForUpload = $request->photo;
        if($request->category == 'estudio'){
            $obj = Cloudinary::upload($photoForUpload->getRealPath(), ['folder' => 'photos/estudio']);
        }
        if($request->category == 'exterior'){
            $obj = Cloudinary::upload($photoForUpload->getRealPath(), ['folder' => 'photos/exterior']);
        }
        $url = $obj->getSecurePath();
        $photo_id = $obj->getPublicId();

        $data['photo'] = $url;
        $data['photo_id'] = $photo_id;

        return Photo::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Photo::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function edit(Photo $photo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $photo = Photo::findOrFail($request->id);
        $request->validate(['photo' => 'required|image|max:4000']);
        $data = $request->all();

        $photo_id = $photo->photo_id;
        Cloudinary::destroy($photo_id);

        $photoForUpdate = $request->photo;
        if($request->category == 'estudio'){
            $obj = Cloudinary::upload($photoForUpdate->getRealPath(), ['folder' => 'photos/estudio']);
        }
        if($request->category == 'exterior'){
            $obj = Cloudinary::upload($photoForUpdate->getRealPath(), ['folder' => 'photos/exterior']);
        }
        $url = $obj->getSecurePath();
        $photo_id = $obj->getPublicId();

        $data['photo'] = $url;
        $data['photo_id'] = $photo_id;

        return $photo->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $photo = Photo::findOrFail($id);
      
        $photo_id = $photo->photo_id;
        Cloudinary::destroy($photo_id);
        
        return $photo->delete();
    }
}
