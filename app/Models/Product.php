<?php

namespace App\Models;

use App\Exceptions\RequestServerException;
use App\Exceptions\RequestValidateException;
use App\Http\Traits\ResponseJson;
use App\Services\FileService;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'domain', 'url', 'name', 'trello', 'color',
        'description', 'info', 'type', 'template', 'status',
        'sale', 'count', 'price', 'old_price', 'contact_type', 'footer_name',
        'head_image', 'footer_image', 'youtube', 'alert_1', 'alert_2', 'alert_3', 'alert_4'
    ];

    public static function saveProduct(Request $request, $product = null)
    {
        $domain = Domain::where('domain', $request->domain)->first();

        if (Product::where([['domain', $request->domain], ['url', $request->url]])->count() && $request->method() != 'PUT') {
            throw new RequestValidateException('the domain and url already exists');
        }
        if (!$domain) {
            throw new RequestValidateException('not found domain in db');
        }
        try {
            DB::beginTransaction();
            FileService::photo($request, 'head_photo', 'head_image');
            FileService::footerPhoto($request);
            ProductService::footerName($request);
            ProductService::old_price($request);
            if ($request->method() == 'PUT') {
                $product->update($request->all());
            } else {
                $product = $domain->product()->create($request->all());
            }

            FileService::slider($request, $product);
            ProductService::descriptionOne($request, $product);
            ProductService::descriptionTwo($request, $product);
            ProductService::comment($request, $product);
            DB::commit();
            return $product;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new RequestServerException($e->errorInfo[2]);
        }

    }

    public function scopeSlider($q)
    {
        $q->with(['slider' => function ($q) {
            $q->orderBy(DB::raw('ISNULL(order_by), order_by'), 'ASC');
        }]);
    }

    public function scopeDescriptionOne($q)
    {
        $q->with('descriptionOne.description');
    }

    public function scopeComment($q)
    {
        $q->with('comment.commentItem.commentItemFile');
    }

    public function scopeDescriptionTwo($q)
    {
        $q->with('descriptionTwo.description');
    }

    public function slider()
    {
        return $this->hasMany(Slider::class);
    }

    public function descriptionOne()
    {
        return $this->hasOne(DescriptionOne::class);
    }

    public function descriptionTwo()
    {
        return $this->hasOne(DescriptionTwo::class);
    }

    public function comment()
    {
        return $this->hasOne(Comment::class);
    }
}
