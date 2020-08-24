<?php
namespace App\Controller;

use App\Repository\ProfilRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Profil;
use Symfony\Component\Serializer\SerializerInterface;

class ProfilController extends AbstractController{

    /**
     * @Route(
     * name="delete_profil",
     * path="api/admin/profils/{id}",
     * methods={"DELETE"},
     * defaults={
     * "_controller"="App\Controller\ProfilController::DeleteProfil",
     * "_api_resource_class"=Profil::class,
     * "_api_collection_operation_name"="deleteProfil"
     * }
     * )
     */

    public function DeleteProfil(ProfilRepository $profilRepository,$id){
        $profil=$profilRepository->find($id);
        $profil->setArchivage(false);
        $em=$this->getDoctrine()->getManager();
        $em->persist($profil);
        $em->flush();
    }



    /**
     * @Route(
     * name="get_profil",
     * path="api/admin/profils",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\ProfilController::getALLProfil",
     * "_api_resource_class"=Profil::class,
     * "_api_collection_operation_name"="geteProfil"
     * }
     * )
     */

    public function getALLProfil(ProfilRepository $profilRepository,SerializerInterface $serializer){
        $profil=$profilRepository->findBy(["archivage"=>true]);
        $profilShow =$serializer->serialize($profil,"json");
        return new JsonResponse($profilShow,Response::HTTP_OK,[],true);
    }
}