<?php

namespace App\Controller\Admin;

use App\Entity\Image;

use App\Form\ImageType;

use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ImageController extends AbstractController
{

    /**
     * @Route("admin/create/media", name="admin_create_media")
     */
    public function createMedia(
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        SluggerInterface $sluggerInterface
    ) {

        $image = new Image();

        $imageForm = $this->createForm(FormType::class, $image);

        $imageForm->handleRequest($request);

        if ($imageForm->isSubmitted() && $imageForm->isValid()) {

            $imageFile = $imageForm->get('src')->getData();

            if ($imageFile) {
                // On créé un nom unique avec le nom original de l'image pour éviter
                // tout problème
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // on utilise slug sur le nom original de l'image pour avoir un nom valide
                $safeFilename = $sluggerInterface->slug($originalFilename);
                // on ajoute un id unique au nom de l'image
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();


                // On déplace le fichier dans le dossier public/media
                // la destination du fichier est enregistré dans 'images_directory'
                // qui est défini dans le fichier config\services.yaml
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $image->setSrc($newFilename);
            }

            $image->setAlt($imageForm->get('title')->getData());

            $entityManagerInterface->persist($image);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_car_list");
        }

        return $this->render('admin/imageform.html.twig', ['imageForm' => $imageForm->createView()]);
    }
}