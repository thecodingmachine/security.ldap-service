<?php
namespace Mouf\Security\LdapService\Model\Entities;

use Mouf\Security\UserService\UserInterface;
use Mouf\Security\LdapService\LdapServiceException;

class LdapUser implements UserInterface
{

    /**
     * @var array
     */
    private $ldapEntry;

    /**
     * @param array $ldapEntry
     */
    public function __construct(array $ldapEntry)
    {
        $this->ldapEntry = $ldapEntry;
    }

    /**
     * Returns the ID for the current user.
     *
     * @return string
     */
    public function getId()
    {
        return $this->ldapEntry['cn'][0];
    }

    /**
     * Returns the login for the current user.
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->ldapEntry['uid'][0];
    }

    /**
     * Get properties by name
     * Warning returns an array of properties
     *
     * @param  string $property
     * @return array
     */
    public function get($property)
    {
        if (isset($this->ldapEntry[$property])) {
            return $this->ldapEntry[$property];
        }

        return [];
    }

    /**
     * Get property
     *
     * @param  unknown    $property
     * @return multitype:
     */
    /**
     * Return the value if it is unique
     * If there are many result, this send an exception
     *
     * @param  strin                $property
     * @throws LdapServiceException
     * @return string
     */
    public function getUnique($property)
    {
        if (isset($this->ldapEntry[$property])) {
            if ($count = count($this->ldapEntry[$property]) == 1) {
                return $this->ldapEntry[$property][0];
            } else {
                throw new LdapServiceException('The property '.$property.' has '.$count.' values and not an unique.');
            }
        }

        return [];
    }
}
