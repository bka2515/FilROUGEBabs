<?php
namespace App\Controller;
use App\Entity\Competence;
use App\Entity\GroupeCompetences;
use App\Entity\Niveau;
use App\Repository\CompetenceRepository;
use App\Repository\GroupeCompetencesRepository;
use App\Repository\NiveauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CompetenceController extends AbstractController{

    /**
     * @Route(
     * name="Competence_liste",
     * path="/admin/competences",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\CompetenceController::listerCompetence",
     * "_api_resource_class"=GroupeCompetences::class,
     * "_api_collection_operation_name"="get_Competence_liste"
     * }
     * )
     */
    public function listerCompetence(CompetenceRepository $repo,SerializerInterface $serializer)
    {
        $grpeCompetences=new Competence();
        $this->denyAccessUnlessGranted('getCompetence',$grpeCompetences,'Accés non autorisé');
        $grpeObject=$repo->findAll();
        $grpeJson =$serializer->serialize($grpeObject,"json");
        return new JsonResponse($grpeJson,Response::HTTP_OK,[],true);
    }


    /**
     * @Route(
     * name="competence_add",
     * path="/admin/competences",
     * methods={"POST"},
     * defaults={
     * "_controller"="App\Controller\CompetenceController::addCompetence",
     * "_api_resource_class"=Competence::class,
     * "_api_collection_operation_name"="postCompetence"
     * }
     * )
     */
    public function addCompetence(GroupeCompetencesRepository $gcr,CompetenceRepository $repo,SerializerInterface $serializer,Request $request)
    {

        $r=json_decode($request->getContent(),true);

        $competence=new Competence();
        $competence->setLibelle($r['libelle']);
    //   $groupe= $gcr->find($r['groupeCompetences']['0']['id']);
     //   $competence->addGroupeCompetence($groupe);
        foreach ($r['niveaux'] as $key){
            $niveau= new Niveau();
            $niveau->setLibelle($key['libelle']);
            $niveau->setCritereEvaluation($key['critereEvaluation']);
            $niveau->setGroupeActionARealiser($key['groupeActionARealiser']);
        $competence->addNiveau($niveau);

        }

    $manager=$this->getDoctrine()->getManager();
        $manager->persist($competence);
     //   dd( $competence);
        $manager->flush();


        return new JsonResponse('ok',Response::HTTP_OK,[],true);
    }



    /**
     * @Route(
     * name="Competence_One",
     * path="/admin/competences/{id}",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\CompetenceController::getOneCompetence",
     * "_api_resource_class"=GroupeCompetences::class,
     * "_api_item_operation_name"="get_One_Competence"
     * }
     * )
     */
    public function getOneCompetence(CompetenceRepository $repo,SerializerInterface $serializer,$id)
    {
        $grpeCompetences=new Competence();
        $this->denyAccessUnlessGranted('getCompetenceOne',$grpeCompetences,'Accés non autorisé');
        $grpeObject=$repo->find($id);
        $grpeJson =$serializer->serialize($grpeObject,"json");
        return new JsonResponse($grpeJson,Response::HTTP_OK,[],true);
    }



    /**
     * @Route(
     * name="put_Competence",
     * path="/admin/competences/{id}",
     * methods={"PUT"},
     * defaults={
     * "_controller"="App\Controller\CompetenceController::putCompetence",
     * "_api_resource_class"=GroupeCompetences::class,
     * "_api_item_operation_name"="put_One_Competence"
     * }
     * )
     */
    public function putCompetence(NiveauRepository $nivRep,GroupeCompetencesRepository $grps, CompetenceRepository $repo,SerializerInterface $serializer,$id,Request $request)
    {
        $compet=$repo->find($id);
        //dd($compet);

        $donnees=json_decode($request->getContent(),true);
        if(isset($donnees['libelle'])){
            $compet->setLibelle($donnees['libelle']);
        }
        if(isset($donnees['groupeCompetences'][0])){
            $GpCpten=$grps->find($donnees['groupeCompetences'][0]);
            $compet->addGroupeCompetence($GpCpten);
        }
        if(isset($donnees['niveaux'])){
            foreach($donnees['niveaux'] as $niveau){
                if(isset( $niveau['id']) ){
                $niveauModif=$nivRep->find($niveau['id']);
                if(isset($niveau['groupeActionARealiser'])){
                    $niveauModif->setGroupeActionARealiser($niveau['groupeActionARealiser']);
                }
                    if(isset($niveau['libelle'])){
                        $niveauModif->setLibelle($niveau['libelle']);
                    }
                    if(isset($niveau['critereEvaluation'])){
                        $niveauModif->setCritereEvaluation($niveau['critereEvaluation']);
                    }
                   // $competModif=$compet->find($niveau['id']);
                    //$competModif->setLibelle($niveau['libelle']);
                    //   $grpeCompetences->addCompetence($competModif);

                }
              /*  if(!isset( $niveau['id']) && isset( $niveau['libelle']) && isset( $niveau['groupeActionARealiser'] )&& isset( $niveau['critereEvaluation'])){
                    $newNiveau=new Niveau();
                    $newNiveau->setLibelle($niveau['libelle']);
                    $newNiveau->setGroupeActionARealiser($niveau['groupeActionARealiser']);
                    $newNiveau->setCritereEvaluation($niveau['critereEvaluation']);
                    $compet->addNiveau($newNiveau);

                }*/
                /*if(isset( $niveau['id']) && !isset( $niveau['libelle']) && !isset( $niveau['groupeActionARealiser'] )&& !isset( $niveau['critereEvaluation'])){
                    $niveauSupp=$nivRep->find($niveau['id']);
                    $bool=false;
                    foreach ( $compet->getNiveaux()->getValues() as $key){
                        if($key->getId()==$niveauSupp->getId()){
                            $bool=true;
                        }
                    }
                    if($bool==true){
                        $compet->removeNiveau($niveauSupp);
                    }else{
                        $compet->addNiveau($niveauSupp);
                    }


                }*/
            }
        }
        $em=$this->getDoctrine()->getManager();
        $em->persist($compet);
        $em->flush();



        return new JsonResponse('ok',Response::HTTP_OK,[],true);
    }


}