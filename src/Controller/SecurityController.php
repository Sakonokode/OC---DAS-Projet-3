<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Security;

/**
 * Class SecurityController
 * @package App\Controller
 */
class SecurityController extends AbstractController
{
    /**
     * @param Security $security
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     * @Route("/login", name="login")
     */
    public function login(
        Security $security,
        AuthenticationUtils $authenticationUtils
    ): Response {

        // if user is already logged in, don't display the login page again
        if ($security->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('home');
        }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('security/login.html.twig', [
            'error'         => $error,
            'last_username' => $authenticationUtils->getLastUsername()
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(): void {

    }
}