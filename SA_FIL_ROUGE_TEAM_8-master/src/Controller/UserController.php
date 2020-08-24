<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ApprenantRepository;
use App\Repository\ProfilRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    /**
     * @Route(
     *     path="/api/admin/users",
     *     methods={"POST"},
     *     defaults={
     *          "__controller"="App\Controller\UserController::addUser",
     *          "__api_resource_class"=User::class,
     *          "__api_collection_operation_name"="add_user"
     *     }
     * )
     */
    public function addUser(Request $request,UserPasswordEncoderInterface $encoder,SerializerInterface $serializer,ValidatorInterface $validator,ProfilRepository $profil,EntityManagerInterface $manager)
    {
        $user = $request->request->all();
//        $role = $profil->findOneBy(["libelle" => "ADMIN"]);
        $avatar = $request->files->get("avatar");
        $avatar = fopen($avatar->getRealPath(),"rb");
        $user["avatar"] = $avatar;
        $user['archivage']=true;
        if($user['profil']=="/api/admin/profils/1"){
            $user = $serializer->denormalize($user,"App\Entity\Apprenant");

        }elseif($user['profil']=="/api/admin/profils/2"){
            $user = $serializer->denormalize($user,"App\Entity\Formateur");

        }
        elseif($user['profil']=="/api/admin/profils/3"){
            $user = $serializer->denormalize($user,"App\Entity\Admin");

        }elseif($user['profil']=="/api/admin/profils/4"){
            $user = $serializer->denormalize($user,"App\Entity\CM");

        }

        $errors = $validator->validate($user);
        if (count($errors)){
            $errors = $serializer->serialize($errors,"json");
            return new JsonResponse($errors,Response::HTTP_BAD_REQUEST,[],true);
        }
        $password = $user->getPassword();
        $user->setPassword($encoder->encodePassword($user,$password));
//        $user->setProfil($role);
        $manager->persist($user);
//        $role->addUser($user);
        $manager->flush();
        fclose($avatar);
       dd($user);
        return $this->json($serializer->normalize($user),Response::HTTP_CREATED);
    }



    /**
     * @Route(
     * name="getUtilisateurs",
     * path="/admin/users",
     * methods={"GET"},
     * defaults={
     * "_controller"="\app\Controller\UserController::getApprenant",
     * "_api_resource_class"=User::class,
     * "_api_item_operation_name"="getAllUsers"
     * }
     * )
     */
    public function getUtilisateurs(UserRepository $repo,SerializerInterface $serializer)
    {
        $users=$repo->findAll();
        foreach ($users as $user){
            if($user->getArchivage()==1){
                $tabUsers[]=$user;
            }
        }


        $user =$serializer->serialize($tabUsers,"json");
        return new JsonResponse($user,Response::HTTP_OK,[],true);

    }


}