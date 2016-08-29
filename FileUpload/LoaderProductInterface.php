<?php
/**
 * Created by PhpStorm.
 * User: lookyalba
 * Date: 28.08.16
 * Time: 22:03
 */

namespace FileBundle\FileUpload;

/**
 * @inheritdoc Uploader files for other types
 *
 * Interface LoaderProductInterface
 * @package FileBundle\FileUpload
 */
interface LoaderProductInterface
{
    /**
     * @inheritdoc information about file
     * @return object
     */
    public function setFile($file);

    /**
     * @inheritdoc set name parameters directory for file
     * @return string
     */
    public function setDirectoryFile($name);

    /**
     * @inheritdoc upload file
     * @return boolean
     */
    public function upload();
}