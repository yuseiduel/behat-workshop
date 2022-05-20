<?php

/**
 * This file is part of Boozt Platform
 * and belongs to Boozt Fashion AB.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace App\Controller;

use App\Entity;
use App\Model;
use App\Repository\OrderRepository;
use App\Service;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/orders")
 */
class Order extends AbstractController
{
    /** @var ValidatorInterface */
    private $validator;
    /** @var Service\Order */
    private $orderService;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @Route(name="orders.get_list", methods={"GET"})
     *
     * @param OrderRepository $repository
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getList(Request $request, OrderRepository $repository): JsonResponse
    {
        $limit = $request->query->get('limit', 5);
        $page = $request->query->get('page', 1);
        $offset = ($page - 1) * $limit;

        $list = $repository->findBy([], ['id' => 'DESC'], $limit, $offset);
        $total = $repository->count([]);

        return new JsonResponse(['results' => $list, 'total' => $total]);
    }

    public function getItem(Entity\Order $order): JsonResponse
    {
        return new JsonResponse([
            'id' => $order->getId() ?? 0,
            'email' => $order->getEmail(),
            'items' => $order->getItems()
        ]);
    }

    /**
     * @Route(name="orders.create", methods={"POST"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $model = new Model\Order(json_decode($request->getContent(), true));

        $errors = $this->validator->validate($model);
        if ($errors->count() > 0) {
            return new JsonResponse(['success' => false, 'errors' => $errors], Response::HTTP_BAD_REQUEST);
        }

        $id = $this->orderService->createFromModel($model);

        return new JsonResponse(['success' => true, 'id' => $id]);
    }

    /**
     * @Route(name="orders.update", methods={"PATCH"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $model = new Model\Order(json_decode($request->getContent(), true));

        $errors = $this->validator->validate($model);
        if ($errors->count() > 0) {
            return new JsonResponse(['success' => false, 'errors' => $errors], Response::HTTP_BAD_REQUEST);
        }

        $this->orderService->updateFromModel($model);

        return new JsonResponse(['success' => true]);
    }
}
