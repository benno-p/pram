
function toTitleCase(str){return str.replace(/\w\S*/g,function(txt){return txt.charAt(0).toUpperCase()+txt.substr(1).toLowerCase()})}

function check_mail(mail_v){
    var regex=/^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
    if(!regex.test(mail_v)){
        if (mail_v != "") {
            alert('format du courriel non valide (xxx@xxx.xx)');
            $('#courriel').val('');
            $("#inscription_mail").val('');
            //$("courriel").addClass("error_field");
            //$("#inscription_mail").addClass("error_field");
            return false
            }
        if (mail_v == "") {
            alert('courriel vide');
            $('#courriel').val('');
            $("#inscription_mail").val('');
            return false
            }
        }
    else{
        //$("courriel").removeClass("error_field");
        //$("#inscription_mail").removeClass("error_field");
        return true
        }
    }

function check_pwd(pwd_v){
    var regex=/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&_])[A-Za-z\d@$!%*#?&_]{8,}$/;
    if(!regex.test(pwd_v)){
        if (pwd_v != "") {
            //$('#pwd').val('');
            //alert('format du mot de passe non valide :\n- 8 caractères\n- 1 caractère spécial\n- 1 numéro');
            alert('format du mot de passe non valide :\n- 8 caractères (minimum)\n- 1 caractère spécial\n- 1 numéro');
            $("pwd").val('');
            $("#inscription_pwd").val('');
            return false
            }
        if (pwd_v == "") {
            alert('mot de passe vide');
            return false
            }
        }
    else{
        //$("pwd").removeClass("error_field");
        //$("#inscription_pwd").removeClass("error_field");
        return true
        }
    };

$("#signin").click( function () {
    {
        $.ajax({
            url      : "php/login.php",
            type     : "POST",
            data     : {email: $("#courriel").val(), password:$("#pwd").val()},
            async    : false,
            dataType : "text",
            error    : function(request, error) { console.log("not ajax success ");},
            success  : function(data) {
                if (data == "Success")
                {
                    console.log("success");
                    window.location.href = 'home.php';
                }
                else /*(data == "Failed")*/
                {
                    alert('Connexion impossible... Vérifiez le courriel et le mot de passe');
                }
                
            }
        });// End ajax
    }
});


$("#save_create_account").on('click',function(e){
    var mail = $("#inscription_mail").val();
    var pwd  = $("#inscription_pwd").val();
    var cgu  = $('#cgu_c').is(':checked');
    var c_c  = false;
    
    
    var mailOk = check_mail(mail);
    var passwordOk = check_pwd(pwd);
    
    if (passwordOk && mailOk && cgu) {
        $.ajax({
        type : 'POST',
        url: "php/ajax/is_valid_c.php",
        async    : false,
        data     : {vara : $("#verif").val().toUpperCase()},
        error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
        dataType : "text",
        success: function( out) {
                        if (out==="true") {
                            c_c = true;
                            
                        }
                        if (c_c === true) {
                            $.ajax({
                            type : 'POST',
                            url: "sent_mail.php",
                            async    : false,
                            data     : {courriel : mail, dwp : pwd},
                            error    : function(request, error) { alert("Erreur bon : responseText: "+request.responseText);},
                            dataType : "text",
                            success: function() {
                                        }
                            });
                            alert("Un mail vient d'être envoyé à "+mail+",\n Vous pouvez dès à présent vous connecter à l'application");
                            $('#ModalLogin').modal('hide');
                            //sessionStorage.clear();
                            //location.reload();
                        } else {
                            alert("Le mot 'captcha' n'est pas valide\n Etes-vous un robot ? ");
                            sessionStorage.setItem('trying', 'account');
                            location.reload();
                        }
                    }
        });
        
        
        
    } else {
        alert("Veuillez accepter les Conditions Générales d'Utilisation");
        sessionStorage.setItem('trying', 'account');
        location.reload();
    }
    
    
    
});

