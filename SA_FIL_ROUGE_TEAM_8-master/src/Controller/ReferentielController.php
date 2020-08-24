<?php
namespace App\Controller;

use App\Entity\Referentiel;
use App\Repository\GroupeCompetencesRepository;
use App\Repository\ReferentielRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class ReferentielController extends AbstractController{

    /**
     * @Route(
     * name="groupecompetences_by_referentiel",
     * path="/admin/referentiels/groupecompetences",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\ReferentielController::groupecompetencesByReferentiel",
     * "_api_resource_class"=Referentiel::class,
     * "_api_collection_operation_name"="get_all_groupecompetencesBy_Referentiel"
     * }
     * )
     */
    public function groupecompetencesByReferentiel(ReferentielRepository $repo,SerializerInterface $serializer)
    {
        $referentielObject=$repo->findAll();
        foreach ($referentielObject as $key){
            $grpeCptences[]=$key->getGroupeCompetences();

        }

        $grpeJson =$serializer->serialize($grpeCptences,"json");
        return new JsonResponse($grpeJson,Response::HTTP_OK,[],true);
    }
    /**
     * @Route(
     * name="competence_by_grpeCptence",
     * path="/admin/referentiels/{idRef}/grpecompetences",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\ReferentielController::getCompetenceBygrpeCptence",
     * "_api_resource_class"=Referentiel::class,
     * "_api_collection_operation_name"="get_competence_by_grpeCptence"
     * }
     * )
     */
    public function getCompetenceBygrpeCptence( GroupeCompetencesRepository $grpRepo, ReferentielRepository $repo,SerializerInterface $serializer,$idRef)
    {
        $tab=array();
        $referentielObject=$repo->find($idRef);
        $grpeCptences= $referentielObject->getGroupeCompetences();
        foreach ($grpeCptences as $grpeCptence) {
            $req=$grpRepo->find($grpeCptence->getId());
            if($req->getCompetence()!=""){
                array_push($tab,$req->getCompetence());
            }

        }

        $grpeJson =$serializer->serialize($tab,"json");
        return new JsonResponse($grpeJson,Response::HTTP_OK,[],true);
    }






    /**
     * @Route(
     * name="updatingRefer",
     * path="api/admin/referentiels/{id}",
     * methods={"PUT"},
     * defaults={
     * "_controller"="App\Controller\ReferentielController::updatingReferentiel",
     * "_api_resource_class"=Referentiel::class,
     * "_api_item_operation_name"="putReferModif"
     * }
     * )
     */
    public function updatingReferentiel(Request $request, GroupeCompetencesRepository $grpRepo, ReferentielRepository $repo,SerializerInterface $serializer,$id)
    {
$referentiel=$repo->find($id);
$all=$referentiel->getGroupeCompetences();
$grps=json_decode($request->getContent(),true);
foreach ($grps['groupeCompetence'] as $key){
    $bool=false;
   $grpeCptce= $grpRepo->find($key['id']);
   if($grpeCptce){
       foreach ($all as $keys){
           if($keys->getId()==$key['id']){
               $bool=true;
           }
       }
       if($bool==true){
           $referentiel->removeGroupeCompetence($grpeCptce);
       }else{
           $referentiel->addGroupeCompetence($grpeCptce);
       }
   }
}
$em=$this->getDoctrine()->getManager();
$em->persist($referentiel);
$em->flush();

        $grpeJson =$serializer->serialize($referentiel,"json");
        return new JsonResponse($grpeJson,Response::HTTP_OK,[],true);
    }

    /**
     * @Route(
     *     name="postReferentiel",
     *     path="/api/admin/referentiels",
     *     methods={"POST"},
     *     defaults={
     *          "__controller"="App\Controller\ReferentielController::addReferentiel",
     *          "__api_resource_class"=Referentiel::class,
     *          "__api_collection_operation_name"="add_referentiel"
     *     }
     * )
     */

    public function addReferentiel(GroupeCompetencesRepository $grpRepo,Request $request,SerializerInterface $serializer,ValidatorInterface $validator,EntityManagerInterface $manager)
    {
    $referentiel = $request->request->all();
    //dd($referentiel['groupeCompetence']);
    $allId=explode('/',$referentiel['groupeCompetence']);
    $tabGrps=array();
    foreach ($allId as $key){
        $grpCptence=$grpRepo->find($key);
    if($grpCptence){
        $tabGrps[]=$grpCptence;
    }
    }

        $progr= $request->files->get("programme");
        $programme= fopen($progr->getRealPath(),"rb");
        $referentiel['programme']=$programme;
      //  $referentiel['groupeCompetences']=$tabGrps;
        $referentiel = $serializer->denormalize($referentiel,"App\Entity\Referentiel");
        foreach ($tabGrps as $keys){
            $referentiel->addGroupeCompetence($keys);
        }
        $em=$this->getDoctrine()->getManager();
        $em->persist($referentiel);
        $em->flush();
        fclose($programme);

     //   dd($programme);
       $grpeJson =$serializer->serialize($referentiel,"json");
        return new JsonResponse($grpeJson,Response::HTTP_OK,[],true);
      //  return $this->json($serializer->normalize($referentiel),Response::HTTP_CREATED);
    }
}