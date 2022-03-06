let submitButton = document.getElementById("submitButton");
let conPass = document.getElementById("conPass");
let pass = document.getElementById("pass");
if (conPass) {
    let pwdMsg = document.getElementById("passwordVerifyWarning");
    conPass.addEventListener('keyup', function () {
        if (pass.value !== conPass.value) {
            pwdMsg.style.display = "block";
            submitButton.type = 'button';
        } else {
            pwdMsg.style.display = "none";
            submitButton.type = 'submit';
        }
    });
}

if (pass) {
    let pwdVal = document.getElementById("passwordWarning");
    pass.addEventListener('keyup', function () {
        let upper = false;
        let lower = false;
        let number = false;
        if (/[A-Z]/.test(pass.value)){
            upper = true;
        }
        if (/[a-z]/.test(pass.value)){
            lower = true;
        }
        if (/[0-9]/.test(pass.value)){
            number = true;
        }

        if (upper === true && lower === true && number === true){
            pwdVal.style.display = "none";
            submitButton.type = 'submit';
        }
        else{
            pwdVal.style.display = "block";
            submitButton.type = 'button';
        }
    });

}
