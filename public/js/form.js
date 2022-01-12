// Toggle show/hide password
const input = 
    document.getElementById('user_plainPassword') || 
    document.getElementById('inputPassword')
;
const toggleShowPassword = document.getElementById('toggle_show');

function togglePassword(){
    if(toggleShowPassword.classList.contains('fa-eye')){
        toggleShowPassword.classList.remove('fa-eye');
        toggleShowPassword.classList.add('fa-eye-slash');
        input.setAttribute('type', 'text');
    } else {
        toggleShowPassword.classList.remove('fa-eye-slash');
        toggleShowPassword.classList.add('fa-eye');
        input.setAttribute('type', 'password');
    }
}

function hidePassword(target){
    if(target == toggleShowPassword){
        togglePassword();
    } else{
        if(toggleShowPassword.classList.contains('fa-eye-slash')){
            toggleShowPassword.classList.remove('fa-eye-slash');
            toggleShowPassword.classList.add('fa-eye');
            input.setAttribute('type', 'password');
        }
    }
}

document.addEventListener('click', (e) => {
    hidePassword(e.target);
} )
