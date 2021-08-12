<?php

namespace App\Http\Controllers;

use App\Http\Requests\SliderRequest;
use App\Http\Traits\ResponseJson;
use App\Models\Product;
use App\Models\Slider;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SliderController extends Controller
{
    public function orderBy(SliderRequest $request)
    {
        if ($sliders = Slider::where('product_id', $request->product_id)->get()) {
            if (!count($sliders)) return ResponseJson::response([], 404, 'Not found');
        }

        foreach ($request->order as $index => $order) {
            Slider::where([['product_id', $request->product_id], ['id', $order]])->update(['order_by' => $index]);
        }
        return ResponseJson::response([]);

    }

    public function destroy(Request $request)
    {
        FileService::deleteFiles('Slider', $request->ids, 'slider_image');
        Slider::whereIn('id', $request->ids)->delete();
        return ResponseJson::response([]);
    }

    public function store(SliderRequest $request, $id)
    {
        if (!$product = Product::find($id)) {
            return ResponseJson::response([], 404, 'Not found');
        }

        FileService::slider($request, $product);
        return ResponseJson::response([]);
    }
}
