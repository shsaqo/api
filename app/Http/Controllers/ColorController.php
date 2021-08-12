<?php

namespace App\Http\Controllers;

use App\Http\Resources\GetResource;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function store(Request $request)
    {
        $color = Color::create($request->only('color'));
        return new GetResource($color);
    }

    public function delete(Color $color)
    {
        $color->delete();
        return new GetResource([]);
    }

    public function index()
    {
        return new GetResource(Color::all());
    }
}
