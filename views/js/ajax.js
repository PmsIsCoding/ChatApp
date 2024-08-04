$(function(){
    let returnCode
    function checkForm() {
        if ($('#login').val() !== "" && 
            $('#nom').val() !== "" && 
            $('#prenom').val() !== "" && 
            $('#mdp').val() !== "" && 
            $('#confmdp').val() !== "" && 
            $('#mdp').val().length >= 8 && 
            $('#confmdp').val() === $('#mdp').val() &&
            $('.error-login').html() == "") {
            
            $('.submit').prop('disabled', false)
        } else {
            $('.submit').prop('disabled', true)
        }
    }
    $('#login').on('keyup', () => {
        let login = $('#login').val()
        let xhr = new XMLHttpRequest()
        let target = '../modeles/checkInfo.php?login=' + login
        xhr.open('GET', target)
        xhr.send()
        xhr.onreadystatechange = () => {
            if (xhr.readyState == 4 && xhr.status == 200) {
                returnCode = xhr.responseText
                if (returnCode == 0 && $('#login').val() != "") {
                    $('.error-login').html("Ce login est déjà pris")
                } else if ($('#login').val() == "") {
                    $('.error-login').html("")
                } else if (!document.getElementById('login').checkValidity()) {
                    $('.error-login').html("Veuillez entrer un email valide")
                } else if (returnCode == 1) {
                    $('.error-login').html("")
                }
                // console.log(returnCode)
            }
            checkForm()
        }
    })
    $('#mdp').on('keyup', function() {
        if ($(this).val() != "" && $(this).val().length < 8) {
            $('.mdp-error').html("Votre mot de passe doit contenir au moins 8 caractères")
        } else {
            $('.mdp-error').html("")
        }
        checkForm()
    });

    $('#confmdp').on('keyup', function() {
        if ($(this).val() != "" && $(this).val() != $('#mdp').val()) {
            $('.confmdp-error').html('Donnez le même mot de passe')
        } else {
            $('.confmdp-error').html("")
        }
        checkForm()
    });

    $('#nom, #prenom').on('keyup', checkForm)

    checkForm()
});