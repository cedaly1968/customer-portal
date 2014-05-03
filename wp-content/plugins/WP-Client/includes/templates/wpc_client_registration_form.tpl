 <div class='registration_form'>

    <div id="message" class="updated" {if empty($error) } style="display: none;" {/if}>
        {if !empty($error)}
            {$error}
        {/if}
    </div>

    <form action="" method="post" id="form_content" >
         <table class="form-table">
            <tr>
                <td>
                    <label for="business_name">{$labels.business_name} <span class="description">{$required_text}</span>:</label> <br/>
                    <input type="text" id="business_name" name="business_name" value="{if $error }{$vals.business_name}{/if}" />
                </td>
            </tr>
            <tr>
                <td>
                    <label for="contact_name">{$labels.contact_name}:</label> <br/>
                    <input type="text" id="contact_name" name="contact_name" value="{if $error }{$vals.contact_name}{/if}" />
                </td>
            </tr>
            <tr>
                <td>
                    <label for="contact_email">{$labels.contact_email} <span class="description">{$required_text}</span>:</label> <br/>
                    <input type="text" id="contact_email" name="contact_email" value="{if $error }{$vals.contact_email}{/if}" />
                </td>
            </tr>
            <tr>
                <td>
                    <label for="contact_phone">{$labels.contact_phone}:</label> <br/>
                    <input type="text" id="contact_phone" name="contact_phone" value="{if $error }{$vals.contact_phone}{/if}" />
                </td>
            </tr>

            {if isset($custom_fields) && 0 < $custom_fields|@count }
                {foreach $custom_fields as $key => $value }

                    {if 'hidden' == $value.type}
                        {$value.field}
                    {elseif 'checkbox' == $value.type || 'radio' == $value.type }
                        <tr>
                            <td>
                            {if !empty($value.label) }
                                {$value.label}<br />
                            {/if}
                            {if !empty($value.field) }
                                {foreach $value.field as $field }
                                    {$field}<br />
                                {/foreach}
                            {/if}
                            {if !empty($value.description) }
                                {$value.description}
                            {/if}

                            </td>
                        </tr>
                    {else}
                        <tr>
                            <td>
                            {if !empty($value.label) }
                                {$value.label}<br />
                            {/if}
                            {if !empty($value.field) }
                                {$value.field}
                            {/if}
                            {if !empty($value.description) }
                                <br />{$value.description}
                            {/if}
                            </td>
                        </tr>
                    {/if}

                {/foreach}
            {/if}

            <tr>
                <td>
                    <hr />
                    <label for="contact_username">{$labels.contact_username} <span class="description">{$required_text}</span>:</label> <br/>
                    <input type="text" id="contact_username" name="contact_username" value="{if $error }{$vals.contact_username}{/if}" />
                </td>
            </tr>
            <tr>
                <td>
                    <label for="contact_password">{$labels.contact_password} <span class="description">{$required_text}</span>:</label> <br/>
                    <input type="password" id="contact_password" name="contact_password" value="" />
                </td>
            </tr>
            <tr>
                <td>
                    <label for="contact_password2">{$labels.contact_password2}:</label> <br/>
                    <input type="password" id="contact_password2" name="contact_password2" value="" />
                </td>
            </tr>
            <tr>
                <td>
                    <div id="pass-strength-result" style="display: block;">{$labels.password_indicator}</div>
            <hr />
                    <span class="description indicator-hint" style="clear:both">{$labels.password_hint}</span>
                </td>
            </tr>
            <tr>
                <td scope="row">
                <label for="send_password">>> {$labels.send_password} >> <input type="checkbox" {if $vals.send_password == 1 } checked {/if} name="user_data[send_password]" id="send_password" value="1" /> {$labels.send_password_desc}</label>
        <hr />
                </td>
            </tr>
            <tr>
                <td>
                    <input type='submit' name='btnAdd' id="btnAdd" class='button-primary' value='{$labels.send_button}' />
                </td>
            </tr>
        </table>
    </form>
</div>