<?php
/**
 * ChangeEmail Controller.
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\ChangeEmailType;
use App\Service\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * ChangeEmail Controller.
 */
#[Route('/user')]
class ChangeEmailController extends AbstractController
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
     * @param int $id
     * @return Response
     */
    #[Route('/{id}/edit-email', name: 'email_edit', requirements: ['id' => '\d+'], methods: ['GET', 'PUT'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, int $id): Response
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
            $currentEmail = $form->get('currentEmail')->getData();
            $newEmail = $form->get('email')->getData();

            if ($currentEmail === $user->getEmail()) {
                $user->setEmail($newEmail);
                $this->userService->saveUser($user);

                $this->addFlash(
                    'success',
                    $this->translator->trans('message.edited_successfully')
                );

                return $this->redirectToRoute('element_index');
            } else {
                $this->addFlash(
                    'error',
                    $this->translator->trans('message.invalid_current_email')
                );
            }
        }

        return $this->render('user/edit-email.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
}
