<?php
/**
 * Created by PhpStorm.
 * User: lookyalba
 * Date: 28.08.16
 * Time: 22:08
 */

namespace FileBundle\FileUpload;


use FileBundle\Entity\File;

class ImageFactory implements LoaderFactoryInterface
{
    public function upload($file /* file object */, $directory = 'file_directories' /* directory when save file */)
    {
        return new ImageProduct($file, $directory);
    }
}