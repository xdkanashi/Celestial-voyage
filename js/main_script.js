document.addEventListener('DOMContentLoaded', function() {
    const openButton = document.querySelector('.open-button');
    const textBar = document.querySelector('.text-bar');
    const headerLinks = document.querySelectorAll('.header_link');
    const mainName = document.querySelector('.main-name');
    const welcomeText = document.querySelector('.welcome-text');
    const welcome2Text = document.querySelector('.welcome2-text');
    const skillsButton = document.querySelector('.skills-button');
    
    // Скрыть текстовый блок и другие элементы при загрузке страницы
    textBar.style.opacity = '0';
    textBar.style.display = 'none';
    headerLinks.forEach(link => {
        link.style.opacity = '0';
        link.style.display = 'none';
    });
    mainName.style.opacity = '0';
    mainName.style.display = 'none';
    skillsButton.style.display = 'none';
  
    openButton.addEventListener('click', function() {
        // Плавно показать текстовый блок
        textBar.style.display = 'block';
        setTimeout(() => {
            textBar.style.opacity = '1';
        }, 100);
  
        // Плавно показать ссылки и название вступления
        headerLinks.forEach(link => {
            link.style.display = 'block';
            setTimeout(() => {
                link.style.opacity = '1';
            }, 100);
        });
        mainName.style.display = 'block';
        setTimeout(() => {
            mainName.style.opacity = '1';
        }, 100);
  
        welcomeText.style.display = 'block';
        setTimeout(() => {
            welcomeText.style.opacity = '1';
        }, 100);
  
        // Скрыть кнопку "Click to Open" после нажатия
        openButton.style.opacity = '0';
        openButton.style.display = 'none';
    });
  
    // Список элементов, по которым нужно кликать
    const elementsToClick = [openButton, welcomeText, skillsButton];
    
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
        }
    });
  
  // Добавляем обработчик клика на welcome-text
  welcomeText.addEventListener('click', function() {
    welcome2Text.style.display = 'block';
    skillsButton.style.display = 'block'; // Отображаем кнопку skillsButton при клике на welcomeText
    setTimeout(() => {
        welcome2Text.style.opacity = '1';
        skillsButton.style.opacity = '1'
        welcomeText.style.opacity = '0'; // Скрыть welcomeText
    }, 100);
  });
  
  // Добавляем обработчик клика на textBar
  textBar.addEventListener('click', function() {
    welcome2Text.style.display = 'block';
    skillsButton.style.display = 'block'; // Отображаем кнопку skillsButton при клике на textBar
    setTimeout(() => {
        welcome2Text.style.opacity = '1';
        skillsButton.style.opacity = '1';
        welcomeText.style.opacity = '0'; // Скрыть welcomeText
    }, 100);
  });
  
  });
  



  
  