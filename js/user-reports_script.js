document.addEventListener('DOMContentLoaded', () => {
    const deleteButton = document.getElementById('deleteReportButton');
    const prevButton = document.querySelector('.prev-button');
    const nextButton = document.querySelector('.next-button');

    if (deleteButton) {
        deleteButton.addEventListener('click', () => {
            const reportId = deleteButton.getAttribute('data-id');

            if (confirm('Are you sure you want to delete this report?')) {
                fetch('/php/admin-menu/user-reports/delete-reports.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: reportId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert('Report deleted successfully.');
                        if (data.next_report_id) {
                            window.location.href = `/php/admin-menu/user-reports/index.php?id=${data.next_report_id}`;
                        } else {
                            window.location.href = '/php/admin-menu/user-reports/index.php';
                        }
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    }

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            event.preventDefault(); // Предотвращаем отправку формы при нажатии Enter
        } else if (event.key === 'ArrowLeft' && prevButton) {
            // Нажата клавиша "влево", переходим к предыдущей странице
            prevButton.click();
        } else if (event.key === 'ArrowRight' && nextButton) {
            // Нажата клавиша "вправо", переходим к следующей странице
            nextButton.click();
        }
    });
});




