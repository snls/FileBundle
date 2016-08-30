<?php

namespace FileBundle\Controller;

use FileBundle\Entity\File;
use FileBundle\FileUpload\Uploader;
use FileBundle\Form\FileUploadType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use FileBundle\FileUpload\Image\ImageResize;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="file_list")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getRepository("FileBundle:File");
        $files = $em->findAll();
        
        /*
        $img = new ImageResize();
        foreach ($files as $file) {
            $img->load($this->getParameter('web_dir').'/'
                    .$this->getParameter('file.image.directorie')
                    .'/'.$file->getName())
                ->adaptive_resize(200)
                ->save($this->getParameter('web_dir').'/'
                    .$this->getParameter('file.image.directorie')
                    .'/'.'butterfly-flip-both.jpg');
        }
        */

        return $this->render('FileBundle:Default:index.html.twig', [
            'files' => $files
        ]);
    }

    /**
     * @Route("/create", name="file_upload")
     */
    public function createAction(Request $request)
    {
        $file = new File();
        $form = $this->createForm(FileUploadType::class, $file);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $loadFile = Uploader::getLoader("image");
            // загрузка нового файла и создание объекта с файлом
            $file = $loadFile->upload($file);
            // сохранение картинки
            $this->get('EntityServices')->persist($file->getFile());
            return $this->redirectToRoute('file_list');
        }

        return $this->render('FileBundle:Default:create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
