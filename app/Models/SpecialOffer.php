<?php

namespace App\Models;

use App\Exceptions\RequestServerException;
use App\Exceptions\RequestValidateException;
use App\Http\Requests\SpecialOfferRequest;
use App\Services\FileService;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpecialOffer extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'trello', 'price', 'old_price', 'sale', 'image', 'domain', 'url'];

    public static function saveSpecialOffer(Request $request, $product = null)
    {
        $domain = Domain::where('domain', $request->domain)->first();
        if (!$domain) {
            throw new RequestValidateException('not found domain in db');
        }
        try {
            DB::beginTransaction();
            FileService::photo($request, 'photo', 'image');
            ProductService::old_price($request);
            if ($request->method() == 'PUT') {
                $product->update($request->all());
                if (isset($request->description) && count($request->description)) {
                    $product->description()->delete();
                    foreach ($request->description as $desc) {
                        $product->description()->create(['description' => $desc]);
                    }
                }
            } else {
                $product = self::create($request->all());
                if (isset($request->description) && count($request->description)) {
                    foreach ($request->description as $desc) {
                        $product->description()->create(['description' => $desc]);
                    }
                }
            }
            DB::commit();
            return $product;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new RequestServerException($e->errorInfo[2]);
        }
    }

    public function description()
    {
        return $this->hasMany(SpecialOfferDescription::class);
    }
}
