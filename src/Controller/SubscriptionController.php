<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Seance;
use App\Entity\Subscription;
use App\Entity\User;
use App\Exception\SubscriptionException;
use App\Service\SubscriptionService;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use EasyCorp\Bundle\EasyAdminBundle\Exception\EntityRemoveException;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

/**
 * Class SubscriptionController
 * @package App\Controller
 */
class SubscriptionController extends BaseAdminController
{
    /** @var SubscriptionService $subscriptionService */
    private $subscriptionService;

    /**
     * SubscriptionController constructor.
     * @param SubscriptionService $subscriptionService
     */
    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * @Route("/seance/{id}/subscribe", name="app_subscribe", methods={"GET"})
     * @param Seance $seance
     * @return Response
     * @throws SubscriptionException
     */
    public function subscribe(Seance $seance): Response
    {
        try {
            $this->subscriptionService->subscribe($this->getUser(), $seance);
        } catch (Exception $e) {
            throw new SubscriptionException('inscription failed', $e->getCode(), $e);
        }

        return new JsonResponse([
            'message' => 'inscription success'
        ], Response::HTTP_OK);
    }

    /**
     * @Route("/seance/{seance}/unsubscribe", name="app_unsubscribe", methods={"GET"})
     * @param Seance $seance
     * @return Response
     * @throws SubscriptionException
     */
    public function unsubscribe(Seance $seance): Response
    {
        try {
            $this->subscriptionService->unsubscribe($this->getUser(), $seance);
        } catch (Exception $e) {
            throw new SubscriptionException('inscription failed', $e->getCode(), $e);
        }

        return new JsonResponse([
            'message' => 'unsubscription success'
        ], Response::HTTP_OK);
    }

    /**
     * @param User $user
     *
     * @Route("/subscriptions/{id}", name="app_subscriptions")
     *
     * @return Response
     */
    public function list(User $user): Response
    {
        $repository = $this->getDoctrine()->getRepository(Subscription::class);
        $subscriptions = $repository->getMediaSubscriptions($user);

        #$subscriptions = $this->subscriptionService->getSubscriptions($user);

        return new Response($this->renderView('user/user-subscriptions.html.twig', [
            'subscriptions' => $subscriptions
        ]));
    }

    /**
     * The method that is executed when the user performs a 'delete' action to
     * remove any entity.
     *
     * @return RedirectResponse
     *
     * @throws EntityRemoveException
     * @throws Exception
     */
    protected function deleteAction(): RedirectResponse
    {
        $this->dispatch(EasyAdminEvents::PRE_DELETE);

        if ('DELETE' !== $this->request->getMethod()) {
            return $this->redirect($this->generateUrl('easyadmin', ['action' => 'list', 'entity' => $this->entity['name']]));
        }

        $id = $this->request->query->get('id');
        $form = $this->createDeleteForm($this->entity['name'], $id);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $easyadmin = $this->request->attributes->get('easyadmin');
            $entity = $easyadmin['item'];

            $this->dispatch(EasyAdminEvents::PRE_REMOVE, ['entity' => $entity]);

            /** @var Subscription $entity */
            $deleted = $entity->getDeleted() === null ? new DateTime('now') : null;

            $entity->setDeleted($deleted);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->dispatch(EasyAdminEvents::POST_REMOVE, ['entity' => $entity]);
        }

        $this->dispatch(EasyAdminEvents::POST_DELETE);

        return $this->redirectToReferrer();
    }
}