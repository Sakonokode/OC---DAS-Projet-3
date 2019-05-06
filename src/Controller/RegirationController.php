<?php


namespace App\Controller;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\FormError;

class RegirationController extends AbstractController
{
    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return mixed
     * @Route("/register", name="user_registration")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var User $user */
            $user = $form->getData();
            $exist = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $user->getEmail()]);

            if ($exist === null) {

                $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);

                // 4)set the User's roles
                $user->setRoles(['ROLE_USER']);

                // 5) save the User!
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash(
                    'notice',
                    'Thanks you for registering, you can now login'
                );

                return $this->redirectToRoute('login');
            }

            $form->get('email')->addError(new FormError('Email already used'));
        }

        $errors = $form->getErrors(true);

        return $this->render(
            'registration/register.html.twig', [
                'form' => $form->createView(),
                'errors' => $errors
            ]
        );
    }
}