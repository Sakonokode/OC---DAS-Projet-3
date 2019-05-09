<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Seance;
use App\Entity\User;
use App\Exception\SubscriptionException;
use App\Service\SubscriptionService;
use Exception;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SubscriptionController
 * @package App\Controller
 */
class SubscriptionController extends AbstractController
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
            dump('test');
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
}