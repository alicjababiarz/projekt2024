<?php
/**
 * User Controller.
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\ChangePasswordType;
use App\Form\Type\EmailType;
use App\Service\UserServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * ChangePassword Controller.
 */
#[Route('/user')]
class UserController extends AbstractController
{
    /**
     * @param UserServiceInterface $userService
     * @param TranslatorInterface $translator
     */
    public function __construct(private readonly UserServiceInterface $userService, private readonly TranslatorInterface $translator)
    {
    }

    /**
     * @param Request $request
     * @param UserPasswordHasherInterface $passwordHasher
     * @param int $id
     * @return Response
     */
    #[Route('/{id}/edit-password', name: 'password_edit', requirements: ['id' => '\d+'], methods: ['GET', 'PUT'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit_password(Request $request, UserPasswordHasherInterface $passwordHasher, int $id): Response
    {
        $user = $this->userService->findUserById($id);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $form = $this->createForm(
            ChangePasswordType::class,
            $user,
            [
            'method' => 'PUT',
            'action' => $this->generateUrl('password_edit', ['id' => $id])
        ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $currentPassword = $form->get('currentPassword')->getData();

            if (!$passwordHasher->isPasswordValid($user, $currentPassword)) {
                $this->addFlash(
                    'error',
                    $this->translator->trans('message.current_password_invalid')
                );

                return $this->redirectToRoute('password_edit', ['id' => $id]);
            }

            $newPassword = $form->get('password')->getData();
            $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);

            $user->setPassword($hashedPassword);
            $this->userService->saveUser($user);

            $this->addFlash(
                'success',
                $this->translator->trans('message.edited_successfully')
            );

            return $this->redirectToRoute('element_index');
        }

        return $this->render('user/edit-password.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

}
