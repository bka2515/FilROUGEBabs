<?php
namespace App\Controller;

use App\Entity\Groupe;
use App\Repository\ApprenantRepository;
use App\Repository\FormateurRepository;
use App\Repository\GroupeRepository;
use App\Repository\GroupeTagRepository;
use App\Repository\PromoRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GroupeController extends AbstractController{


    /**
     * @Route(
     * name="groupe_apprenants_show",
     * path="api/admin/groupe/apprenants",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\GroupeController::groupeApprenants",
     * "_api_resource_class"=Groupe::class,
     * "_api_collection_operation_name"="groupe_pprenants_liste_show"
     * }
     * )
     */
    public function groupeApprenantsShow(GroupeRepository $repo,SerializerInterface $serializer)
    {
        $apprenantsObject=$repo->findAll();
        $apprenants=array();
        foreach ($apprenantsObject as $key){
            if($key->getApprenant()){
                $apprenants[]= $key->getApprenant();

            }

        }
        $regionsJson =$serializer->serialize($apprenants,"json");
        return new JsonResponse($regionsJson,Response::HTTP_OK,[],true);
    }





    /**
     * @Route(
     * name="add_groupe_creer",
     * path="/admin/groupes",
     * methods={"POST"},
     * defaults={
     * "_controller"="App\Controller\GroupeController::addApprenantInGroup",
     * "_api_resource_class"=Groupe::class,
     * "_api_collection_operation_name"="post_group_creer"
     * }
     * )
     */
    public function addApprenantInGroup(PromoRepository $promoRepo,ApprenantRepository $appreRepo,FormateurRepository $formRepo, GroupeRepository $repo,SerializerInterface $serializer,ApprenantRepository $users,Request $request)
    {

        $groupeAdd=json_decode($request->getContent(),true);
        $promo=$promoRepo->find($groupeAdd['promos']['id']);
        $groupe=new Groupe();

        $groupe->setNom($groupeAdd['nom']);
        $groupe->setDateCreation(new \DateTime('now'));
        $groupe->setType($groupeAdd['type']);
        $groupe->setStatut(false);
        $groupe->setPromo($promo);
        if(isset($groupeAdd['formateur'])){
            foreach ($groupeAdd['formateur'] as $key){
                $formateur=$formRepo->find($key['id']);
                if($formateur){
                    $groupe->addFormateur($formateur);
                }
            }
        }
        if(isset($groupeAdd['apprenant'])){
            foreach ($groupeAdd['apprenant'] as $key){
                $apprenant=$appreRepo->find($key['id']);
                if($apprenant){
                    $groupe->addApprenant($apprenant);
                }
            }
        }
        $ems=$this->getDoctrine()->getManager();
        $ems->persist( $groupe);
        $ems->flush();
dd('ok');
        $groupeAjoute =$serializer->serialize($groupe,"json");
        return new JsonResponse($groupeAjoute,Response::HTTP_OK,[],true);
    }


    /**
     * @Route(
     * name="modifierGroupe",
     * path="/admin/groupes/{id}",
     * methods={"PUT"},
     * defaults={
     * "_controller"="App\Controller\GroupeController::modifierGroupe",
     * "_api_resource_class"=Groupe::class,
     * "_api_collection_item_name"="put_groupe"
     * }
     * )
     */

    public function modifierGroupe(Request $request,GroupeRepository $repo,$id,ApprenantRepository $appreRepo,SerializerInterface $serializer){
        $modificationduGroupe=json_decode($request->getContent(),true);
        $groupeAmodifier=$repo->find($id);

        if(isset($modificationduGroupe['nom'])){
            $groupeAmodifier->setNom($modificationduGroupe['nom']);
        }

        if(isset($modificationduGroupe['statut'])){
            $groupeAmodifier->setStatut($modificationduGroupe['statut']);
        }
        if(isset($modificationduGroupe['type'])){
            $groupeAmodifier->setType($modificationduGroupe['type']);
        }

        if(isset($modificationduGroupe['apprenant'])){
            foreach ($modificationduGroupe['apprenant'] as $key){
                $apprenant=$appreRepo->find($key['id']);
                if($apprenant){
                    $groupeAmodifier->addApprenant($apprenant);
                }

            }
        }
        if(isset($modificationduGroupe['formateu'])){
            foreach ($modificationduGroupe['apprenant'] as $key){
                $apprenant=$appreRepo->find($key['id']);
                if($apprenant){
                    $groupeAmodifier->addApprenant($apprenant);
                }

            }
        }
        $em=$this->getDoctrine()->getManager();
        $em->persist($groupeAmodifier);
        $em->flush();
dd('ok');
        $groupeModified =$serializer->serialize($groupeAmodifier,"json");
        return new JsonResponse($groupeModified,Response::HTTP_OK,[],true);

    }











    /**
     * @Route(
     * name="remove_apprenant_groupe",
     * path="/admin/groupes/{id}/apprenants/{idApprenant}",
     * methods={"DELETE"},
     * defaults={
     * "_controller"="App\Controller\GroupeController::removeApprenantFromGroup",
     * "_api_resource_class"=Groupe::class,
     * "_api_item_operation_name"="groupe_remove_apprenants"
     * }
     * )
     */
    public function removeApprenantFromGroup( GroupeRepository $repo,SerializerInterface $serializer,$id,ApprenantRepository $users,$idApprenant)
    {
        $ems=$this->getDoctrine()->getManager();
        $apprenantsObject=$repo->find($id);
        $apprenant=$users->find($idApprenant);
        $apprenantsObject->removeApprenant($apprenant);
        $ems->persist(   $apprenantsObject);
        $ems->flush();

        $regionsJson =$serializer->serialize($apprenantsObject,"json");
        return new JsonResponse($regionsJson,Response::HTTP_OK,[],true);
    }





    /**
     * @Route(
     * name="getAllGroupes",
     * path="api/admin/groupes",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\GroupeController::showAllGroupes",
     * "_api_resource_class"=Groupe::class,
     * "_api_collection_operation_name"="AllGroupes"
     * }
     * )
     */
    public function showAllGroupes( GroupeRepository $repo,SerializerInterface $serializer )
    {
       $alls= $repo->findBy(['statut'=>true]);


        $regionsJson =$serializer->serialize($alls,"json");
        return new JsonResponse($regionsJson,Response::HTTP_OK,[],true);
    }
}