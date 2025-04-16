document.addEventListener('DOMContentLoaded', function() {
    const commentsList = document.getElementById('comments-list');
    if (commentsList) {
        commentsList.scrollTop = commentsList.scrollHeight;
    }

    // Обработчик клика для перехода по комментариям
    const commentsLink = document.querySelector('.comments-link');
    if (commentsLink) {
        commentsLink.addEventListener('click', function(e) {
            e.preventDefault();
            const url = new URL(this.href);
            const id = url.searchParams.get('id');
            const objectClass = url.searchParams.get('class');
            window.location.href = `/php/comments/index.php?id=${id}&class=${objectClass}`;
        });
    }

    // Обработчики нажатия клавиш и клика по кнопке отправки формы
    const openButton = document.querySelector('.submit-comment button');
    const prevButton = document.querySelector('.prev-button');
    const nextButton = document.querySelector('.next-button');

    if (openButton && prevButton && nextButton) {
        const elementsToClick = [openButton];
        let currentIndex = 0;

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                const currentElement = elementsToClick[currentIndex];
                if (currentElement) {
                    currentElement.click();
                    currentIndex++;
                    if (currentIndex >= elementsToClick.length) {
                        currentIndex = 0;
                    }
                }
            } else if (event.key === 'ArrowLeft') {
                prevButton.click();
            } else if (event.key === 'ArrowRight') {
                nextButton.click();
            }
        });
    }

    // Находим форму по id
    const form = document.getElementById('commentForm');

    // Функция для очистки формы
    function clearForm() {
        form.reset();
    }

    // Функция для запуска анимации всплытия контейнера
    function showResponseContainer(responseContainer) {
        responseContainer.style.display = 'block';
        responseContainer.style.opacity = 0;
        
        setTimeout(() => {
            responseContainer.style.transition = 'opacity 0.5s ease-in-out';
            responseContainer.style.opacity = 1;
        }, 10);
    }

    // Функция для запуска анимации исчезновения
    function hideResponseContainer(responseContainer, delay) {
        setTimeout(() => {
            responseContainer.style.transition = 'opacity 0.5s ease-in-out';
            responseContainer.style.opacity = 0;
            
            setTimeout(() => {
                responseContainer.style.display = 'none';
            }, 500);
        }, delay);
    }

    // Добавляем обработчик события submit
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(form);

        fetch('comments.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const successNotification = document.querySelector('.notification-true img');
            const errorNotification = document.querySelector('.notification-false img');
            const responseContainer = document.getElementById('response-container');

            if (data.success) {
                successNotification.style.display = 'block';
                successNotification.classList.add('pop-up');
                
                clearForm();

                setTimeout(() => {
                    successNotification.classList.add('fade-out');
                }, 3000);

                errorNotification.style.display = 'none';
                errorNotification.classList.remove('pop-up');
                errorNotification.classList.remove('fade-out');

                responseContainer.innerText = data.message;
                showResponseContainer(responseContainer);
                hideResponseContainer(responseContainer, 6000);

                // Добавление нового комментария в список
                const newComment = data.comment;
                const newCommentElement = document.createElement('li');
                newCommentElement.innerHTML = `
                    <div class="comment-main-level">
                        <div class="comment-avatar"><img src="${newComment.Avatar}" alt=""></div>
                        <div class="comment-box">
                            <div class="comment-head">
                                <h1 class="comment-name">${newComment.Name} ${newComment.Surname}</h1>
                                <span>${newComment.Date}</span>
                            </div>
                            <div class="comment-content">${newComment.Text}</div>
                        </div>
                    </div>`;
                commentsList.appendChild(newCommentElement);
                commentsList.scrollTop = commentsList.scrollHeight;
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

    // Обработчик для кнопок лайков
    const likeButtons = document.querySelectorAll('.like-button');
    likeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.parentElement.getAttribute('data-comment-id');
            const likeIcon = this.querySelector('.like-icon');
            const likeCount = this.nextElementSibling;

            fetch('like-comments.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ commentId: commentId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    likeCount.textContent = data.likes;
                    likeIcon.src = '/img/profile/icons-profile/like-after.png';
                    likeIcon.setAttribute('data-liked', 'true');
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});


