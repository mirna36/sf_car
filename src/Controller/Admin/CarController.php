<?php

namespace App\Controller\Admin;

use App\Entity\Car;

use App\Form\CarType;

use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CarController extends AbstractController
{

    

    public function carUpdate(
        $id,
        CarRepository $carRepository,
        Request $request,
        EntityManagerInterface $entityManagerInterface
    ) {
        $car = $carRepository->find($id);
    

        $carForm = $this->createForm(CarType::class, $car);
        //dd($carForm);
        $carForm->handleRequest($request);
        //dd($carForm);

        if ($carForm->isSubmitted() && $carForm->isValid()) {
            
            
            $entityManagerInterface->persist($car);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('front_car_list');
        }

        return $this->render("admin/carForm.html.twig", ['carForm' => $carForm->createView()]);
    }

    public function createCar(
        EntityManagerInterface $entityManagerInterface,
        Request $request
    ) {

        $car = new Car();

        $carForm = $this->createForm(CarType::class, $car);

        $carForm->handleRequest($request);
       

        if ($carForm->isSubmitted() && $carForm->isValid()) {

           
            $entityManagerInterface->persist($car);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('front_car_list');
        }

        return $this->render("admin/carForm.html.twig", ['carForm' => $carForm->createView()]);
    }

    public function deleteCar(
        $id,
        EntityManagerInterface $entityManagerInterface,
        CarRepository $carRepository
    ) {
        $car = $carRepository->find($id);

        $entityManagerInterface->remove($car);

        $entityManagerInterface->flush();

        return $this->redirectToRoute("front_car_list");
    }
}