document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action="profile.php"]');
    const editAvatarButton = document.getElementById('editAvatarButton');
    const avatarInput = document.getElementById('avatar');
    const cancelButton = document.getElementById('cancelButton');
    const signOutButton = document.getElementById('signOutButton');
    const deleteAccountButton = document.getElementById('deleteAccountButton');
    const responseContainer = document.getElementById('response-container');
    const avatarImage = document.querySelector('.avatar');

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

        fetch('profile.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            const successNotification = document.querySelector('.notification-true img');
            const errorNotification = document.querySelector('.notification-false img');
            
            if (data.status === 'success') {
                successNotification.style.display = 'block';
                successNotification.classList.add('pop-up');
                
                setTimeout(() => {
                    successNotification.classList.add('fade-out');
                }, 3000);

                errorNotification.style.display = 'none';
                errorNotification.classList.remove('pop-up');
                errorNotification.classList.remove('fade-out');

                responseContainer.innerText = data.message;
                
                showResponseContainer(responseContainer);
                
                hideResponseContainer(responseContainer, 6000);

                // Обновление аватарки на странице
                if (data.avatar) {
                    avatarImage.src = data.avatar;
                }
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

    editAvatarButton.addEventListener('click', () => {
        avatarInput.click();
    });

    cancelButton.addEventListener('click', () => {
        clearForm();
    });

    signOutButton.addEventListener('click', () => {
        if (confirm('Are you sure you want to Sign out?')) {
            fetch('sign-out.php', {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    window.location.href = '/php/login/index.php';
                } else {
                    alert('Sign out failed.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    });

    deleteAccountButton.addEventListener('click', () => {
        if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
            fetch('delete-account.php', {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    window.location.href = '/php/login/index.php';
                } else {
                    alert('Account deletion failed.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    });
    
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Предотвращаем отправку формы при нажатии Enter
        }
    });
});











