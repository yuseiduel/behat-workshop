<?php

/**
 * This file is part of Boozt Platform
 * and belongs to Boozt Fashion AB.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Order
{
    /**
     * @var int|null
     */
    public readonly ?int $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     *
     * @var string|null
     */
    public readonly ?string $email;

    /**
     * @Assert\NotBlank()
     * @Assert\Valid()
     *
     * @var array<int, OrderItem>
     */
    public readonly array $items;

    public function __construct(array $data)
    {
        $items = [];
        if (isset($data['items']) && is_array($data['items'])) {
            foreach ($data['items'] as $key => $itemData) {
                if (is_array($itemData)) {
                    $items[$key] = new OrderItem($itemData);
                }
            }
        }

        $this->id = isset($data['id']) && is_numeric($data['id']) ? (int) $data['id'] : null;
        $this->email = isset($data['email']) && is_string($data['email']) ? $data['email'] : null;
        $this->items = $items;
    }
}
