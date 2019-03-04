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
use Romano\Framework\Application;
use Romano\Framework\Matroska;

class ApplicationTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_build_the_path_array()
    {
        $data = [
            'app_name' => 'blog',
        ];

        $result = new Application(dirname(__DIR__), $data);

        $result->buildProject();

        $expected = [
            'root' => '/home/thijzer/Sync/Projects/Romano/tests/',
            'app' => 'app/blog/',
            'src'=> 'src/',
            'app_config' => 'app/blog/config/',
            'lang' => 'app/blog/config/Language/',
            'url' => 'app/blog/config/Url/',
            'resource' => 'src/Resources/',
            'cache' => 'src/Cache/',
            'controller' => 'src/Controllers/',
            'model' => 'src/Models/',
        ];

        $this->assertSame($expected, $result->getConfig()->getParameter('path'));
    }
}