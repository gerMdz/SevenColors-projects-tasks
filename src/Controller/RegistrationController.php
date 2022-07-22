<?php

namespace App\Controller;

use App\Entity\UserNd;
use App\Form\RegistrationFormType;
use App\Repository\UserNdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     * @param Request $request
     * @param UserPasswordHasherInterface $userPasswordHasher
     * @param EntityManagerInterface $entityManager
     * @param VerifyEmailHelperInterface $verifyEmailHelper
     * @return Response
     */
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, VerifyEmailHelperInterface $verifyEmailHelper): Response
    {
        $user = new UserNd();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();


            $signature = $verifyEmailHelper->generateSignature(
                'app_verify_email',
                $user->getId(),
                $user->getEmail(),
                ['id' => $user->getId()]

            );


//            TODO para enviar email
            $this->addFlash('success', 'Confirmar mail' . $signature->getSignedUrl());


            return $this->redirectToRoute('app_homepage');

//            return $this->redirectToRoute('app_inicio');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/verify", name="app_verify_email")
     * @param Request $request
     * @param VerifyEmailHelperInterface $verifyEmailHelper
     * @param UserNdRepository $userNdRepository
     * @return RedirectResponse
     */
    public function verifyUserMail(Request $request, VerifyEmailHelperInterface $verifyEmailHelper, UserNdRepository $userNdRepository, EntityManagerInterface $entityManager)
    {
        $user = $userNdRepository->find($request->query->get('id'));

        if (!$user) {
            throw $this->createNotFoundException();
        }

        try {
            $verifyEmailHelper->validateEmailConfirmation(
                $request->getUri(),
                $user->getId(),
                $user->getEmail()
            );
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('error', $exception->getReason());
            return $this->redirectToRoute('app_register');
        }

        $user->setIsVerified(true);
        $entityManager->flush();
        $this->addFlash('success', 'Cuenta Verificada');
        return $this->redirectToRoute('app_login');
    }


}
