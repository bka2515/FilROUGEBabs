<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class FormateurController extends AbstractController
{
    /**
     * @Route("/formateur", name="formateur")
     */
    public function index()
    {
        return $this->render('formateur/index.html.twig', [
            'controller_name' => 'FormateurController',
        ]);
    }

    /**
     * @Route(
     * name="formateur_liste",
     * path="api/formateurs",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\FormateurController::listerFormateur",
     * "_api_resource_class"=User::class,
     * "_api_collection_operation_name"="get_formateurs"
     * }
     * )
     */
    public function listerFormateur(UserRepository $repo,SerializerInterface $serializer)
    {
        $regionsObject=$repo->findByProfil("FORMATEUR");
        $regionsJson =$serializer->serialize($regionsObject,"json");
        return new JsonResponse($regionsJson,Response::HTTP_OK,[],true);
    }

    /**
     * @Route(
     * name="formateur_liste_one",
     * path="api/formateur/{id}",
     * methods={"GET"},
     * defaults={
     * "_controller"="\app\Controller\FormateurController::findFormateur",
     * "_api_resource_class"=User::class,
     * "_api_item_operation_name"="get_formateur"
     * }
     * )
     */
    public function findFormateur(UserRepository $repo,SerializerInterface $serializer, $id)
    {
        $regionsObject=$repo->find($id);
        $regionsJson =$serializer->serialize($regionsObject,"json");
        return new JsonResponse($regionsJson,Response::HTTP_OK,[],true);
    }

    /**
     * @Route(
     * name="modifierFormateur",
     * path="api/modifierFormateur/{id}",
     * methods={"PUT"},
     * defaults={
     * "_controller"="\app\Controller\FormateurApprenantController::modifierFormateur",
     * "_api_resource_class"=User::class,
     * "_api_item_operation_name"="put_modifierFormateur"
     * }
     * )
     */
    public function modifierFormateur(Request $request,UserRepository $repo,SerializerInterface $serializer,$id)
    {
        $em=  $this->getDoctrine()->getManager();
        $user=$serializer->deserialize($request->getContent(),User::class,'json');
        $em->persist($user);
        $em->flush();

    }





}
