<?php /* @var $this \Mouf\Security\LdapService\Controllers\LdapUserInstallController */ ?>

<h1>Configure your Ldap server connection</h1>

<form action="install" class="form-horizontal">


<input type="hidden" id="selfedit" name="selfedit" value="<?php echo plainstring_to_htmlprotected($this->selfedit) ?>" />


<div class="control-group">
	<label for="host" class="control-label">Host:</label>
	<div class="controls">
		<input type="text" id="host" name="host" class="recomputeDbList" value="<?php echo plainstring_to_htmlprotected($this->host) ?>" />
		<span class="help-block">The IP address or URL of your ldap server. This is usually 'localhost'.</span>
	</div>
</div>

<div class="control-group">
	<label for="user" class="control-label">User:</label>
	<div class="controls">
		<input type="text" id="user" name="user" class="recomputeDbList" value="<?php echo plainstring_to_htmlprotected($this->user) ?>" />
		<span class="help-block">The user to connect to the ldap server.</span>
	</div>
</div>
<div class="control-group">
	<label for="password" class="control-label">Password:</label>
	<div class="controls">
		<input type="text" id="password" name="password" class="recomputeDbList" value="<?php echo plainstring_to_htmlprotected($this->password) ?>" />
	</div>
</div>

<div class="control-group">
	<label for="baseDn" class="control-label">Base Dn:</label>
	<div class="controls">
        <input type="text" id="baseDn" name="baseDn" class="recomputeDbList" value="<?php echo plainstring_to_htmlprotected($this->password) ?>" />
		<span class="help-block">The base Dn to connect to your ldap server. For example 'dc=thecodingmachine,dc=com'</span>
	</div>
</div>

<div class="control-group">
	<div class="controls">
		<button name="action" value="install" type="submit" class="btn btn-primary">Next</button>
	</div>
</div>
</form>
