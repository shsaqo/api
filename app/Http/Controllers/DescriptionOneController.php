<?php

namespace App\Http\Controllers;

use App\Models\DescriptionOne;
use Illuminate\Http\Request;

class DescriptionOneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DescriptionOne  $descriptionOne
     * @return \Illuminate\Http\Response
     */
    public function show(DescriptionOne $descriptionOne)
    {
        //
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DescriptionOne  $descriptionOne
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DescriptionOne $descriptionOne)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DescriptionOne  $descriptionOne
     * @return \Illuminate\Http\Response
     */
    public function destroy(DescriptionOne $descriptionOne)
    {
        //
    }
}
