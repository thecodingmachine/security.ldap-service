<?php

namespace Mouf\Security\LdapService\Services;


/**
 * Class LdapPasswordService
 * @package Mouf\Security\LdapService\Services
 */
class LdapPasswordService
{
    /**
     * @param string $password
     * @return string
     */
    public function convertToLdapSha1($password){
        return '{SHA}' . base64_encode(sha1( $password, TRUE ));
    }

}