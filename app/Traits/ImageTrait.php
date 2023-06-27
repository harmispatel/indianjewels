<?php
  
namespace App\Traits;
  
use Illuminate\Http\Request;
use Carbon\Carbon;
  
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
            // dd($files);
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


    public function addSingleImage($path,$file,$oldImage = null)
    {
      
        $date = Carbon::now();
        $date_path = $date->format('Y')."/".$date->format('m');

        // remove Single image
        if ($oldImage != null) 
        {
            $oldimage_path = public_path().'/'.$path.'/'.$oldImage;
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
            $file->move(public_path($path."/".$date_path), $filename);
            $date_file = $date_path."/".$filename;
            return $date_file;
        }
        return null;
    }
  
}