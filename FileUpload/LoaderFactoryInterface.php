<?php
/**
 * Created by PhpStorm.
 * User: lookyalba
 * Date: 28.08.16
 * Time: 22:06
 */

namespace FileBundle\FileUpload;


interface LoaderFactoryInterface
{
    /**
     * @inheritdoc upload file
     * @param $file
     * @param $directory
     * @return boolean
     */
    public function upload($file /* file object */, $directory = 'file.image.directorie' /* directory when save file */);
}