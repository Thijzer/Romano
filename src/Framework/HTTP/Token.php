<?php

namespace Romano\Framework\HTTP;

class Token
{
    /**
     * @var string
     */
    private $tokenName;

    public function __construct(string $tokenName)
    {
        $this->tokenName = $tokenName;
    }

    public function generate(): void
	{
		return Session::set($this->token, md5(uniqid()));
	}

	public function check(string $token): bool
	{
		if (Session::get($this->tokenName) && $token === Session::get($this->tokenName)) {
			Session::delete($this->tokenName);

			return true;
		}

		return false;
	}
}
