<?php

/**
 *  This file is property of
 *
 *  (c) Thijs De Paepe <thijs.dp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Romano\Framework\Utils;

use PHPUnit\Framework\TestCase;
use Romano\Component\Common\Matroska;

class MatroskaTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_unflatten_an_array()
    {
        $data = [
            'customer' => [
                'name' => 'mark',
                'address' => [
                    'street' => 'Wall-street',
                    'city' => 'New York',
                ],
            ],
            'b' => 'alpha',
            'c' => 'omega',
        ];
        $expected = [
            'customer.name' => 'mark',
            'customer.address.street' => 'Wall-street',
            'customer.address.city' => 'New York',
            'b' => 'alpha',
            'c' => 'omega',
        ];

        $result = new Matroska($expected);

        $this->assertSame($result->getAll(), $data);
    }

    /**
     * @test
     */
    public function it_should_get_the_correct_value()
    {
        $expected = [
            'customer.name' => 'mark',
            'customer.address.street' => 'Wall-street',
            'customer.address.city' => 'New York',
            'b' => 'alpha',
            'c' => 'omega',
        ];

        $result = new Matroska($expected);

        $customer = [
            'name' => 'mark',
            'address' => [
                'street' => 'Wall-street',
                'city' => 'New York',
            ]
        ];

        $this->assertSame($result->get('customer', 'name'), 'mark');
        $this->assertSame($result->get('customer.name'), 'mark');
        $this->assertSame($result->get('customer'), $customer);

        $this->assertNull($result->get('customer.names'));

        $result->add('customer.name', 'john');
        $this->assertSame($result->get('customer.name'), 'john');
    }

    /**
     * @test
     */
    public function it_should_remove_a_value()
    {
        $expected = [
            'customer.name' => 'mark',
            'customer.address.street' => 'Wall-street',
            'customer.address.city' => 'New York',
            'b' => 'alpha',
            'c' => 'omega',
        ];

        $result = new Matroska($expected);

        $result->remove('customer.name');

        $this->assertNull($result->get('customer.name'));

        $this->assertSame([
            'name' => null,
            'address' => [
                'street' => 'Wall-street',
                'city' => 'New York',
            ]
        ], $result->get('customer'));

        $result->remove('customer');

        $this->assertSame([
            'customer' => null,
            'b' => 'alpha',
            'c' => 'omega',
        ], $result->getAll());
    }

    /**
     * @test
     */
    public function it_should_check_values()
    {
        $expected = [
            'customer.name' => 'mark',
            'customer.address.street' => 'Wall-street',
            'customer.address.city' => 'New York',
            'b' => 'alpha',
            'c' => 'omega',
        ];

        $result = new Matroska($expected);

        $this->assertTrue($result->has('customer.name'));

        $this->assertTrue($result->has('customer'));

        $this->assertTrue($result->has('customer.address.city'));

        $this->assertFalse($result->has('customer.address.city.number'));
    }

    /**
     * @test
     */
    public function it_should_start_from_a_multidimensional_array()
    {
        $data = [
            'customer' => [
                'name' => 'mark',
                'address' => [
                    'street' => 'Wall-street',
                    'city' => 'New York',
                ],
            ]
        ];

        $result = new Matroska($data);

        $result->addAll([
            'a' => ['b' => 'alpha'],
            'c' => 'omega',
        ]);

        $result->add('customer.name', 'john');

        $data = [
            'customer' => [
                'name' => 'john',
                'address' => [
                    'street' => 'Wall-street',
                    'city' => 'New York',
                ],
            ],
            'a' => ['b' => 'alpha'],
            'c' => 'omega',
        ];

        $this->assertSame($result->getAll(), $data);
    }
}