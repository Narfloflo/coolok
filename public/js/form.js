// Toggle show/hide password

const inputPassword = document.getElementById('user_plainPassword');
console.log(inputPassword.type);
// const inputConnexionPassword = document.getElementById('connexion_password');
const toggleShowPassword = document.getElementById('toggle_show');

function togglePassword(){
    if(toggleShowPassword.classList.contains('fa-eye')){
        toggleShowPassword.classList.remove('fa-eye');
        toggleShowPassword.classList.add('fa-eye-slash');
        // inputConnexionPassword.type = 'text';
        inputPassword.setAttribute('type', 'text');
        
    } else {
        toggleShowPassword.classList.remove('fa-eye-slash');
        toggleShowPassword.classList.add('fa-eye');
        // inputConnexionPassword.type = 'password';
        inputPassword.setAttribute('type', 'password');
    }
}

function hidePassword(target){
    if(target == toggleShowPassword){
        togglePassword();
    } else{
        if(toggleShowPassword.classList.contains('fa-eye-slash')){
            toggleShowPassword.classList.remove('fa-eye-slash');
            toggleShowPassword.classList.add('fa-eye');
            inputPassword.setAttribute('type', 'password');
        }
    }
}

document.addEventListener('click', (e) => {
    console.log(e.target);
    hidePassword(e.target);
} )

