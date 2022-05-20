<?php

/**
 * This file is part of Boozt Platform
 * and belongs to Boozt Fashion AB.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;

class OrderContext implements Context
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Given orders exist
     *
     * @throws \Exception
     */
    public function ordersExist(): void
    {
        $connection = $this->entityManager->getConnection();

        $connection->executeStatement("DELETE FROM `order`");

        $file = file_get_contents(__DIR__ . '/fixtures/order.json');
        if (false === $file) {
            throw new \Exception('Failed to read file "/fixtures/order.json".');
        }

        $data = json_decode($file, true);
        if (!is_array($data)) {
            throw new \Exception('Json data from "/fixtures/order.json" is not correct format.');
        }

        foreach ($data as $item) {
            $connection->insert('`order`', $item);
        }
    }
}
