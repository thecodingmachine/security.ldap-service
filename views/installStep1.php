<h1>Setting up your ldap server connection</h1>

<p>You will need a ldap server connection. This installation wizard will create a "LdapUserDao", "LdapPasswordService" and a "Ldap" instances for a ldap server connection,
    and will add 4 config parameters:</p>
<ul>
	<li><b>LDAP_HOST</b>: The ldap host (the IP address or URL of the LDAP server).</li>
	<li><b>LDAP_BASEDN</b>: The basedn of your ldap server.</li>
	<li><b>LDAP_USERNAME</b>: The username to access the ldap server.</li>
	<li><b>DLDAP_PASSWORD</b>: The password to access the ldap server.</li>
</ul>

<form action="configure">
	<button class="btn btn-danger">Configure ldap server connection</button>
</form>
<form action="skip">
	<button class="btn">Skip</button>
</form>
