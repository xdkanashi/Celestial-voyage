document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action="manage-users.php"]');
    const editAvatarButton = document.getElementById('editAvatarButton');
    const avatarInput = document.getElementById('avatar');
    const cancelButton = document.getElementById('cancelButton');
    const deleteAccountButton = document.getElementById('deleteAccountButton');
    const responseContainer = document.getElementById('response-container');
    const avatarImage = document.querySelector('.avatar');
    const prevButton = document.querySelector('.prev-button');
    const nextButton = document.querySelector('.next-button');
    const navButtons = document.querySelectorAll('.side-nav form button');
    const sideNav = document.querySelector('.side-nav');

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

        fetch('manage-users.php', {
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

    deleteAccountButton.addEventListener('click', () => {
        if (confirm('Are you sure you want to delete this account? This action cannot be undone.')) {
            const userId = document.querySelector('input[name="user_id"]').value;

            fetch('delete-account.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ user_id: userId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    if (data.next_user_id) {
                        window.location.href = `index.php?id=${data.next_user_id}&filter=${getCurrentFilter()}`;
                    } else {
                        alert('No next user found.');
                        window.location.href = 'index.php';
                    }
                } else {
                    alert('Account deletion failed: ' + data.message);
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
        } else if (event.key === 'ArrowLeft') {
            // Нажата клавиша "влево", переходим к предыдущей странице
            prevButton.click();
        } else if (event.key === 'ArrowRight') {
            // Нажата клавиша "вправо", переходим к следующей странице
            nextButton.click();
        }
    });

    // Toggle Menu
    document.getElementById('menuToggle').addEventListener('click', function(e) {
        e.preventDefault();
        sideNav.classList.toggle('open');
    });

    // Highlight Active Button
    const params = new URLSearchParams(window.location.search);
    const filter = params.get('filter');

    navButtons.forEach(function(button) {
        if (button.value === filter) {
            button.classList.add('active-filter');
        }

        button.addEventListener('click', function() {
            navButtons.forEach(function(btn) {
                btn.classList.remove('active-filter');
            });
            this.classList.add('active-filter');
        });
    });

    function getCurrentFilter() {
        const params = new URLSearchParams(window.location.search);
        return params.get('filter') || '';
    }

    const filterButtons = document.querySelectorAll('.side-nav form button');
    filterButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const filter = this.value;
            const userId = document.querySelector('input[name="user_id"]').value;
            const url = `index.php?id=${userId}&filter=${filter}`;
            window.location.href = url;
        });
    });
});




