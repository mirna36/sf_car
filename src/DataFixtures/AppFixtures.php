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


    public function __construct(
        CarRepository $carRepository,
        BrandRepository $brandRepository,
        GroupRepository $groupRepository,
        ImageRepository $imageRepository
    ) {
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

            $id_brand = rand(408, 418);
            $id_group = rand(408, 418);

            $brand = $this->brandRepository->find($id_brand);
            $group = $this->groupRepository->find($id_group);

            $car->setBrand($brand);
            $car->setGroupe($group);
            $car->setName($faker->word);
            $car->setYear($faker->numberBetween(1990, 2021));
            $car->setEngine($faker->word);
            $car->setDescription($faker->text);



            $manager->persist($car);
        }

        $manager->flush();
    }
}
