<?php
/**
 * Created by PhpStorm.
 * User: lookyalba
 * Date: 29.08.16
 * Time: 15:09
 */

namespace FileBundle\FileUpload\Image;


use FileBundle\Entity\File;
use FileBundle\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ImageResize
{
    /**
     * @var File object with file
     */
    private $file;

    private $container;

    /**
     * ImageResize get file
     * @param File $file
     */
    public function __construct(File $file)
    {
        $this->file = $file;
        $this->getParameters();
    }

    /**
     * @param $width
     * @param null||integer $height
     * @return $this
     */
    public function editSize($width, $height = NULL)
    {
        $height = $height ?: $width;
        return $this;
    }

    /**
     * @param $width
     * @param null||integer $height
     * @return $this
     */
    public function createPreview($width, $height = NULL)
    {
        return $this;
    }

    public function save() {}

    private function getParameters()
    {
        $container = new Container(new ContainerBuilder());
        $this->container = $container->container;
    }

    private function getImageURL()
    {
        return $this->container->getParameter().'/'.$this->file->getName();
    }
}