<?php
use Mouf\MoufManager;

// Controller declaration
MoufManager::getMoufManager()->declareComponent('ldapuserinstall', 'Mouf\\Security\\LdapService\\Controllers\\LdapUserInstallController', true);
MoufManager::getMoufManager()->bindComponents('ldapuserinstall', 'template', 'moufInstallTemplate');
MoufManager::getMoufManager()->bindComponents('ldapuserinstall', 'contentBlock', 'block.content');
?>