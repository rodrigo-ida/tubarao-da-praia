<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    
    static public function storeImageIfExists($request, $class, $path)
    {

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if ($image->isValid()) {
                $image->store('\\' . $class::$images_storage_path, 'public');
                return $image->hashName();
            }
        }
        return false;
    }

    static public function getInputFromRequest($request, $class, $table)
    {
        
        //Offer fillable fields except 'image_filename'

        $fields = array_diff($class::getModel()->getFillable(), [$table]);

        $data = $request->only($fields);

        return $data;
    }

}
