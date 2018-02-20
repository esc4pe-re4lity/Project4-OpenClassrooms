function confirmExit(e){
    var formElt = document.querySelector("form"),
        titleElt = formElt.title,
        contentElt = tinyMCE.activeEditor.getContent({format: 'text'}).trim();
    if(titleElt.value === "" && contentElt === ""){
    }
    else{
        var message = "Vous êtes sur le point de quitter la page en pleine rédaction, êtes vous sûr ?";
        e.returnValue = message;
        return message;
    }
}

function confirmSubmit(e){
    var formElt = document.querySelector("form"),
        titleElt = formElt.title,
        contentElt = tinyMCE.activeEditor.getContent({format: 'text'}).trim();
    if(titleElt.value !== "" && contentElt !== ""){
        if(e.type === 'keypress' && e.keyCode === 13){
            window.removeEventListener("beforeunload",confirmExit);
        }else if(e.type === 'click'){
            window.removeEventListener("beforeunload",confirmExit);
        }
    }else{
        return false;
    }
}

function confirmDelete(e){
    var message = "Etes-vous sûr de vouloir supprimer cet article ?";
    if(confirm(message) === false){
        e.preventDefault();
    }
}

function displayNav(){
    if(i===0){
        document.getElementById("nav-menu").style.display = "block";
        i = i+1;
    }else if(i===1){
        document.getElementById("nav-menu").style.display = "none";
        i = i-1;
    }
}

var verifyPseudo = function(){
    var formElt = document.querySelector("form"),
        pseudoElt = formElt.pseudo,
        infoElt = document.getElementById("info"),
        regexPseudo = /^[a-zA-Z0-9_-]+$/;
    infoElt.textContent = "";
    if(!regexPseudo.test(pseudoElt.value)){
        infoElt.textContent = "Votre pseudo ne peut contenir que des majuscules, minuscule, des chiffres et tirets";
        pseudoElt.className = "incorrect";
        return false;
    }else{
        infoElt.textContent = "";
        pseudoElt.className = "correct";
        return true;
    }
};

var verifyEmail = function(){
    var formElt = document.querySelector("form"),
        emailElt = formElt.email,
        infoElt = document.getElementById("info"),
        regexEmail = /^[a-z0-9._-]+@[a-z0-9._-]{2,}.[a-z]{2,4}$/;
    infoElt.textContent = "";
    if(!regexEmail.test(emailElt.value)){
        infoElt.textContent = "Votre email ne correspond pas au format standard";
        emailElt.className = "incorrect";
        return false;
    }else{
        infoElt.textContent = "";
        emailElt.className = "correct";
        return true;
    }
};

var verifyPassword = function(){
    var formElt = document.querySelector("form"),
        passwordElt = document.getElementById("password"),
        infoElt = document.getElementById("info"),
        regexLowPassword = /^(?=.*[a-z])|(?=.*[A-Z])|(?=.*[0-9])|(?=.*[-_*\#!$?+@])/,
        regexMediumPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[-_*\#!$?+@])/,
        regexHighPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9].{2,})(?=.*[-_*\/\#!$?+@].{2,}).{8,}/;
    infoElt.textContent = "";
    if(passwordElt.value.length >= 8){
        if(regexHighPassword.test(passwordElt.value)){
            infoElt.textContent = "Now we're talking !";
            passwordElt.className = "correct";
            return true;
        }else if(regexMediumPassword.test(passwordElt.value)){
            infoElt.textContent = "Meh.. Peut mieux faire";
            passwordElt.className = "correct";
            return true;
        }else if(regexLowPassword.test(passwordElt.value)){
            infoElt.textContent = "Vous blaguez j'espère...";
            passwordElt.className = "incorrect";
            return false;
        }
    }else{
        infoElt.textContent = "Le mot de passe doit contenir au minimum 8 caractères";
        passwordElt.className = "incorrect";
        return false;
    }
};

var verifyConfPassword = function(){
    var formElt = document.querySelector("form"),
        passwordElt = document.getElementById("password"),
        passwordConfElt = document.getElementById("confirmPassword"),
        infoElt = document.getElementById("info");
    infoElt.textContent = "";
    if(passwordConfElt.value !== passwordElt.value){
        infoElt.textContent = "Les deux mots de passe doivent être identiques";
        passwordConfElt.className = "incorrect";
        return false;
    }else{
        infoElt.textContent = "";
        passwordConfElt.className = "correct";
        return true;
    }
};

function verifyForm(){
    var pseudoOK = verifyPseudo(),
        emailOK = verifyEmail(),
        passwordOK = verifyPassword(),
        confPasswordOK = verifyConfPassword();
    if(pseudoOK && passwordOK && confPasswordOK && emailOK){
        return true;
    }else{
        return false;
    }
}

function formNOK(){
    var infoElt = document.getElementById("info");
    infoElt.textContent = "Une ou plusieurs données saisies sont incorrectes";
}