let submitButton = document.getElementById("submitButton");
let conPass = document.getElementById("conPass");
let pass = document.getElementById("pass");
let pwdMsg = document.getElementById("passwordVerifyWarning");
let pwdVal = document.getElementById("passwordWarning");

pass.addEventListener('keyup', passCheck)
conPass.addEventListener('keyup', passCheck)

function passCheck(){
    let validation = false;
    let match = false;
    if (conPass.value.length !== 0) {
        if (pass.value !== conPass.value) {
            pwdMsg.style.display = "block";
            validation = false;
        } else {
            pwdMsg.style.display = "none";
            validation = true;
        }
    }

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
        match = true;
    }
    else{
        pwdVal.style.display = "block";
        match = false;
    }
    if (match === true && validation === true){
        submitButton.type = "submit";
    }
    else{
        submitButton.type = "button";
    }
}