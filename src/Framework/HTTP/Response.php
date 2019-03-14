<?php

namespace Romano\Framework\HTTP;

class Response
{
    /**
     * @var string
     */
    private $path;
    /**
     * @var array
     */
    private $data;

    public function __construct(string $path, array $data = [])
    {
        $this->path = $path;
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getArrayData(): array
    {
        return [
            'path' => $this->path,
            'data' => $this->data,
        ];
    }
}