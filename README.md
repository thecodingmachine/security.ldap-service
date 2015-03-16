# security.ldap-service
This package contains a wrapper of Zendframework Ldap component who dialogue easily with Ldap.

This package allows using a LDAP server as a back-end for authentification for any application implementing [Mouf's userservice](http://mouf-php.com/packages/mouf/security.userservice/README.md)

The package installer will create 3 instances:

- `ldap`: instance of the Zend Ldap class with make the connection to the Ldap server. Use this instance if you need low level
  access to your Ldap server.
- `ldapUserDao`: instance implementing the `UserDaoInterface`, bind this instance to the `userService` in order to use your Ldap server as a back-end authentification
- `ldapPasswordService`: utility instance
