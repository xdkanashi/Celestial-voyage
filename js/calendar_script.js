document.addEventListener('DOMContentLoaded', function() {
    const openButton = document.querySelector('.open-button');
    const textBar = document.querySelector('.text-bar');
    const calendarText = document.querySelector('.calendar-text');
    const calendar2Text = document.querySelector('.calendar2-text');
    const prevButton = document.querySelector('.prev-button');
    const nextButton = document.querySelector('.next-button');
    const contentData = document.getElementById('content-data').innerText;
    const lines = JSON.parse(contentData);
    

        
        // Функция для отображения строк текста в `text-bar`
        function displayLines(linesArray, textBarElement) {
            // Очистить текущий `text-bar`
            textBarElement.innerHTML = '';
            
            // Добавить строки контента в `text-bar`
            linesArray.forEach(line => {
                const p = document.createElement('p');
                p.innerText = line;
                textBarElement.appendChild(p);
            });
        }
    
        // Разделить строки контента на две части (например, для двух `text-bar` элементов)
        const halfIndex = Math.ceil(lines.length / 2);
        const firstHalf = lines.slice(0, halfIndex);
        const secondHalf = lines.slice(halfIndex);
        
        // Отобразить строки контента в `text-bar` элементах
        displayLines(firstHalf, calendarText);
        displayLines(secondHalf, calendar2Text);
        
        // Начальное состояние: скрываем `text-bar` элементы
        calendarText.style.display = 'none';
        calendar2Text.style.display = 'none';
    
        // Обработчик клика на первом `text-bar` элементе
        calendarText.addEventListener('click', function() {
            calendarText.style.display = 'block';
        });
    
        // Обработчик клика на втором `text-bar` элементе
        calendar2Text.addEventListener('click', function() {
            calendar2Text.style.display = 'block';
        });

    // Скрыть текстовый блок и другие элементы при загрузке страницы
    textBar.style.opacity = '0';
    textBar.style.display = 'none';

    openButton.addEventListener('click', function() {
        // Плавно показать текстовый блок
        textBar.style.display = 'block';
        setTimeout(() => {
            textBar.style.opacity = '1';
        }, 100);

        calendarText.style.display = 'block';
        setTimeout(() => {
            calendarText.style.opacity = '1';
        }, 100);

        // Скрыть кнопку "Click to Open" после нажатия
        openButton.style.opacity = '0';
        openButton.style.display = 'none';
    });

    // Список элементов, по которым нужно кликать
    const elementsToClick = [openButton, calendarText];

    // Индекс текущего элемента в списке
    let currentIndex = 0;

    // Добавляем обработчик нажатия клавиши Enter на документе
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            // Получаем текущий элемент из списка
            const currentElement = elementsToClick[currentIndex];

            // Если текущий элемент существует, кликаем по нему
            if (currentElement) {
                currentElement.click();

                // Увеличиваем индекс для следующего элемента
                currentIndex++;

                // Если достигнут конец списка элементов, сбрасываем индекс
                if (currentIndex >= elementsToClick.length) {
                    currentIndex = -1;
                }
            }
        } else if (event.key === 'ArrowLeft') {
            // Нажата клавиша "влево", переходим к предыдущей странице
            prevButton.click();
        } else if (event.key === 'ArrowRight') {
            // Нажата клавиша "вправо", переходим к следующей странице
            nextButton.click();
        }
    });

    // Добавляем обработчик клика на calendarText
    calendarText.addEventListener('click', function() {
        calendar2Text.style.display = 'block';
        setTimeout(() => {
            calendar2Text.style.opacity = '1';
            calendarText.style.opacity = '0'; // Скрыть calendarText
        }, 100);
    });

    // Добавляем обработчик клика на textBar
    textBar.addEventListener('click', function() {
        calendar2Text.style.display = 'block';
        setTimeout(() => {
            calendar2Text.style.opacity = '1';
            calendarText.style.opacity = '0'; // Скрыть calendarText
        }, 100);
    });
});
