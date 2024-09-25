<?php
/**
 * User Controller.
 */

namespace App\Controller;

use App\Form\Type\ChangeEmailType;
use App\Form\Type\ChangePasswordType;
use App\Service\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * User Controller.
 */
#[Route('/user')]
class UserController extends AbstractController
{
    /**
     * User service interface.
     *
     * @param UserServiceInterface $userService User service interface
     * @param TranslatorInterface  $translator  Translator interface
     */
    public function __construct(private readonly UserServiceInterface $userService, private readonly TranslatorInterface $translator)
    {
    }

    /**
     * Edit password action.
     *
     * @param Request $request Request instance
     * @param int     $id      User ID
     *
     * @return Response HTTP Response
     */
    #[Route('/{id}/edit-password', name: 'password_edit', requirements: ['id' => '\d+'], methods: ['GET', 'PUT'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function editPassword(Request $request, int $id): Response
    {
        $user = $this->userService->findUserById($id);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $form = $this->createForm(
            ChangePasswordType::class,
            $user,
            ['method' => 'PUT', 'action' => $this->generateUrl('password_edit', ['id' => $id])]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $currentPassword = $form->get('currentPassword')->getData();

            if (!$this->userService->passwordHasher->isPasswordValid($user, $currentPassword)) {
                $this->addFlash(
                    'error',
                    $this->translator->trans('message.current_password_invalid')
                );

                return $this->redirectToRoute('password_edit', ['id' => $id]);
            }

            $newPassword = $form->get('password')->getData();

            $this->userService->changePassword($user, $newPassword);

            $this->addFlash(
                'success',
                $this->translator->trans('message.edited_successfully')
            );

            return $this->redirectToRoute('element_index');
        }

        return $this->render('user/edit-password.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }

    /**
     * Edit email action.
     *
     * @param Request $request Request instance
     * @param int     $id      User ID
     *
     * @return Response HTTP Response
     */
    #[Route('/{id}/edit-email', name: 'email_edit', requirements: ['id' => '\d+'], methods: ['GET', 'PUT'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function editEmail(Request $request, int $id): Response
    {
        $user = $this->userService->findUserById($id);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $form = $this->createForm(
            ChangeEmailType::class,
            $user,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('email_edit', ['id' => $id]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->saveUser($user);

            $this->addFlash(
                'success',
                $this->translator->trans('message.email_edited_successfully')
            );

            return $this->redirectToRoute('element_index');
        }

        return $this->render('user/edit-email.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
}
