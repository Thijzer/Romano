<?php

namespace spec\Romano\Framework;

use PhpSpec\ObjectBehavior;

class ClassNameReferenceSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(new TestObject);
    }

    public function it_should_return_tooString(): void
    {
        $this->__toString()->shouldReturn(TestObject::class);
    }

    public function it_should_return_GetShortName(): void
    {
        $this->getShortName()->shouldReturn('TestObject');
    }

    public function it_should_compare_to_string()
    {
        $this->is(TestObject::class)->shouldBe(true);
    }

    public function it_should_compare_to_className(): void
    {
        $this->getClassName()->shouldBe(TestObject::class);
    }

    public function it_should_compare_to_equals(): void
    {
        $this->equals(new TestObject())->shouldBe(true);
    }
}


class TestObject{}