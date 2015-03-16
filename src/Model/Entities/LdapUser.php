<?php
namespace Mouf\Security\LdapService\Model\Entities;

use Mouf\Security\UserService\UserInterface;

class LdapUser implements UserInterface{

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
    public function getId(){
        return $this->ldapEntry['cn'][0];
    }

    /**
     * Returns the login for the current user.
     *
     * @return string
     */
    public function getLogin(){
        return $this->ldapEntry['uid'][0];
    }
}