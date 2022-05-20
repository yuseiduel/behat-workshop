<?php

/**
 * This file is part of Boozt Platform
 * and belongs to Boozt Fashion AB.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace App\Service;

use App\Entity;
use App\Model;
use App\Repository\OrderRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Order
{
    private OrderRepository$repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createFromModel(Model\Order $model): int
    {
        $entity = new Entity\Order(
            $model->email
        );

        foreach ($model->items as $itemModel) {
            $itemEntity = new Entity\OrderItem(
                $itemModel->ean,
                $itemModel->quantity,
                $entity
            );

            $entity->getItems()->add($itemEntity);
        }

        $this->repository->save($entity);

        return $entity->getId();
    }

    public function updateFromModel(Model\Order $model): void
    {
        $entity = $this->repository->find($model->id);
        if (!$entity instanceof Entity\Order) {
            throw new NotFoundHttpException(sprintf('Order not found by id "%s".', $model->id));
        }
        $entity->setEmail($model->email);

        foreach ($model->items as $itemModel) {
            $itemEntity = new Entity\OrderItem(
                $itemModel->ean,
                $itemModel->quantity,
                $entity
            );

            $entity->getItems()->add($itemEntity);
        }

        $this->repository->save($entity);
    }
}
