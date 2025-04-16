document.addEventListener('DOMContentLoaded', function() {
    // Находим кнопку "Cosmic Calendar"
    const cosmicCalendarButton = document.getElementById('cosmic-calendar-button');

    // Добавляем обработчик события клика на кнопку "Cosmic Calendar"
    cosmicCalendarButton.addEventListener('click', function() {
        // Получаем текущую системную дату
        const currentDate = new Date();

        // Извлекаем день, месяц и год
        const day = currentDate.getDate(); // Получаем текущий день месяца (от 1 до 31)
        const month = currentDate.getMonth() + 1; // Получаем текущий месяц (от 0 до 11, поэтому добавляем 1)

        // Создаем URL для переадресации на соответствующую страницу календаря
        const url = `calendar/${month}/${day}.html`;

        // Перенаправляем пользователя на этот URL
        window.location.href = url;
    });
});
