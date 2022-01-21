<?php

namespace App\Controller\Front;

use App\Entity\Group;

use App\Form\GroupType;

use App\Repository\GroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GroupController extends AbstractController
{

    public function groupList(GroupRepository $groupRepository)
    {
        $groups = $groupRepository->findAll();

        return $this->render("front/groups.html.twig", ['groups' => $groups]);
    }

    public function groupShow($id, GroupRepository $groupRepository)
    {
        $group = $groupRepository->find($id);

        return $this->render("front/group.html.twig", ['group' => $group]);
    }

    
}