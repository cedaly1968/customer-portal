<form method="post" action="{if !empty($login_url)}{$login_url}{/if}" id="loginform" name="loginform">
    {if !empty($somefields)}{$somefields}{/if}

    {if !empty($error_msg)}
        <div id="login_error">{$error_msg}</div>
    {/if}

    <p>
        <label for="user_login">{if !empty($labels.username)}{$labels.username}{/if}<br>
        <input type="text" tabindex="10" size="20" value="" class="input" id="user_login" name="log"></label>
    </p>
    <p>
        <label for="user_pass">{if !empty($labels.password)}{$labels.password}{/if}<br>
        <input type="password" tabindex="20" size="20" value="" class="input" id="user_pass" name="pwd"></label>
    </p>
    <p class="forgetmenot"><label for="rememberme"><input type="checkbox" tabindex="90" value="forever" id="rememberme" name="rememberme"> {if !empty($labels.remember)}{$labels.remember}{/if}</label></p>
    <p class="submit">
        <input type="submit" tabindex="100" value="Log In" class="button-primary" id="wp-submit" name="wp-submit">
        <input type="hidden" value="" name="redirect_to">
    </p>
</form>