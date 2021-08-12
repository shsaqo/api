<?php

namespace App\Http\Controllers;

use App\Http\Resources\GetResource;
use App\Http\Traits\ResponseJson;
use App\Models\Product;
use App\Models\SpecialOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class IndexController extends Controller
{
    public function indexUrl(Request $request, $url)
    {
        if (!$product = Product::where([['domain', $request->getHost()], ['status', 1], ['url', $url]])
            ->descriptionOne()
            ->descriptionTwo()
            ->slider()
            ->comment()
            ->first()) {
            return ResponseJson::response([], 404, 'not found');
        }
        return new GetResource($product);
    }

    public function getImage($file)
    {
        $path = public_path().'/images/'.$file;
        if (File::exists($path)) {
            return Response::file($path);
        }
        return ResponseJson::response([], 404, 'Not found');
    }

    public function getSelectDomainUrl()
    {
        return new GetResource(Product::select('domain', 'url')->get());
    }

    public function GetSpecialOffer(Request $request)
    {
        return new GetResource(SpecialOffer::where([['domain', $request->getHost()], ['url', $request->url]])
            ->orWhere('domain', 'all')
            ->with('description')
            ->get());
    }
}
