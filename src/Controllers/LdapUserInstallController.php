<?php
namespace Mouf\Security\LdapService\Controllers;

use Mouf\Actions\InstallUtils;
use Mouf\Html\HtmlElement\HtmlBlock;
use Mouf\Html\Template\TemplateInterface;
use Mouf\MoufManager;
use Mouf\Mvc\Splash\Controllers\Controller;

/**
 * The controller managing the install process.
 */
class LdapUserInstallController extends Controller
{
    public $selfedit;

    /**
     * The active MoufManager to be edited/viewed
     *
     * @var MoufManager
     */
    public $moufManager;

    /**
     * The template used by the main page for mouf.
     * @var TemplateInterface
     */
    public $template;

    /**
     * The content block the template will be writting into.
     * @var HtmlBlock
     */
    public $contentBlock;

    /**
     * Displays the first install screen.
     *
     * @Action
     * @Logged
     * @param string $selfedit If true, the name of the component must be a component from the Mouf framework itself (internal use only)
     */
    public function defaultAction($selfedit = "false")
    {
        $this->selfedit = $selfedit;

        if ($selfedit == "true") {
            $this->moufManager = MoufManager::getMoufManager();
        } else {
            $this->moufManager = MoufManager::getMoufManagerHiddenInstance();
        }

        $this->contentBlock->addFile(dirname(__FILE__)."/../../views/installStep1.php", $this);
        $this->template->toHtml();
    }

    /**
     * Skips the install process.
     *
     * @Action
     * @Logged
     * @param string $selfedit If true, the name of the component must be a component from the Mouf framework itself (internal use only)
     */
    public function skip($selfedit = "false")
    {
        InstallUtils::continueInstall($selfedit == "true");
    }

    protected $host;
    protected $baseDn;
    protected $user;
    protected $password;

    /**
     * Displays the second install screen.
     *
     * @Action
     * @Logged
     * @param string $selfedit If true, the name of the component must be a component from the Mouf framework itself (internal use only)
     */
    public function configure($selfedit = "false")
    {
        $this->selfedit = $selfedit;

        if ($selfedit == "true") {
            $this->moufManager = MoufManager::getMoufManager();
        } else {
            $this->moufManager = MoufManager::getMoufManagerHiddenInstance();
        }

        $this->host = "";
        $this->baseDn = "";
        $this->user = "";
        $this->password = "";

        $this->contentBlock->addFile(dirname(__FILE__)."/../../views/installStep2.php", $this);
        $this->template->toHtml();
    }

    /**
     * Action to create the database connection.
     *
     * @Action
     * @Logged
     * @param string $selfedit If true, the name of the component must be a component from the Mouf framework itself (internal use only)
     */
    public function install($host,  $baseDn, $user, $password, $selfedit = "false")
    {
        if ($selfedit == "true") {
            $this->moufManager = MoufManager::getMoufManager();
        } else {
            $this->moufManager = MoufManager::getMoufManagerHiddenInstance();
        }

        $moufManager = $this->moufManager;
        $configManager = $moufManager->getConfigManager();

        $constants = $configManager->getMergedConstants();

        if (!isset($constants['LDAP_HOST'])) {
            $configManager->registerConstant("LDAP_HOST", "string", "localhost", "The Ldap host (the IP address or URL of the ldap server).");
        }

        if (!isset($constants['LDAP_USERNAME'])) {
            $configManager->registerConstant("LDAP_USERNAME", "string", "", "The username to access the ldap server.");
        }

        if (!isset($constants['LDAP_PASSWORD'])) {
            $configManager->registerConstant("LDAP_PASSWORD", "string", "", "The password to access the ldap server.");
        }

        if (!isset($constants['LDAP_BASEDN'])) {
            $configManager->registerConstant("LDAP_BASEDN", "string", "", "The base Dn of your ldap server. For example 'dc=thecodingmachine,dc=com'");
        }

        // Let's create the instances.
        $ldap = InstallUtils::getOrCreateInstance('ldap', null, $moufManager);
        $ldap->setCode('$ldap = new \\Zend\\Ldap\\Ldap(array(
                \'host\'     => LDAP_HOST,
                \'username\' => LDAP_USERNAME,
                \'password\' => LDAP_PASSWORD,
                \'baseDn\'   => LDAP_BASEDN
            ));
        return $ldap;');
        $ldapUserDao = InstallUtils::getOrCreateInstance('ldapUserDao', 'Mouf\\Security\\LdapService\\Model\\DAOs\\LdapUserDao', $moufManager);

        // Let's bind instances together.
        if (!$ldapUserDao->getConstructorArgumentProperty('ldap')->isValueSet()) {
            $ldapUserDao->getConstructorArgumentProperty('ldap')->setValue($ldap);
        }

        $configPhpConstants = $configManager->getDefinedConstants();
        $configPhpConstants['LDAP_HOST'] = $host;
        $configPhpConstants['LDAP_USERNAME'] = $user;
        $configPhpConstants['LDAP_PASSWORD'] = $password;
        $configPhpConstants['LDAP_BASEDN'] = $baseDn;
        $configManager->setDefinedConstants($configPhpConstants);

        $moufManager->rewriteMouf();

        InstallUtils::continueInstall($selfedit == "true");
    }
}
