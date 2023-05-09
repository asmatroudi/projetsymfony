<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;


class UtilisateurApiController extends AbstractController
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }
    #[Route('/user/All', name: 'app_admins_liste')]
    public function ListeAdmin(UtilisateurRepository $userRepository, SerializerInterface $serializer)
    {
        $users = $userRepository->findAll();
        $formatted = $serializer->normalize($users, null, [
            'attributes' => [
                'iduser',
                'email',
                'role',
                'nom',
                'prenom',
                'cin',
                'adresse',
                'age'
            ]
        ]);
    
        $json = json_encode($formatted);
        return new Response($json);
    }
    
    #[Route('/user/signup', name: 'app_api_register')]
    public function signupAction (Request $request , UserPasswordEncoderInterface $passwordEncoder)
    {
       $email=$request->query->get(key:"email");
       $password=$request->query->get(key:"password");
       $nom=$request->query->get(key:"nom");
       $prenom=$request->query->get(key:"prenom");
       $age=$request->query->get(key:"age");
       $adresse=$request->query->get(key:"adresse");
       $cin=$request->query->get(key:"cin");


       if(!filter_var($email,filter:FILTER_VALIDATE_EMAIL)){
        return new Response(content:"email invalide.");
       }

       $user=new Utilisateur();
       
       $user->setRoles(['role' => 'ROLE_USER']);
       $user->setRole('user');

       $user->setEmail($email);
       $user->setPassword($this->passwordHasher->hashPassword($user, $password));
       $user->setNom($nom);
       $user->setPrenom($prenom);
       $user->setAge($age);
       $user->setAdresse($adresse);
       $user->setCin($cin);

    
    

       try {
        $em=$this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return new JsonResponse(data:"Account is created",status:200);//200 : Http result of server = ok

       }catch(\Exception $ex){
        return new Response(content:"exception".$ex->getMessage());



       }


    }

    #[Route('/user/signin', name: 'app_api_login')]
    public function signinAction(Request $request)
    {
        $email = $request->query->get('email');
        $password = $request->query->get('password');
    
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(Utilisateur::class)->findOneBy(['email' => $email]);
    
        if ($user) {
            if (password_verify($password, $user->getPassword())) {
                $serializer = new Serializer([new ObjectNormalizer()]);
                $formatted = $serializer->normalize($user, null, [
                    'attributes' => [
                        'iduser',
                        'prenom',
                        'email',
                        'nom',
                        'age',
                        'adresse',
                        'cin',   
                        'role'  
                    ]
                ]);
                return new JsonResponse($formatted);
            } else {
                return new Response('Password not found');
            }
        } else {
            return new Response('User not found');
        }
    }
    

    #[Route('/user/editUser', name: 'app_gestion_profile')]

    public function editUser(Request $request){
            $id=$request->get(key:"id");
            $nom=$request->query->get(key:"nom");
            $prenom=$request->query->get(key:"prenom");
            $age=$request->query->get(key:"age");
            $adresse=$request->query->get(key:"address");
            $cin=$request->query->get(key:"cin");


            $em=$this->getDoctrine()->getManager();
            $user=$em->getRepository(Utilisateur::class)->find($id);

            $user->setNom($nom);
            $user->setPrenom($prenom);
            $user->setAge($age);
            $user->setAdresse($adresse);
            $user->setCin($cin);
     



           
            try {
                $em=$this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                return new JsonResponse(data:"Success",status:200);//200 : Http result of server = ok
        
               }catch(\Exception $ex){

                return new Response(content:"failed".$ex->getMessage());
        
        
        
               }

                             
                             
                         
                               





    }

      #[Route('/users/updatepassword', name: 'updatepassword')]
      public function updatepassword(Request $request,UserPasswordEncoderInterface $passwordEncoder) :JsonResponse
      {
        $user = new Utilisateur();
        $email = $request->query->get("email");
        $password = $request->query->get("password");


        $rep = $this->getDoctrine()->getManager();
       
        $user = $this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(['email' => $email]);

        $user->setPassword($this->passwordHasher->hashPassword($user, $password));



     
         
        $rep->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize("Mot de passe a ete changer");
        return new JsonResponse($formatted);
          
        }

      #[Route('/users/checkemail', name: 'checkemail')]
      public function checkemail(Request $request):JsonResponse
      {
        $user = new Utilisateur();
          $email = $request->query->get("email");
   


          
          $rep = $this->getDoctrine()->getManager();
   
     
          $user = $this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(['email' => $email]);

    
if($user){

    $serializer = new Serializer([new ObjectNormalizer()]);
    $formatted = $serializer->normalize("email exist");
    return new JsonResponse($formatted);

}
       
        }

#[Route('/user/deletedisUser', name: 'deleteUser', methods: ['DELETE'])]
public function deleteUser(Request $request): Response
{
    $user = new Utilisateur();
    $id = $request->query->get("id");
    $rep = $this->getDoctrine()->getRepository(Utilisateur::class);
    $em = $this->getDoctrine()->getManager();
    $user = $rep->find($id);
    $em->remove($user);
    $em->flush();
    $serializer = new Serializer([new ObjectNormalizer()]);
$formatted = $serializer->normalize("user got deleted");
return new JsonResponse($formatted);
}
}
