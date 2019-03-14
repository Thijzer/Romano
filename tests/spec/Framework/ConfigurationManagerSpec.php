<?php

namespace spec\Romano\Framework;

use Romano\Framework\ConfigurationManager;
use PhpSpec\ObjectBehavior;
use Romano\Component\Common\ContainerInterface;

class ConfigurationManagerSpec extends ObjectBehavior
{
    public function let(ContainerInterface $container)
    {
        $this->beConstructedWith($container);
    }

    public function it_should_SetConfiguration(ContainerInterface $container)
    {
        $this->setConfiguration($parameters = ['test']);

        $container->addAll($parameters)->shouldBeCalled();
    }

    public function it_should_SetParameter(ContainerInterface $container)
    {
        $this->setParameter($key = 'key', $value = 'value');

        $container->add($key, $value)->shouldBeCalled();
    }

    public function it_should_GetParameter(ContainerInterface $container)
    {
        $this->getParameter($key = 'key');

        $container->get($key)->shouldBeCalled();
    }

    public function testGetAll(ContainerInterface $container)
    {
        $this->getAll();

        $container->getAll()->shouldBeCalled();
    }
}
