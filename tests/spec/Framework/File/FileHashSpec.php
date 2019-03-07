<?php

namespace spec\Romano\Framework\File;

use Romano\Framework\File\FileHash;
use PhpSpec\ObjectBehavior;

class FileHashSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedThrough('generate', [
            $content = 'content'
        ]);
    }

    public function it_should_generate_a_hash()
    {
        $this->beConstructedThrough('generate', [
            $content = 'content'
        ]);

        $this->getHash()->shouldBe($this->getHash());
    }

    public function it_should_compare_tooString()
    {
        $this->is($this->getHash())->shouldBe(true);
    }

    public function it_should_compare_as_equal()
    {
        $this->equal(FileHash::generate('content'))->shouldBe(true);
    }

    public function it_should_compare_as_is()
    {
        $this->is($this->getHash())->shouldBe(true);
    }

    public function it_should_IsGeneratedFrom()
    {
        $this->isGeneratedFrom('content')->shouldBe(true);
    }
}
