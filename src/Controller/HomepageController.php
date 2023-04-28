<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\RequestStack;

use App\Entity\User;
use App\Repository\UserRepository;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="main_homepage")
     */
    public function index() : Response
    {
        return $this->render('home/index.html.twig', [ //RENDER = Convert twig template into visual page
            'title' => 'Join our family',
            'subtitle' => 'CoRide',
]);
       
    }

    /**
     * @Route("/back", name="main_back")
     */
    public function backView(UserRepository $ur) : Response
    {
        $a = $ur->findAll();
        return $this->render('back/table.html.twig', [
            'title' => 'Join our family',
            'subtitle' => 'CoRide',
            'mohammed' => $a //context
]);
       
    }

    /**
     * @Route("/sign-up/form", name="sign-up")
     */
    public function signupView(
        Request $request, 
        EntityManagerInterface $entityManager, 
        UserRepository $ur,
        RequestStack $requestStack,
        MailerInterface $mailer)
    {
        if($request->request->get("sign-up")){ //AJAX IF EXIST
            $u = new User();
            $roles = ["ROLE_USER"];
            array_push($roles, $request->request->get("role"));
            $u->setName($request->request->get("name"));
            $u->setLastName($request->request->get("lname"));
            $u->setEmail($request->request->get("email"));
            $u->setPassword($u->encrypt_decrypt("encrypt", $request->request->get("password")));
            $u->setGender($request->request->get("gender"));
            $u->setRoles($roles);
            $u->setPhone($request->request->get("phone"));
            $u->setBirthday(\DateTime::createFromFormat('Y-m-d', $request->request->get("birthday")));
            $u->setAccess("oui");

            //send email
            $email = (new Email())
            ->from('coride@coride.tn')
            ->to($u->getEmail())
            ->subject('Account Confirmation')
            ->text('We are confirming your account')
            ->html('<p>Account confirmation</p>');

            $mailer->send($email);

            //Save to database
            $entityManager->persist($u);
            $entityManager->flush();

            $u = $this->login($request->request->get("email"), $request->request->get("password"), $ur);
            $this->sessionSetUser($u, $requestStack);

            return $this->redirectToRoute('main_homepage');
        } else {
            return $this->render('User/sign-up.html.twig', []); //FORMULAIRE
        }
    }

    /**
     * @Route("/back/add-form", name="back-add-user")
     */
    public function backAddView(
        Request $request, 
        EntityManagerInterface $entityManager, )
    {
        if($request->request->get("sign-up")){
            $u = null;
            if($request->request->get("edit-id")){
                $u = $entityManager->getRepository(User::class)->find(intval($request->request->get("edit-id")));
            } else {
                $u = new User();
            }
            
            $roles = ["ROLE_USER"];
            array_push($roles, $request->request->get("role"));
            $u->setName($request->request->get("name"));
            $u->setLastName($request->request->get("lname"));
            $u->setEmail($request->request->get("email"));
            $u->setPassword($u->encrypt_decrypt("encrypt", $request->request->get("password")));
            $u->setGender($request->request->get("gender"));
            $u->setRoles($roles);
            $u->setPhone($request->request->get("phone"));
            $date = \DateTime::createFromFormat('Y-m-d', $request->request->get("birthday"));
            $u->setBirthday(\DateTime::createFromFormat('Y-m-d', $request->request->get("birthday")));
            $u->setAccess($request->request->get("access"));

            $entityManager->persist($u);
            $entityManager->flush();
            return $this->redirectToRoute('main_homepage');
        } else {
            return $this->render('User/sign-up.html.twig', []);
        }
    }

    /**
     * @Route("/log-in/form", name="log-in")
     */
    public function loginView(
        Request $request, 
        EntityManagerInterface $entityManager,
        RequestStack $requestStack){
        $captcha = ["3ay33", "8tpwc", "d2zk6", "unmhe", "fsdh9", "e9rb4", "48n2a", "4bh23", "fetj5", "byrdi"];
        if($request->request->get('login-submit') != null){ //IF AJAX EXIST
            $rep = $entityManager->getRepository(User::class);
            $user = $this->login($request->request->get('email'), $request->request->get('password'), $rep);
            if($user){
                $this->sessionSetUser($user, $requestStack);
                foreach($user->getRoles() as $r){
                    if($r == "ROLE_ADMIN"){
                        return new Response('/back');
                    }
                }
                return new Response('/');
            } else {
                return $this->render('User/sign-up.html.twig');
            }
        } else {
            srand(rand());
            $tmp_c = rand(0, 9);
            return $this->render('User/login.html.twig', [
                'captcha_image' => "captcha/" . $tmp_c . ".jpg",
                'captcha_code' => $captcha[$tmp_c]
            ]); //FORMULAIRE
        }
    }

    /**
     * @Route("/signout/", name="sign-out")
     */
    public function signoutView(
        Request $request, 
        RequestStack $requestStack){
        $this->sessionSetUser(null, $requestStack);
        return $this->redirectToRoute('main_homepage');
    }

    /**
     * @Route("/edit-profile", name="edit-form-back")
     */
    public function editBackView(Request $request, EntityManagerInterface $entityManager){
        $u = $entityManager->getRepository(User::class)->find(intval($request->request->get("edit-id")));
        return $this->render("back/user-form.html.twig", ['user' => $u]);
    }

    #[Route('/name/{name}', name: 'name', defaults: ['name' => 'vide'], methods: ['GET'])]
    public function param($name)
    {
        return new Response(
        "salut $name !"
        );
    }

    public function login($email, $pw, $rep){
        $user = null;
        $c = new User();
        $users = $rep->findAll();
        foreach($users as $u){
            if(($u->getEmail() == $email)&&($u->getPassword() == $pw)){
                if($u->getAccess() == "oui"){
                    return $u;
                }
            }
        }
        return null;
    }

    public function sessionSetUser($user, $rs){
        $session = $rs->getSession();
        $session->set('current_user', $user);
    }
}
