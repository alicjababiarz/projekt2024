<?php
/**
 * Element controller.
 */

namespace App\Controller;

use App\Entity\Element;
use App\Form\Type\ElementType;
use App\Service\ElementServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class ElementController.
 */
#[Route('/element')]
class ElementController extends AbstractController
{
    /**
     * Constructor.
     *
     * @param ElementServiceInterface $elementService Element service
     * @param TranslatorInterface $translator Translator
     */
    public function __construct(private readonly ElementServiceInterface $elementService, private readonly TranslatorInterface $translator)
    {
    }

    /**
     * Index action.
     *
     * @param int $page Page number
     *
     * @return Response HTTP response
     */
    #[Route(name: 'element_index', methods: 'GET')]
    public function index(#[MapQueryParameter] int $page = 1): Response
    {
        $pagination = $this->elementService->getPaginatedList($page);

        return $this->render('element/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * Show action.
     *
     * @param Element $element Element
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'element_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET'
    )]
    public function show(Element $element): Response
    {
        return $this->render('element/show.html.twig', ['element' => $element]);
    }

    /**
     * Create action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     */
    #[Route(
        '/create',
        name: 'element_create',
        methods: 'GET|POST',
    )]
    public function create(Request $request): Response
    {
        $element = new Element();
        $element->setCreatedAt(
            new \DateTimeImmutable //usunac jak bede robic slugi
        );
        $element->setUpdatedAt(
            new \DateTimeImmutable
        );
        $form = $this->createForm(ElementType::class, $element);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->elementService->save($element);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('element_index');
        }

        return $this->render(
            'element/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param Request  $request  HTTP request
     * @param Element $element Element entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/edit', name: 'element_edit', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT')]
    public function edit(Request $request, Element $element): Response
    {
        $form = $this->createForm(
            ElementType::class,
            $element,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('element_edit', ['id' => $element->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->elementService->save($element);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('element_index');
        }

        return $this->render(
            'element/edit.html.twig',
            [
                'form' => $form->createView(),
                'element' => $element,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request  $request  HTTP request
     * @param Element $element Category entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/delete', name: 'element_delete', requirements: ['id' => '[1-9]\d*'], methods: 'GET|DELETE')]
    public function delete(Request $request, Element $element): Response
    {
        $form = $this->createForm(ElementType::class, $element, [
            'method' => 'DELETE',
            'action' => $this->generateUrl('element_delete', ['id' => $element->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->elementService->delete($element);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('element_index');
        }

        return $this->render(
            'element/delete.html.twig',
            [
                'form' => $form->createView(),
                'element' => $element,
            ]
        );
    }
}
