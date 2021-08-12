<?php

namespace App\Http\Controllers;

use App\Exceptions\RequestServerException;
use App\Http\Requests\ProductGetRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\GetResource;
use App\Http\Traits\ResponseJson;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{

    public function index(ProductGetRequest $request)
    {
        if (! Gate::allows('product-show')) {
            return ResponseJson::response([], 403, 'permission denied');
        }
        $products = Product::offset($request->offset)->limit($request->limit)
            ->descriptionOne()
            ->descriptionTwo()
            ->slider()
            ->comment();

        if ($request->search) {
            $products->where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('trello', 'LIKE', '%' . $request->search . '%')
                ->orWhere('url', 'LIKE', '%' . $request->search . '%');
        }
        if ($request->type) {
            $products->where('type', $request->type);
        }

        if ($request->domain) {
            $products->where('domain', $request->domain);
        }

        return new GetResource($products->get());
    }

    public function show($id)
    {
        if (! Gate::allows('product-show')) {
            return ResponseJson::response([], 403, 'permission denied');
        }
        $product = Product::where('id', $id)->slider()->get();
        return new GetResource($product);
    }

    public function store(ProductRequest $request)
    {
        if (! Gate::allows('product-full')) {
            return ResponseJson::response([], 403, 'permission denied');
        }
        return new GetResource(Product::saveProduct($request));
    }


    public function update(Request $request, Product $product)
    {
        if (! Gate::allows('product-full')) {
            return ResponseJson::response([], 403, 'permission denied');
        }
        return new GetResource(Product::saveProduct($request, $product));
    }


    public function destroy(Product $product)
    {
        if (! Gate::allows('product-full')) {
            return ResponseJson::response([], 403, 'permission denied');
        }
        $product->delete();
        return new GetResource([]);
    }

    public function status($id)
    {
        if (! Gate::allows('product-full')) {
            return ResponseJson::response([], 403, 'permission denied');
        }
        if (!$product = Product::find($id)) {
            return ResponseJson::response([], 404, 'Not found');
        }
        if ($product->status == 1) {
            $product->update(['status' => 0]);
            return ResponseJson::response(['status' => 0]);
        } else {
            $product->update(['status' => 1]);
            return ResponseJson::response(['status' => 1]);
        }
    }

}
