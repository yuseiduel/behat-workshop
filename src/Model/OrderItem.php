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

class OrderItem
{
    /**
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^[0-9]+$/", message="Ean can only have numbers")
     * @Assert\Length(
     *     min=12,
     *     max=14,
     *     minMessage="Ean should not be shorter that 12 characters",
     *     maxMessage="Ean should not be longer that 14 characters"
     * )
     *
     * @var string|null
     */
    public readonly ?string $ean;

    /**
     * @Assert\NotBlank()
     * @Assert\Range(min="1")
     *
     * @var int|null
     */
    public readonly ?int $quantity;

    public function __construct(array $data)
    {
        $this->ean = isset($data['ean']) && is_string($data['ean']) ? $data['ean'] : null;
        $this->quantity = isset($data['quantity']) && is_numeric($data['quantity']) ? (int) $data['quantity'] : null;
    }
}
