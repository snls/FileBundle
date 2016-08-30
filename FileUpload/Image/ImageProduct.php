<?php
/**
 * Created by PhpStorm.
 * User: lookyalba
 * Date: 28.08.16
 * Time: 22:32
 */

namespace FileBundle\FileUpload\Image;


use FileBundle\Entity\File;
use FileBundle\DependencyInjection\Container;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher;
use Symfony\Component\Config\FileLocator;

class ImageProduct
{
    /**
     * @var File
     */
    protected $file;
    protected $directory;
    protected $container;

    
    public function __construct($file, $directory)
    {
        $this->setFile($file);
        $this->setDirectoryFile($directory);

        $container = new Container(new ContainerBuilder());
        $this->container = $container->container;
        
        $this->upload();
        
        return $this->file;
    }
    
    public function getFile()
    {
        return $this->file;
    }
    
    public function setFile($file)
    {
        $this->file = $file;
    }

    public function setDirectoryFile($name)
    {
        $this->directory = $name;
    }

    /**
     * @inheritdoc Upload file and return object with file
     * @return File
     */
    public function upload()
    {
        $format = $this->file->getName()->guessExtension();
        // validation images
        $this->validation();
        // generate filename
        $this->setFilename($this->generateFilename($format));
        // moving file
        $this->moveFile($this->file->getName(), $this->directory);
        // create preview
        $img = new ImageResize();
        $namePreview = $this->generateFilename($format); // generate name for preview
        $img->load('../web/'
            .$this->container->getParameter('file.image.directorie')
            .'/'.$this->fileName)
            ->adaptive_resize(200)
            ->save('../web/'
                .$this->container->getParameter('file.image.directorie')
                .'/'.$namePreview);

        $this->getFile()->setPreview($namePreview);
        // set new name for file
        $this->file->setName($this->fileName);
    }

    protected $fileName;

    /**
     * Generate filename for saving
     * Parameter give information from method getName from object Entity\File
     *
     * @param $format
     * @return string
     */
    protected function generateFilename($format)
    {
        return md5(uniqid()).'.'.$format;
    }

    /**
     * @inheritdoc save file name
     * @param $name
     */
    private function setFilename($name)
    {
        $this->fileName = $name;
    }

    /**
     * @inheritdoc moving files
     * @param $file
     * @param $directory
     */
    protected function moveFile($file, $directory)
    {
        $file->move(
            $this->container->getParameter($directory),
                $this->fileName
            );
    }

    protected function validation()
    {}
}