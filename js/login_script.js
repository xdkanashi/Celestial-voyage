const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('login-container');

signUpButton.addEventListener('click', () => {
    container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
    container.classList.remove("right-panel-active");
});

document.addEventListener('DOMContentLoaded', function() {
    // Обработка формы регистрации
    const signUpForm = document.querySelector('form[action="sign-up.php"]');
    handleFormSubmission(signUpForm, 'sign-up.php');

    // Обработка формы входа
    const signInForm = document.querySelector('form[action="sign-in.php"]');
    handleFormSubmission(signInForm, 'sign-in.php');
});

function handleFormSubmission(form, action) {
    function clearForm() {
        form.reset();
    }

    function showResponseContainer(responseContainer) {
        responseContainer.style.display = 'block';
        responseContainer.style.opacity = 0;

        setTimeout(() => {
            responseContainer.style.transition = 'opacity 0.5s ease-in-out';
            responseContainer.style.opacity = 1;
        }, 10);
    }

    function hideResponseContainer(responseContainer, delay) {
        setTimeout(() => {
            responseContainer.style.transition = 'opacity 0.5s ease-in-out';
            responseContainer.style.opacity = 0;

            setTimeout(() => {
                responseContainer.style.display = 'none';
            }, 500);
        }, delay);
    }

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(form);

        fetch(action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            const successNotification = document.querySelector('.notification-true img');
            const errorNotification = document.querySelector('.notification-false img');
            const responseContainer = document.getElementById('response-container');

            if (data.status === 'success') {
                successNotification.style.display = 'block';
                successNotification.classList.add('pop-up');

                clearForm();

                setTimeout(() => {
                    successNotification.classList.add('fade-out');
                    if (action === 'sign-in.php') {
                        window.location.href = '/php/my-profile/index.php';
                    }
                }, 700);

                errorNotification.style.display = 'none';
                errorNotification.classList.remove('pop-up');
                errorNotification.classList.remove('fade-out');

                responseContainer.innerText = data.message;

                showResponseContainer(responseContainer);
                hideResponseContainer(responseContainer, 6000);
            } else {
                errorNotification.style.display = 'block';
                errorNotification.classList.add('pop-up');

                errorNotification.classList.remove('fade-out');

                setTimeout(() => {
                    errorNotification.classList.add('fade-out');
                }, 3000);

                successNotification.style.display = 'none';
                successNotification.classList.remove('pop-up');
                successNotification.classList.remove('fade-out');

                responseContainer.innerText = data.message;

                showResponseContainer(responseContainer);
                hideResponseContainer(responseContainer, 6000);
            }
        })
        .catch(error => {
            console.error('Error:', error);

            const errorNotification = document.querySelector('.notification-false img');
            const responseContainer = document.getElementById('response-container');

            errorNotification.style.display = 'block';
            errorNotification.classList.add('pop-up');

            errorNotification.classList.remove('fade-out');

            setTimeout(() => {
                errorNotification.classList.add('fade-out');
            }, 3000);

            const successNotification = document.querySelector('.notification-true img');
            successNotification.style.display = 'none';
            successNotification.classList.remove('pop-up');
            successNotification.classList.remove('fade-out');

            responseContainer.innerText = 'An error occurred during the request.';

            showResponseContainer(responseContainer);
            hideResponseContainer(responseContainer, 6000);
        });
    });
}








 
