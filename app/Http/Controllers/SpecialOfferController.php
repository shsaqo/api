<?php

namespace App\Http\Controllers;

use App\Http\Requests\SpecialOfferRequest;
use App\Http\Resources\GetResource;
use App\Http\Traits\ResponseJson;
use App\Models\SpecialOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SpecialOfferController extends Controller
{

    public function index()
    {
        if (! Gate::allows('special-show')) {
            return ResponseJson::response([], 403, 'permission denied');
        }
        return new GetResource(SpecialOffer::all());
    }


    public function store(SpecialOfferRequest $request)
    {
        if (! Gate::allows('special-full')) {
            return ResponseJson::response([], 403, 'permission denied');
        }
        return New GetResource(SpecialOffer::saveSpecialOffer($request));
    }


    public function show(SpecialOffer $specialOffer)
    {
        if (! Gate::allows('special-show')) {
            return ResponseJson::response([], 403, 'permission denied');
        }
        return new GetResource($specialOffer);
    }


    public function update(Request $request, SpecialOffer $specialOffer)
    {
        if (! Gate::allows('special-full')) {
            return ResponseJson::response([], 403, 'permission denied');
        }
        return new GetResource(SpecialOffer::saveSpecialOffer($request, $specialOffer));
    }


    public function destroy(SpecialOffer $specialOffer)
    {
        if (! Gate::allows('special-full')) {
            return ResponseJson::response([], 403, 'permission denied');
        }
        $specialOffer->delete();
        return new GetResource([]);
    }
}
