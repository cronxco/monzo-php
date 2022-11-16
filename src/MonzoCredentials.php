<?php

namespace Amelia\Monzo;

use Laravel\Socialite\Two\User;

trait MonzoCredentials
{
    /**
     * Set a user's credentials from a user object returned via Socialite.
     *
     * @param \Laravel\Socialite\Two\User $user
     * @return $this
     */
    public function setMonzoUser(User $user)
    {
        $this->setAttribute($this->getMonzoAccessTokenColumn(), $user->token);
        $this->setAttribute($this->getMonzoRefreshTokenColumn(), $user->refreshToken);
        $this->setAttribute($this->getMonzoUserIdColumn(), $user->id);

        return $this;
    }

    /**
     * Update this object to set new credentials.
     *
     * @param string $token
     * @param string $refreshToken
     * @return void
     */
    public function updateMonzoCredentials(string $token, string $refreshToken, string $expires)
    {
        $this->setAttribute($this->getMonzoAccessTokenColumn(), $token);
        $this->setAttribute($this->getMonzoRefreshTokenColumn(), $refreshToken);
        $this->setAttribute($this->getMonzoExpiresColumn(), $expires);

        $this->save();
    }

    /**
     * Get a monzo user's access token.
     *
     * @return string|null
     */
    public function getMonzoAccessToken()
    {
        return $this->getAttribute($this->getMonzoAccessTokenColumn());
    }

    /**
     * Get a monzo user's refresh token.
     *
     * @return string|null
     */
    public function getMonzoRefreshToken()
    {
        return $this->getAttribute($this->getMonzoRefreshTokenColumn());
    }

    /**
     * Get a monzo user's access token expiry.
     *
     * @return string|null
     */
    public function getMonzoTokenExpiry()
    {
        return $this->getAttribute($this->getMonzoExpiresColumn());
    }

    /**
     * Get a monzo user's refresh token.
     *
     * @return string|null
     */
    public function getMonzoUserId()
    {
        return $this->getAttribute($this->getMonzoUserIdColumn());
    }

    /**
     * Get a user's monzo email.
     *
     * @return string
     */
    public function getMonzoEmail()
    {
        return $this->getAttribute($this->getMonzoEmailColumn());
    }

    /**
     * Get the attribute name for a monzo user's access token.
     *
     * @return string
     */
    protected function getMonzoAccessTokenColumn()
    {
        return 'monzo_access_token';
    }

    /**
     * Get the attribute name for a monzo user's refresh token.
     *
     * @return string
     */
    protected function getMonzoRefreshTokenColumn()
    {
        return 'monzo_refresh_token';
    }

    /**
     * Get the attribute name for a monzo user's refresh token.
     *
     * @return string
     */
    protected function getMonzoExpiresColumn()
    {
        return 'monzo_token_expires';
    }

    /**
     * Get the attribute name for a monzo user's id.
     *
     * @return string
     */
    protected function getMonzoUserIdColumn()
    {
        return 'monzo_user_id';
    }

    /**
     * Get the attribute name for a monzo user's email.
     *
     * @return string
     */
    protected function getMonzoEmailColumn()
    {
        return 'email';
    }
}
