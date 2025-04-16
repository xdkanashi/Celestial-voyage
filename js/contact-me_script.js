document.addEventListener('DOMContentLoaded', function() {
    // Находим форму по классу
    const form = document.querySelector('.contact-form');

    // Функция для очистки формы
    function clearForm() {
        form.reset();
    }

    // Функция для запуска анимации всплытия контейнера
    function showResponseContainer(responseContainer) {
        // Устанавливаем display в block и прозрачность в 0
        responseContainer.style.display = 'block';
        responseContainer.style.opacity = 0;
        
        // Используем анимацию плавного появления
        setTimeout(() => {
            responseContainer.style.transition = 'opacity 0.5s ease-in-out'; // Плавное изменение прозрачности
            responseContainer.style.opacity = 1; // Устанавливаем прозрачность в 1
        }, 10); // Небольшая задержка для инициализации анимации
    }

    // Функция для запуска анимации исчезновения
    function hideResponseContainer(responseContainer, delay) {
        setTimeout(() => {
            responseContainer.style.transition = 'opacity 0.5s ease-in-out'; // Плавное изменение прозрачности
            responseContainer.style.opacity = 0; // Устанавливаем прозрачность в 0
            
            // После завершения анимации устанавливаем display в none
            setTimeout(() => {
                responseContainer.style.display = 'none';
            }, 500); // Задержка в 0.5 секунд после начала анимации исчезновения
        }, delay);
    }

    // Добавляем обработчик события submit
    form.addEventListener('submit', function(event) {
        // Предотвращаем стандартное действие отправки формы
        event.preventDefault();

        // Создаем объект FormData из формы
        const formData = new FormData(form);

        // Отправляем данные формы с использованием fetch
        fetch('contact_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Находим элементы уведомлений и контейнер
            const successNotification = document.querySelector('.notification-true img');
            const errorNotification = document.querySelector('.notification-false img');
            const responseContainer = document.getElementById('response-container');
            
            // Если ответ успешный
            if (data.status === 'success') {
                // Показ уведомления о успехе
                successNotification.style.display = 'block';
                successNotification.classList.add('pop-up');
                
                // Очищаем форму
                clearForm();

                // Запуск анимации исчезновения уведомления о успехе
                setTimeout(() => {
                    successNotification.classList.add('fade-out');
                }, 3000);

                // Скрытие уведомления об ошибке
                errorNotification.style.display = 'none';
                errorNotification.classList.remove('pop-up');
                errorNotification.classList.remove('fade-out');

                // Выводим сообщение об успехе в контейнере
                responseContainer.innerText = data.message;
                
                // Плавное появление контейнера
                showResponseContainer(responseContainer);
                
                // Запуск анимации исчезновения контейнера через 6 секунд
                hideResponseContainer(responseContainer, 6000);
            } else {
                // Если произошла ошибка, показ уведомления об ошибке
                errorNotification.style.display = 'block';
                errorNotification.classList.add('pop-up');
                
                // Удаляем класс fade-out для отображения уведомления об ошибке
                errorNotification.classList.remove('fade-out');

                // Запуск анимации исчезновения уведомления об ошибке
                setTimeout(() => {
                    errorNotification.classList.add('fade-out');
                }, 3000);

                // Скрытие уведомления о успехе
                successNotification.style.display = 'none';
                successNotification.classList.remove('pop-up');
                successNotification.classList.remove('fade-out');

                // Выводим сообщение об ошибке в контейнере
                responseContainer.innerText = data.message;
                
                // Плавное появление контейнера
                showResponseContainer(responseContainer);
                
                // Запуск анимации исчезновения контейнера через 6 секунд
                hideResponseContainer(responseContainer, 6000);
            }
        })
        .catch(error => {
            console.error('Error:', error);

            // Если произошла ошибка, показ уведомления об ошибке
            const errorNotification = document.querySelector('.notification-false img');
            const responseContainer = document.getElementById('response-container');

            // Показ уведомления об ошибке
            errorNotification.style.display = 'block';
            errorNotification.classList.add('pop-up');
            
            // Удаление класса `fade-out` для отображения уведомления об ошибке
            errorNotification.classList.remove('fade-out');

            // Запуск анимации исчезновения уведомления об ошибке
            setTimeout(() => {
                errorNotification.classList.add('fade-out');
            }, 3000);

            // Скрытие уведомления о успехе
            const successNotification = document.querySelector('.notification-true img');
            successNotification.style.display = 'none';
            successNotification.classList.remove('pop-up');
            successNotification.classList.remove('fade-out');

            // Выводим сообщение об ошибке в контейнере
            responseContainer.innerText = 'An error occurred during the request.';
            
            // Плавное появление контейнера
            showResponseContainer(responseContainer);
            
            // Запуск анимации исчезновения контейнера через 6 секунд
            hideResponseContainer(responseContainer, 6000);
        });
    });
});







