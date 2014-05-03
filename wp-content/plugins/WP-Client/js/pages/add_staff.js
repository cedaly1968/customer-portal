
jQuery( document ).ready( function() {

//   jQuery( "#message" ).hide();

    jQuery( "#update_user" ).live ( 'click', function() {

        var msg = '';

        var emailReg = /^([\w-+\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

        if ( jQuery( "#user_login" ).val() == '' ) {
            msg += "A username is required.<br/>";
        }

        if ( jQuery( "#email" ).val() == '' ) {
            msg += "Email required.<br/>";
        } else if ( !emailReg.test( jQuery( "#email" ).val() ) ) {
            msg += "Invalid Email.<br/>";
        }


        if ( jQuery( '#update_password' ).length == 0 || jQuery( "#update_password" ).is(':checked') ) {
            if ( jQuery( "#pass1" ).val() == '' ) {
                msg += "Password required.<br/>";
            } else if ( jQuery( "#pass2" ).val() == '' ) {
                msg += "Confirm Password required.<br/>";
            } else if ( jQuery( "#pass1" ).val() != jQuery( "#pass2" ).val() ) {
                msg += "Passwords are not matched.<br/>";
            }
        }


        if ( msg != '' ) {
            jQuery( "#message" ).html( msg );
            jQuery( "#message" ).show();
            return false;
        }
    });
});


/* <![CDATA[ */

pwsL10n={
    empty: "Strength Indicator",
    short: "Too Short",
    bad: "Bad Password",
    good: "Good Password",
    strong: "Strong Password",
    mismatch: "Password Mismatch"
}

/* ]]> */

function check_pass_strength() {

    var pass1 = jQuery("#pass1").val(), user = jQuery("#user_login").val(), pass2 = jQuery("#pass2").val(), strength;

    jQuery("#pass-strength-result").removeClass("short bad good strong mismatch");

    if ( !pass1 ) {
        jQuery("#pass-strength-result").html( pwsL10n.empty );
        return;
    }

    strength = passwordStrength(pass1, user, pass2);

    switch ( strength ) {
        case 2:
            jQuery("#pass-strength-result").addClass("bad").html( pwsL10n["bad"] );
            break;

        case 3:
            jQuery("#pass-strength-result").addClass("good").html( pwsL10n["good"] );
            break;

        case 4:
            jQuery("#pass-strength-result").addClass("strong").html( pwsL10n["strong"] );
            break;

        case 5:
            jQuery("#pass-strength-result").addClass("mismatch").html( pwsL10n["mismatch"] );
            break;

        default:
            jQuery("#pass-strength-result").addClass("short").html( pwsL10n["short"] );
    }
}

function passwordStrength(password1, username, password2) {

    var shortPass = 1, badPass = 2, goodPass = 3, strongPass = 4, mismatch = 5, symbolSize = 0, natLog, score;

    // password 1 != password 2
    if ( (password1 != password2) && password2.length > 0 )
        return mismatch

    //password < 4
    if ( password1.length < 4 )
        return shortPass

    //password1 == username
    if ( password1.toLowerCase() == username.toLowerCase() )
        return badPass;

    if ( password1.match(/[0-9]/) )
        symbolSize +=10;

    if ( password1.match(/[a-z]/) )
        symbolSize +=26;

    if ( password1.match(/[A-Z]/) )
        symbolSize +=26;

    if ( password1.match(/[^a-zA-Z0-9]/) )
        symbolSize +=31;

    natLog = Math.log( Math.pow(symbolSize, password1.length) );

    score = natLog / Math.LN2;

    if ( score < 40 )
        return badPass

    if ( score < 56 )
        return goodPass

    return strongPass;
}

jQuery(document).ready( function() {
    jQuery("#pass1").val("").keyup( check_pass_strength );
    jQuery("#pass2").val("").keyup( check_pass_strength );
});