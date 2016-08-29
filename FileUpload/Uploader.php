<?php
/**
 * Created by PhpStorm.
 * User: lookyalba
 * Date: 28.08.16
 * Time: 21:59
 */

namespace FileBundle\FileUpload;


use Symfony\Component\Intl\Exception\MethodNotImplementedException;

abstract class Uploader
{
    /**
     * Получение загрузчика файлов
     *
     * @param $name
     * @param $name
     * @return LoaderFactoryInterface
     */
    public static function getLoader($name)
    {
        switch ($name) {
            case "image": {
                return new ImageFactory();
            } break;
            case "book": {
                return new BookFactory();
            } break;
            default: {
                throw new MethodNotImplementedException($name);
            }
        }
    }
}