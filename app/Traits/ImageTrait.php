<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;

trait ImageTrait
{
    // Upload Single Image
    public function addSingleImage($image_name,$path,$file,$old_image = null,$dim)
    {
        // Delete old Image if Exists
        if ($old_image != null && file_exists('public/images/uploads/'.$path.'/'.$old_image))
        {
            unlink('public/images/uploads/'.$path.'/'.$old_image);
        }

        // Upload New Image
        if ($file != null)
        {
            $filename = $image_name."_".time().".".$file->getClientOriginalExtension();

            // Image Upload Path
            $image_path = public_path().'/images/uploads/'.$path;

            // Get Image Path
            $image = Image::make($file->path());

            if($dim == 'default')
            {
                $image->save($image_path.'/'.$filename);
            }
            else
            {
                // Image Dimension Array
                $dim_array = explode('*',$dim);

                // Resize Image & Upload in Storage
                $image->resize($dim_array[0],$dim_array[1], function ()
                {
                })->save($image_path.'/'.$filename);
            }
            return $filename;
        }
    }
}
