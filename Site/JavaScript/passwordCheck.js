let submitButton = document.getElementById("submitButton");
let conPass = document.getElementById("conPass");
let pass = document.getElementById("pass");
let pwdMsg = document.getElementById("passwordVerifyWarning");
let pwdVal = document.getElementById("passwordWarning");
let strengthBar = document.getElementById("pwStrength");

pass.addEventListener('keyup', passCheck)
conPass.addEventListener('keyup', passCheck)

function passCheck(){
    let validation = false;
    let match = false;
    if (conPass.value.length !== 0) {
        if (pass.value !== conPass.value) {
            pwdMsg.style.display = "block";
            match = false;
        } else {
            pwdMsg.style.display = "none";
            match = true;
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
        validation = true;
    }
    else{
        pwdVal.style.display = "block";
        validation = false;
    }
    if (match === true && validation === true){
        submitButton.type = "submit";
    }
    else{
        submitButton.type = "button";
    }

    let strength = 0;

    let symbols = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;

    let specialChars = 0;
    for (let i = 0; i < pass.value.length; i++) {
        if (symbols.test(pass.value[i])) {
            specialChars += 1;
        }

    }

    if (specialChars > 0) {
        strength += 10;
    }
    if (specialChars > 1) {
        strength += 30;
    }
    if (number) {
        strength += 10;
    }
    if (upper) {
        strength += 5;
    }
    if (lower) {
        strength += 5;
    }
    if (pass.value.length > 7) {
        strength += 10;
    }
    if (pass.value.length > 10) {
        strength += 15;
    }
    if (pass.value.length > 13) {
        strength += 15;
    }

    strengthBar.value = strength;

}