<?php
namespace AppBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class Base64Extention extends AbstractExtension
{
    public function getFunctions()
    {
        return [new TwigFunction('base64Url',[$this,'toBase64Url'])];
    }

    /**
     * Encode an image and get the imagedata as Base64-encoded url
     * @param String $path The full path of he file
     * @throws Exception If file located in $path is not found
     * @return String
     */
    public function toBase64Url($path) 
    {
        return AppBundle\Utilities\Base64Utility::toBase64Url($path);
    }
}