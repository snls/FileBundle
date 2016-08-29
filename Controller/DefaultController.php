<?php

namespace FileBundle\Controller;

use FileBundle\Entity\File;
use FileBundle\FileUpload\Uploader;
use FileBundle\Form\FileUploadType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="file_list")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getRepository("FileBundle:File");
        $files = $em->findAll();

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

            $em = $this->getDoctrine()->getManager();
            $em->persist($file->getFile());
            $em->flush();

            return $this->redirectToRoute('file_list');
        }

        return $this->render('FileBundle:Default:create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
