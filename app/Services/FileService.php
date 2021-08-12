<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FileService
{
    public static function photo(Request $request, $inputName, $outputName)
    {
        if ($request->hasFile($inputName)) {
            $path = $request->file($inputName)->store('images');
            $request->request->add([$outputName => $path]);
        }
    }

    public static function footerPhoto(Request $request)
    {
        if ($request->method() != 'PUT') {
            if ($request->hasFile('footer_photo')) {
                $path = $request->file('footer_photo')->store('images');
                $request->request->add(['footer_image' => $path]);
            } else {
                $path = $request->file('head_photo')->store('images');
                $request->request->add(['footer_image' => $path]);
            }
        }
    }


    public static function slider(Request $request, $product)
    {
        if ($request->hasFile('slider_photo')) {
            if ($request->method() == 'PUT') {
                $product->slider()->delete();
            }
            foreach ($request->file('slider_photo') as $image) {
                $product->slider()->create(['slider_image' => $image->store('images')]);
            }
        }
    }

    public static function deleteFiles(string $model, array $ids, string $fileNameColumn)
    {
        $model = 'App\Models\\'.$model;
        File::delete($model::find($ids)->pluck($fileNameColumn)->toArray());
    }
}
