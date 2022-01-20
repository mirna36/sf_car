<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use Faker\Factory;
use App\Entity\Car;
use App\Entity\Group;
use App\Entity\Image;
use App\Repository\CarRepository;
use App\Repository\BrandRepository;
use App\Repository\GroupRepository;
use App\Repository\ImageRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    private $carRepository;
    private $brandRepository;
    private $groupRepository;
    private $imageRepository;


    public function __construct(CarRepository $carRepository, BrandRepository $brandRepository, 
    GroupRepository $groupRepository,  ImageRepository $imageRepository )
    {
        $this->carRepository = $carRepository;
        $this->brandRepository = $brandRepository;
        $this->groupRepository = $groupRepository;
        $this->imageRepository = $imageRepository;
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create();
        for ($i = 0; $i < 11; $i++) {
            $brand  = new Brand();

            $brand->setName($faker->word);
            $brand->setCountrie($faker->country);

            $manager->persist($brand);

            $manager->flush();
        }

        for ($i = 0; $i < 11; $i++) {
            $group  = new Group();

            $group->setName($faker->word());
            $group->setCountrie($faker->country);

            $manager->persist($group);

            $manager->flush();
        }
      
        for ($i = 0; $i < 11; $i++) {
            
            $car = new Car();
            
            $id_brand = rand(111, 121);
            $id_group = rand(111, 121);

            $brand = $this->brandRepository->find($id_brand);
            $group = $this->groupRepository->find($id_group);
            $car->setBrand($faker->$brand);
            $car->setGroupe($faker->$group);
            $car->setName($faker->word);
            $car->setYear($faker->year($max = "now"));
            $car->setEngine($faker->word);
            $car->setDescription($faker->text);
            
            

            $manager->persist($car);

            $manager->flush();
        }

        for ($i = 0; $i < 11; $i++) {
            $image  = new Image();
            $car_id   = rand(1, 10);
            $car = $this->groupRepository->find($car_id );
          
            $width = 640;
            $height = 480;

            $image->setSrc($faker->image($width,$height,'cats'));
            $image->setAlt($faker->word);
            $image->setCar($car);

            $manager->persist($image);

            $manager->flush();
            
        }

        
    }
}
