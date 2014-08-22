<?php

namespace DZunke\SlackBundle\Slack\Client;

class IdentityBag
{

    /**
     * @var Identity[]
     */
    protected $identities = [];

    /**
     * @param array $identity
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function createIdentities(array $identity)
    {
        if (empty($identity)) {
            throw new \InvalidArgumentException('the parameter "$identity" must not be empty');
        }

        foreach ($identity as $username => $config) {
            $identObj = new Identity();
            $identObj->setUsername($username);
            $identObj->setIconEmoji((isset($identity['icon-emoji']) ? $identity['icon-emoji'] : null));
            $identObj->setIconEmoji((isset($identity['icon-url']) ? $identity['icon-url'] : null));

            $this->add($identObj);
        }

        return $this;
    }

    /**
     * @param string $username
     * @return bool
     */
    public function has($username)
    {
        if (array_key_exists($username, $this->identities)) {
            return true;
        }

        return false;
    }

    /**
     * @param Identity $identity
     * @return $this
     */
    public function add(Identity $identity)
    {
        $this->identities[$identity->getUsername()] = $identity;

        return $this;
    }

    /**
     * @param string $username
     * @return Identity
     * @throws \Exception
     */
    public function get($username)
    {
        if (!isset($this->identities[$username])) {
            throw new \Exception('identity "' . $username . '" does not exists');
        }

        return $this->identities[$username];
    }

}