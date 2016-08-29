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
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Validator\Constraints\Image;


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
        // generate filename
        $this->generateFilename($this->file->getName());
        // moving file
        $this->moveFile($this->file->getName(), $this->directory);
        // set new name for file
        $this->file->setName($this->fileName);
        // validation images
        $this->validation();
    }

    protected $fileName;

    /**
     * Generate filename for saving
     * Parameter give information from method getName from object Entity\File
     *
     * @param $fileName
     * @return string
     */
    protected function generateFilename($fileName)
    {
        $this->setFilename(md5(uniqid()).'.'.$fileName->guessExtension());
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