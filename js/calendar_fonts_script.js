document.addEventListener('DOMContentLoaded', function() {
    // Получаем элементы `cosmonaut` и `globe`
    const cosmonautElements = [
        document.querySelector('.cosmonaut1'),
        document.querySelector('.cosmonaut2'),
        document.querySelector('.cosmonaut3'),
        document.querySelector('.cosmonaut4')
    ];
    const globeElement = document.querySelector('.globe-container');
    const calendarIntroElement = document.querySelector('.calendars1-intro');

    // Классы фонов календаря
    const calendarClasses = [
        'calendars1-intro',
        'calendars2-intro',
        'calendars3-intro',
        'calendars4-intro',
        'calendars5-intro',
        'calendars6-intro',
        'calendars7-intro',
        'calendars8-intro',
        'calendars9-intro',
        'calendars10-intro',
        'calendars11-intro',
        'calendars12-intro'
    ];

    // Пути к изображениям космонавтов и планет
    const cosmonautImages = [
        '/img/svg/cosmonaut1.svg',
        '/img/svg/cosmonaut2.svg',
        '/img/svg/cosmonaut3.svg',
        '/img/svg/cosmonaut4.svg'
    ];
    
    const globeImages = [
        '/img/svg/earth.svg',
        '/img/svg/saturn.svg',
        '/img/svg/earth.svg',
        '/img/svg/earth.svg',
        '/img/svg/earth.svg',
        '/img/svg/earth.svg',
        '/img/svg/earth.svg',
        '/img/svg/earth.svg',
        '/img/svg/earth.svg',
        '/img/svg/earth.svg',
        '/img/svg/earth.svg',
        '/img/svg/earth.svg'
    ];

    // Функция для определения текущего месяца
    function getCurrentMonth() {
        const now = new Date();
        return now.getMonth() + 1; // Возвращает месяц в диапазоне от 1 до 12
    }

    // Функция для обновления изображений и классов
    function updateImagesAndClassesByMonth(month) {
        // Очищаем текущие классы фонов календаря и космонавтов
        calendarIntroElement.className = calendarIntroElement.className.replace(/calendars\d+-intro/g, '');
        cosmonautElements.forEach(element => {
            element.className = element.className.replace(/cosmonaut\d/g, '');
        });

        // Добавляем новые классы фонов календаря
        calendarIntroElement.classList.add(calendarClasses[month - 1]);

        // Обновляем изображения космонавтов и планет
        cosmonautElements.forEach((element, index) => {
            element.src = cosmonautImages[(month - 1) * cosmonautElements.length + index];
            element.alt = `Cosmonaut for month ${month}`;
        });

        globeElement.src = globeImages[month - 1];
        globeElement.alt = `Globe for month ${month}`;
    }

    // Получаем текущий месяц
    const currentMonth = getCurrentMonth();

    // Обновляем изображения и классы на основе текущего месяца
    updateImagesAndClassesByMonth(currentMonth);
});
