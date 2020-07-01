<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\CodeGenerator;
use App\Service\Mailer;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function index()
    {
        return $this->render('register/index.html.twig', [
            'controller_name' => 'RegisterController',
        ]);
    }

    /**
     * @Route("register", name="register")
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param Request $request
     * @param CodeGenerator $codeGenerator
     * @param Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function register(UserPasswordEncoderInterface $passwordEncoder,
                             Request $request, CodeGenerator $codeGenerator, Mailer $mailer){
        $user = new User();

//        $form = $this->createForm(PostType::class, $post);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $post->setSlug($slugify->slugify($post->getTitle()));
//            $post->setCreatedAt(new \DateTime());
//
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($post);
//            $em->flush();
//
//            return $this->redirectToRoute('blog_posts');
//        }
//        return $this->render('posts/new.html.twig', [
//            'form' => $form->createView()
//        ]);

    }
}
