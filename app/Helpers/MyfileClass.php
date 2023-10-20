<?php

namespace App\Helpers;
use File;
use Image;
use SizeClass;
class MyfileClass
{
    public static function list_file($id)
    {
      
        $fichiers = [];
        $f= [];
           if(File::exists('img/uploads/'.$id))
		{
        if(File::exists('img/uploads/'.$id.'/img_editeur'))
            $fichiers = File::allFiles('img/uploads/'.$id.'/img_editeur');
        if(File::exists('img/uploads/'.$id.'/img_qcm'))
            array_merge($fichiers,File::allFiles('img/uploads/'.$id.'/img_qcm'));
        if(File::exists('img/uploads/'.$id.'/vid_editeur'))
            array_merge($fichiers,File::allFiles('img/uploads/'.$id.'/vid_editeur'));
        if(File::exists('img/uploads/'.$id.'/vid_qcm'))
            array_merge($fichiers,File::allFiles('img/uploads/'.$id.'/vid_qcm'));
        if(!File::exists('img/uploads/'.$id.'/thumbnails'))
            File::makeDirectory('img/uploads/'.$id.'/thumbnails');
        }
        else
        $fichiers = [];
          setlocale (LC_TIME, 'fr_FR.utf8','fra');
         foreach ($fichiers as $file)
         {
            $thumbnail = '';
             $recup = explode('_',pathinfo($file,PATHINFO_FILENAME));
            array_shift($recup);
            $nom= implode('_',$recup);
            if(substr(File::mimeType($file), 0, 5) == 'image')
            {
                if(!File::exists(pathinfo($file,PATHINFO_DIRNAME).'/thumbnail'.pathinfo($file,PATHINFO_BASENAME)))
                  $thumbnail = Image::make($file)->resize(60, 60)->save('img/uploads/'.$id.'/thumbnails/thumbnail'.pathinfo($file,PATHINFO_BASENAME));
            $thumbnail = $id."/thumbnails/thumbnail".pathinfo($file,PATHINFO_BASENAME);
            }
           
            $date  = strftime("%d %B %Y",File::lastModified($file));
                        $timestamp = File::lastModified($file);

            $type = File::mimeType($file);
            $sizeh = SizeClass::bytesToHuman(File::size($file));
            $size = File::size($file);
            $f[]=['nom'=>$nom, 'thumbnail'=> $thumbnail, 'date'=>$date, 'type'=>$type, 'size'=>$size, 'sizeh'=>$sizeh, 'timestamp'=>$timestamp, 'file'=>$file];          

                            
         }


       
        
        return $f;
    }
   
}