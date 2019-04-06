<?php

namespace AppBundle\Utilities;

class Base64Utility
{
    /**
     * Encode an image and get the imagedata as Base64-encoded url
     * @param String $path The full path of he file
     * @throws Exception If file located in $path is not found
     * @return String
     */
    public static function toBase64Url($path) 
    {
        if(!file_exists($path)){
            throw new \Exception("File $path does not exist");
        }
        $size=filesize($path);
        $mime=mime_content_type($path);
        $contents=file_get_contents($path,FALSE,NULL,0,$size);
        return 'data:'+$mime+';base64,'+base64_encode($contents);
    }
}