<?php

namespace App\Controller\Admin;

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

        return $this->render("admin/groups.html.twig", ['groups' => $groups]);
    }

    public function groupShow($id, GroupRepository $groupRepository)
    {
        $group = $groupRepository->find($id);

        return $this->render("admin/group.html.twig", ['group' => $group]);
    }

    public function groupUpdate(
        $id,
       GroupRepository $groupRepository,
        Request $request,
        EntityManagerInterface $entityManagerInterface
    ) {
        $group = $groupRepository->find($id);

        $groupForm = $this->createForm(GroupType::class, $group);

        $groupForm->handleRequest($request);

        if ($groupForm->isSubmitted() && $groupForm->isValid()) {
            $entityManagerInterface->persist($group);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('admin_group_list');
        }

        return $this->render("admin/groupForm.html.twig", ['groupForm' => $groupForm->createView()]);
    }

    public function createGroup(
        EntityManagerInterface $entityManagerInterface,
        Request $request
    ) {

        $group = new Group();

        $groupForm = $this->createForm(GroupType::class, $group);

        $groupForm->handleRequest($request);

        if ($groupForm->isSubmitted() && $groupForm->isValid()) {

           
            $entityManagerInterface->persist($group);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('admin_group_list');
        }

        return $this->render("admin/groupForm.html.twig", ['groupForm' => $groupForm->createView()]);
    }

    public function deleteGoup(
        $id,
        EntityManagerInterface $entityManagerInterface,
        GroupRepository $groupRepository
    ) {
        $group = $groupRepository->find($id);

        $entityManagerInterface->remove($group);

        $entityManagerInterface->flush();

        return $this->redirectToRoute("admin_group_list");
    }
}