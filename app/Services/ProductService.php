<?php


namespace App\Services;


use App\Models\Product;
use Illuminate\Http\Request;

class ProductService
{
    public static function old_price(Request $request)
    {
        $old_price = $request->price * 100 / (100 - $request->sale);
        $request->merge(['old_price' => $old_price]);
    }

    public static function footerName(Request $request)
    {
        if (!isset($request->footer_name)) {
            $request->request->add(['footer_name' => $request->name]);
        }
    }

    public static function descriptionOne(Request $request, $product)
    {
        $data = [];
        if ($request->description_one_type || $request->description_one_name || $request->hasFile('description_one_photo') || count($request->description_one_description)) {
            if ($request->method() == 'PUT') {
                $product->descriptionOne()->delete();
            }
            if ($request->hasFile('description_one_photo')) {
                $description = $product->descriptionOne()->create($request->all() + ['description_one_image' => $request->file('description_one_photo')->store('images')]);
            } else {
                $description = $product->descriptionOne()->create($request->all());
            }
            if ($description && isset($request->description_one_description) && count($request->description_one_description)) {
                foreach ($request->description_one_description as $desc) {
                    array_push($data, ['description_one_description' => $desc]);
                }
                $description->description()->createMany($data);
            }
        }
    }

    public static function descriptionTwo(Request $request, $product)
    {
        $data = [];
        if ($request->description_two_type || $request->description_two_name || $request->hasFile('description_two_photo') || count($request->description_two_description)) {
            if ($request->method() == 'PUT') {
                $product->descriptionTwo()->delete();
            }
            if ($request->hasFile('description_one_photo')) {
                $description = $product->descriptionTwo()->create($request->all() + ['description_two_image' => $request->file('description_two_photo')->store('images')]);
            } else {
                $description = $product->descriptionTwo()->create($request->all());
            }
            if ($description && isset($request->description_two_description) && count($request->description_two_description)) {
                foreach ($request->description_two_description as $desc) {
                    array_push($data, ['description_two_description' => $desc]);
                }
                $description->description()->createMany($data);
            }
        }
    }

    public static function comment(Request $request, $product)
    {
        if(isset($request->comment)) {
            if ($request->method() == 'PUT') {
                $product->comment()->delete();
            }
            $comment = $product->comment()->create(['comment_type' => $request->comment['comment_type']]);
            foreach($request->comment['commentItem'] as $commentItem)
            {
                $commentItemModel = $comment->commentItem()->create([
                    'comment_text' => $commentItem['comment_text'],
                    'comment_name' => $commentItem['comment_name'],
                    'comment_time' => $commentItem['comment_time'],
                    'comment_user_image' => $commentItem['comment_user_photo']->store('images'),
                ]);
                if ($commentItem['commentItemFile']) {
                    foreach($commentItem['commentItemFile'] as $file) {
                        $commentItemModel->commentItemFile()->create(['comment_item_image' => $file->store('images')]);
                    }
                }
            }
        }
    }
}
