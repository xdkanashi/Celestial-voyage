document.addEventListener('DOMContentLoaded', (event) => {
    const prevButton = document.querySelector('.prev-button');
    const nextButton = document.querySelector('.next-button');

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

    document.querySelectorAll('.delete-comment').forEach(button => {
        button.addEventListener('click', function () {
            const commentId = this.getAttribute('data-comment-id');
            console.log('Comment ID:', commentId);  // Выводим идентификатор комментария в консоль
            if (confirm('Are you sure you want to delete this comment?')) {
                fetch(`/php/admin-menu/moderate-comments/delete-comments.php?id=${commentId}`, {
                    method: 'DELETE'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Удаление комментария из DOM
                        this.closest('li').remove();
                        alert('Comment deleted successfully.');
                    } else {
                        alert(data.message || 'Error deleting comment.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting comment.');
                });
            }
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

