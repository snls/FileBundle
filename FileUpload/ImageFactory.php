<?php
/**
 * Created by PhpStorm.
 * User: lookyalba
 * Date: 28.08.16
 * Time: 22:08
 */

namespace FileBundle\FileUpload;


use FileBundle\Entity\File;
use FileBundle\FileUpload\Image\ImageProduct;

class ImageFactory implements LoaderFactoryInterface
{
    public function upload($file /* file object */, $directory = 'file.image.directorie' /* directory when save file */)
    {
        return new ImageProduct($file, $directory);
    }
}