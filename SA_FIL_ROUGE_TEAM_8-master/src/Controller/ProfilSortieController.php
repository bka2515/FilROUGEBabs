<?php

namespace App\Controller;

use App\Entity\ProfilSortie;
use App\Repository\ApprenantRepository;
use App\Repository\ProfilSortieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilSortieController extends AbstractController
{
    /**
     * @Route("/profil/sortie", name="profil_sortie")
     */
    public function index()
    {
        return $this->render('profil_sortie/index.html.twig', [
            'controller_name' => 'ProfilSortieController',
        ]);
    }
    /**
     * @Route(
     * name="lister_profilSortie",
     * path="api/admin/profilsortie",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\ProfilSortieController::listerProfilSortie",
     * "_api_resource_class"=ProfilSortie::class,
     * "_api_collection_operation_name"="get_profilSortie"
     * }
     * )
     */
    public function listerProfilSortie(ProfilSortieRepository $repo,SerializerInterface $serializer)
    {
        $profilSorties=$repo->findAll();
        foreach ($profilSorties as $profilSortie){
            if($profilSorties->getArchivage()==1){
                $tabProfilSorties[]=$profilSorties;
            }
        }
        $regionsJson =$serializer->serialize($tabApprenants,"json");
        return new JsonResponse($regionsJson,Response::HTTP_OK,[],true);
    }
    /**
     * @Route(
     * name="ajouter_profilSortie",
     * path="api/admin/profilsortie",
     * methods={"POST"},
     * defaults={
     * "_controller"="App\ProfilSortieController::ajouterProfilSorties",
     * "_api_resource_class"=ProfilSortie::class,
     * "_api_collection_operation_name"="post_ajouterProfilSortie"
     * }
     * )
     */
    public function ajouterApprenant(Request $request,ProfilSortieRepository $repo,SerializerInterface $serializer)
    {

        $user= $serializer->deserialize($request->getContent(),ProfilSortie::class,'json');

        $em=  $this->getDoctrine()->getManager();
        $em->persist($user);

        $em->flush();
    }
     /**
     * @Route(
     * name="updateProfilSortie",
     * path="api/admin/profilsortie/{id}",
     * methods={"PUT"},
     * defaults={
     * "_controller"="App\Controller\ProfilSortieController::updateProfilSortie",
     * "_api_resource_class"=ProfilSortie::class,
     * "_api_item_operation_name"="putProfilSortie"
     * }
     * )
     */
    public function updateProfilSortie(ProfilSortieRepository $profiSRepo,Request $request,SerializerInterface $serializer,$id)
    {
        $profilSortie=$profiSRepo->find($id);
        $aMod=json_decode($request->getContent(),true);
        if(isset($aMod['libelle'])){
            $profilSortie->setLibelle($aMod['libelle']);
        }
        
       $em=$this->getDoctrine()->getManager();
        $em->persist($profilSortie);
        $em->flush();
    }
    /**
     * @Route(
     * name="get_profilSortiAndApp",
     * path="api/admin/profilsortie/{id}",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\ProfilSortieController::getProfilSortieAndApp",
     * "_api_resource_class"=ProfilSortie::class,
     * "_api_collection_operation_name"="get_profilSortiAndApp"
     * }
     * )
     */
    public function getProfilSortieAndApp(ApprenantRepository $appRepo,ProfilSortieRepository $PflRepo,Request $request,SerializerInterface $serializer,$id){
        dd($profilSorties=$appRepo->getApprenant());
    }
}
 