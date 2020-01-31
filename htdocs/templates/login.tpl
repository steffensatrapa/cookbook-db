{include file="_header.tpl" title="{if $lang=="de"}Anmelden{else}Login{/if} - "}

<h1>{if $lang=="de"}Anmelden{else}Login{/if}</h1>

<form method="POST">
    <input type="hidden" name="action" value="login">

    <div class="form-group">
        <label for="userName">{if $lang=="de"}Benutzername{else}Username{/if}:</label>
        <input type="text" class="form-control" id="userName" name="userName">
    </div>
    <div class="form-group">
        <label for="password">{if $lang=="de"}Passwort{else}Password{/if}:</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>

    <button type="submit" class="btn btn-primary">{if $lang=="de"}Anmelden{else}Login{/if}</button>
</form>



{include file="_footer.tpl"}