// Toggle show/hide password

const inputPassword = document.getElementById('user_plainPassword');
const inputLoginPassword = document.getElementById('inputPassword');

const input = 
    document.getElementById('user_plainPassword') || 
    document.getElementById('inputPassword')
;

console.log(input);

const toggleShowPassword = document.getElementById('toggle_show');

function togglePassword(){
    if(toggleShowPassword.classList.contains('fa-eye')){
        toggleShowPassword.classList.remove('fa-eye');
        toggleShowPassword.classList.add('fa-eye-slash');
        input.setAttribute('type', 'text');
        // inputPassword.setAttribute('type', 'text');

        
    } else {
        toggleShowPassword.classList.remove('fa-eye-slash');
        toggleShowPassword.classList.add('fa-eye');
        // inputLoginPassword.setAttribute('type', 'password');
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
            // inputLoginPassword.setAttribute('type', 'password');
            input.setAttribute('type', 'password');


        }
    }
}

document.addEventListener('click', (e) => {
    hidePassword(e.target);
} )

