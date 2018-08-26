<div class="page-header">
	  <h1>Login</h1>
</div>

<form class="form" action="actions/login.php" method="post" enctype="multipart/form-data" data-ajax="false">
<div class="form-group">
	<label for="inputEmail">Utente</label>
	<input type="text" id="login" name="login" class="form-control" placeholder="Utente" required autofocus>
</div>
<div class="form-group">	
    <label for="password">Password</label>
    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
</div>
<div class="form-group">
    <button class="btn btn-primary btn-block" type="submit">Invia</button>
    <input type="hidden" id="acton" name="action" value="login">
</div>
</form>