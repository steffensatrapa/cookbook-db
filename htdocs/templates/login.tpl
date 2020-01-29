{include file="_header.tpl" title="Anmelden - Satrapas Kochbuch"}

<h1>Anmelden</h1>

<form method="POST">
    <input type="hidden" name="action" value="login">

    <div class="form-group">
        <label for="userName">Benutzername:</label>
        <input type="text" class="form-control" id="userName" name="userName" placeholder="Benutzername">
    </div>
    <div class="form-group">
        <label for="password">Passwort:</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Passwort">
    </div>

    <button type="submit" class="btn btn-primary">Anmelden</button>
</form>



{include file="_footer.tpl"}