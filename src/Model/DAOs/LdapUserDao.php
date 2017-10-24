<?php
namespace Mouf\Security\LdapService\Model\DAOs;

use Mouf\Security\LdapService\Model\Entities\LdapUser;
use Mouf\Security\UserService\UserDaoInterface;
use Mouf\Security\UserService\UserInterface;
use Zend\Ldap\Ldap;
use Zend\Ldap\Filter\AbstractFilter;

/**
 * Class LdapUserDao
 * @package Mouf\Security\LdapService\Dao
 */
class LdapUserDao implements UserDaoInterface
{

    /**
     *@var Ldap
     */
    private $ldap;
    
    /**
     * Information to login
     * This add LDAP_BASEDN at the end
     * For example ou=users for
     * ou=users,dc=xxxxx
     * 
     * @var string
     */
    private $schema;

    /**
     * @param Ldap                $ldap
     * @param string $schema Information to login  This add LDAP_BASEDN at the end For example ou=users for ou=users,dc=xxxxx
     */
    public function __construct(Ldap $ldap, $schema)
    {
        $this->ldap = $ldap;
        $this->schema = $schema;
    }

    /**
     * Returns a ldap entry from its login and its password, or null if the login or credentials are false.
     *
     * @param string $login
     * @param string $password
     * @return LdapUser|null
     * @throws \Zend\Ldap\Exception\LdapException
     */
    public function getUserByCredentials($login, $password)
    {
        try {
            $this->ldap->bind("(uid=".AbstractFilter::escapeValue($login)."),".($this->schema?$this->schema.',':'').LDAP_BASEDN, $password);
        } catch (\Zend\Ldap\Exception\LdapException $exception) {
            if ($exception->getCode() == 49) {
                return null;
            } else {
                throw $exception;
            }
        }
        $user = $this->getUserByLogin($login);
        return $user;
    }

    /**
     * Returns a user from its token.
     *
     * @param  string        $token
     * @return UserInterface
     */
    public function getUserByToken($token)
    {
        throw new \Exception('Not implemented yet');
    }

    /**
     * Discards a token.
     *
     * @param string $token
     */
    public function discardToken($token)
    {
        throw new \Exception('Not implemented yet');
    }

    /**
     * Returns a user from its ID
     *
     * @param  string        $id
     * @return UserInterface
     */
    public function getUserById($id)
    {
        $this->ldap->bind();
        $result = $this->ldap->search("(cn=".AbstractFilter::escapeValue($id).")", ($this->schema?$this->schema.',':'').LDAP_BASEDN);
        $user = $result->getFirst();
        if ($user) {
            return new LdapUser($user);
        } else {
            return;
        }
    }

    /**
     * Returns a ldap entry from its login
     *
     * @param  string                             $login
     * @return LdapUser|null
     * @throws \Exception
     * @throws \Zend\Ldap\Exception\LdapException
     */
    public function getUserByLogin($login)
    {
        $this->ldap->bind();
        $result = $this->ldap->search("(uid=".AbstractFilter::escapeValue($login).")", ($this->schema?$this->schema.',':'').LDAP_BASEDN);
	$user = $result->getFirst();
        if ($user) {
            return new LdapUser($user);
        } else {
            return null;
        }
    }
}
