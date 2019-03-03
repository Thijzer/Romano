<?php

namespace Romano\Framework;

class ConfigurationManager
{
    private $configuration;

    public function __construct(ContainerInterface $configuration)
    {
        $this->configuration = $configuration;
    }

    public function setConfiguration(array $parameters): void
    {
        $this->configuration->addAll($parameters);
    }

    public function getParameter(string $key)
    {
        return $this->configuration->get($key);
    }

    public function setParameter(string $key, $value): void
    {
        $this->configuration->add($key, $value);
    }

    public function getAll(): array
    {
        return $this->configuration->getAll();
    }
}
