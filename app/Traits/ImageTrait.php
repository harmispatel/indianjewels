<?php
  
namespace App\Traits;
  
use Illuminate\Http\Request;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
  
trait ImageTrait {
  
      /**
     * add/remove Multi image from sotage.
     * @return $this|false|string
     */
    public function addMultiImage($path,$files,$oldImage = null)
    {
        // remove multi image.
        if ($oldImage != '') 
        {
            $images = explode(' ,', $oldImage);
            foreach ($images as $img) 
            {
                $oldimage_path = public_path().'/'. $path .'/'.$img;
                if (file_exists($oldimage_path)) 
                {
                    unlink($oldimage_path);
                }
            }
        }

        // add multi image.
        if ($files != '') 
        {
            
            foreach ($files as $file)        
            {
                $multiImage = date('YmdHi').$file->getClientOriginalName();
                $file->move(public_path($path), $multiImage);
                $imgData[] = $multiImage;
            }
            // $multiImage = implode(" ,", $imgData);
            

            return $imgData;
        }
        return null;
    }


    public function addSingleImage($path,$file,$oldImage = null,$dim)
    {
    

        // remove Single image
        if ($oldImage != null) 
        {
            $oldimage_path = public_path().'/images/'.$path.'/'.$oldImage;
            
            if (file_exists($oldimage_path)) 
            {
                unlink($oldimage_path);
            }
        }
        
        // add Single image
        if ($file != null) 
        {
            $filename = date('YmdHi').$file->getClientOriginalName();
            $filename = str_replace(' ','_',$filename);
             // Image Upload Path
            $image_path = public_path().'/images/'.$path;

              // Image Dimension Array
                $dim_array = explode('*',$dim);

                // Get Image Path
                 $image = Image::make($file->path());

                 // Resize Image & Upload in Storage
        $image->resize($dim_array[0],$dim_array[1], function ($constraint)
        {
        })->save($image_path.'/'.$filename);

            
            return $filename;
        }
        return null;
    }
  
}