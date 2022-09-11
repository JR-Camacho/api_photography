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
        $photoForUpload = $request->photo;
        $obj = Cloudinary::upload($photoForUpload->getRealPath(), ['folder' => 'photos']);
        $url = $obj->getSecurePath();
        $photo_id = $obj->getPublicId();

        $request->photo = $url;
        $request->photo_id = $photo_id;

        return Photo::create($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo)
    {
        //
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

        $photo_id = $photo->photo_id;
        Cloudinary::destroy($photo_id);

        $photoForUpdate = $request->photo;
        $obj = Cloudinary::upload($photoForUpdate->getRealPath(), ['folder' => 'photos']);
        $url = $obj->getSecurePath();
        $photo_id = $obj->getPublicId();

        $request->photo = $url;
        $request->photo_id = $photo_id;

        return $photo->update($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $photo = Photo::findOrFail($request->id);
      
        $photo_id = $photo->photo_id;
        Cloudinary::destroy($photo_id);
        
        return $photo->delete();
    }
}
