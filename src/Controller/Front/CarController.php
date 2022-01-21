<?php

namespace App\Controller\Front;

use App\Entity\Car;

use App\Form\CarType;

use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CarController extends AbstractController
{

    public function carList(CarRepository $carRepository)
    {
        $cars = $carRepository->findAll();

        return $this->render("front/cars.html.twig", ['cars' => $cars]);
    }

    public function carShow($id, CarRepository $carRepository)
    {
        $car = $carRepository->find($id);

        return $this->render("front/car.html.twig", ['car' => $car]);
    }

    public function frontSearch(Request $request, CarRepository $carRepository){
        $term = $request->query->get('term');
        $cars = $carRepository->searchByTerm($term);
        return $this->render('front/search.html.twig',['cars' => $cars, 'term' => $term]);

    }

    

    
}