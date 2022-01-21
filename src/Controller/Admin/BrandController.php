<?php

namespace App\Controller\Admin;

use App\Entity\Brand;

use App\Form\BrandType;

use App\Repository\BrandRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BrandController extends AbstractController
{

    
    public function brandUpdate(
        $id,
        BrandRepository $brandRepository,
        Request $request,
        EntityManagerInterface $entityManagerInterface
    ) {
        $brand = $brandRepository->find($id);

        $brandForm = $this->createForm(BrandType::class, $brand);

        $brandForm->handleRequest($request);

        if ($brandForm->isSubmitted() && $brandForm->isValid()) {
            $entityManagerInterface->persist($brand);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('admin_brand_list');
        }

        return $this->render("admin/brandForm.html.twig", ['brandForm' => $brandForm->createView()]);
    }

    public function createBrand(
        EntityManagerInterface $entityManagerInterface,
        Request $request
    ) {

        $brand = new Brand();

        $brandForm = $this->createForm(BrandType::class, $brand);

        $brandForm->handleRequest($request);

        if ($brandForm->isSubmitted() && $brandForm->isValid()) {

           
            $entityManagerInterface->persist($brand);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('admin_brand_list');
        }

        return $this->render("admin/brandForm.html.twig", ['brandForm' => $brandForm->createView()]);
    }

    public function deleteBrand(
        $id,
        EntityManagerInterface $entityManagerInterface,
        BrandRepository $brandRepository
    ) {
        $brand = $brandRepository->find($id);

        $entityManagerInterface->remove($brand);

        $entityManagerInterface->flush();

        return $this->redirectToRoute("admin_brand_list");
    }
}