<?php

/**
 * This file is part of Boozt Platform
 * and belongs to Boozt Fashion AB.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class OrderItem implements \JsonSerializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $ean;

    /**
     * @ORM\Column(type="integer")
     */
    private int $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Order", inversedBy="items")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_id", referencedColumnName="id", nullable=false)
     * })
     */
    private Order $order;

    public function __construct(string $ean, int $quantity, Order $order)
    {
        $this->ean = $ean;
        $this->quantity = $quantity;
        $this->order = $order;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEan(): string
    {
        return $this->ean;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id ?? 0,
            'ean' => $this->ean,
            'quantity' => $this->quantity
        ];
    }
}
