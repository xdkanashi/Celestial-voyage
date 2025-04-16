document.addEventListener('DOMContentLoaded', function() {
    const openButton = document.querySelector('.open-button');
    const textBar = document.querySelector('.text-bar');
    const stellarStat = document.querySelector('.stellar-stat');
    const stellarText = document.querySelector('.stellar-text');
    const stellar2Text = document.querySelector('.stellar2-text');
    const prevButton = document.querySelector('.prev-button');
    const nextButton = document.querySelector('.next-button');
    const contentData = document.getElementById('content-data').innerText;
    const lines = JSON.parse(contentData);
    
        // Скрыть текстовый блок и другие элементы при загрузке страницы
        textBar.style.opacity = '0';
        textBar.style.display = 'none';
        stellarStat.style.opacity = '0'; // Устанавливаем начальную прозрачность для .stellar-stat
        stellarStat.style.display = 'none'; // Скрываем .stellar-stat
    
        openButton.addEventListener('click', function() {
            // Плавно показать текстовый блок
            textBar.style.display = 'block';
            setTimeout(() => {
                textBar.style.opacity = '1';
            }, 100);
    
            stellarText.style.display = 'block';
            setTimeout(() => {
                stellarText.style.opacity = '1';
            }, 100);
    
            // Скрыть кнопку "Click to Open" после нажатия
            openButton.style.opacity = '0';
            openButton.style.display = 'none';
    
            // Плавно показать .stellar-stat после нажатия кнопки
            stellarStat.style.display = 'block';
            setTimeout(() => {
                stellarStat.style.opacity = '1';
            }, 100);
        });
        
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
        displayLines(firstHalf, stellarText);
        displayLines(secondHalf, stellar2Text);
        
        // Начальное состояние: скрываем `text-bar` элементы
        stellarText.style.display = 'none';
        stellar2Text.style.display = 'none';
    
        // Обработчик клика на первом `text-bar` элементе
        stellarText.addEventListener('click', function() {
            stellarText.style.display = 'block';
        });
    
        // Обработчик клика на втором `text-bar` элементе
        stellar2Text.addEventListener('click', function() {
            stellar2Text.style.display = 'block';
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

        stellarText.style.display = 'block';
        setTimeout(() => {
            stellarText.style.opacity = '1';
        }, 100);

        // Скрыть кнопку "Click to Open" после нажатия
        openButton.style.opacity = '0';
        openButton.style.display = 'none';
    });

    // Список элементов, по которым нужно кликать
    const elementsToClick = [openButton, stellarText];

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

    // Добавляем обработчик клика на stellarText
    stellarText.addEventListener('click', function() {
        stellar2Text.style.display = 'block';
        setTimeout(() => {
            stellar2Text.style.opacity = '1';
            stellarText.style.opacity = '0'; // Скрыть stellarText
        }, 100);
    });

    // Добавляем обработчик клика на textBar
    textBar.addEventListener('click', function() {
        stellar2Text.style.display = 'block';
        setTimeout(() => {
            stellar2Text.style.opacity = '1';
            stellarText.style.opacity = '0'; // Скрыть stellarText
        }, 100);
    });
});

// Toggle Menu
document.getElementById('menuToggle').addEventListener('click', function(e) {
    e.preventDefault();
    var sideNav = document.querySelector('.side-nav');
    sideNav.classList.toggle('open');
});

// Highlight Active Button
document.addEventListener('DOMContentLoaded', function () {
    // Highlight active button based on URL parameter
    const params = new URLSearchParams(window.location.search);
    const filter = params.get('filter');

    const navButtons = document.querySelectorAll('.side-nav form button');
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
});

document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('#filterForm button');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            fetchFilteredstellars(filter);
        });
    });
});

function fetchFilteredstellars(filter) {
    fetch('filter.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'filter=' + encodeURIComponent(filter)
    })
    .then(response => response.text())
    .then(data => {
        document.querySelector('.globe-container').innerHTML = data;
    })
    .catch(error => console.error('Error:', error));
}

document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('form button');
    buttons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const filter = this.value;
            const form = this.closest('form');
            const urlParams = new URLSearchParams(new FormData(form));
            urlParams.set('filter', filter);
            const url = `index.php?${urlParams.toString()}`;
            window.location.href = url;
        });
    });
});