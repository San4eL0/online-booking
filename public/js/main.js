// public/js/main.js
document.addEventListener('DOMContentLoaded', function() {
    // Автоматическое скрытие сообщений через 5 секунд
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const closeButton = alert.querySelector('.btn-close');
            if (closeButton) {
                closeButton.click();
            }
        }, 5000);
    });
    
    // Валидация форм на клиенте
    const forms = document.querySelectorAll('.needs-validation');
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
    
    // Маска для телефона
    const phoneInputs = document.querySelectorAll('input[type="tel"]');
    phoneInputs.forEach(input => {
        input.addEventListener('input', function(e) {
            let value = this.value.replace(/\D/g, '');
            
            // Российские номера (11 цифр с 7 или 8)
            if (value.length === 11 && (value.startsWith('7') || value.startsWith('8'))) {
                let formatted = '+' + value;
                if (value.length === 11) {
                    formatted = '+' + value[0] + ' (' + value.substring(1, 4) + ') ' + 
                               value.substring(4, 7) + '-' + value.substring(7, 9) + '-' + value.substring(9, 11);
                    this.value = formatted;
                }
            } 
            // 10-значные номера
            else if (value.length === 10) {
                this.value = value.replace(/(\d{3})(\d{3})(\d{2})(\d{2})/, '($1) $2-$3-$4');
            }
            else if (value.length > 11) {
                this.value = this.value.slice(0, -1);
            }
        });
        
        // Обработка вставки из буфера обмена
        input.addEventListener('paste', function(e) {
            setTimeout(() => {
                let value = this.value.replace(/\D/g, '');
                if (value.length === 11 && (value.startsWith('7') || value.startsWith('8'))) {
                    let formatted = '+' + value[0] + ' (' + value.substring(1, 4) + ') ' + 
                                   value.substring(4, 7) + '-' + value.substring(7, 9) + '-' + value.substring(9, 11);
                    this.value = formatted;
                }
            }, 10);
        });
    });
    
    // Подтверждение удаления
    const deleteButtons = document.querySelectorAll('.btn-danger');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Вы уверены, что хотите выполнить это действие?')) {
                e.preventDefault();
            }
        });
    });
    
    // Фильтр по статусу
    const statusFilter = document.getElementById('statusFilter');
    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            const form = this.closest('form');
            if (form) form.submit();
        });
    }
    
    // Сохранение параметров сортировки и фильтров
    const sortLinks = document.querySelectorAll('.sort-link');
    sortLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const url = new URL(window.location.href);
            const sort = this.dataset.sort;
            const currentSort = url.searchParams.get('sort');
            const currentOrder = url.searchParams.get('order');
            
            let newOrder = 'asc';
            if (currentSort === sort && currentOrder === 'asc') {
                newOrder = 'desc';
            }
            
            url.searchParams.set('sort', sort);
            url.searchParams.set('order', newOrder);
            window.location.href = url.toString();
            e.preventDefault();
        });
    });
});
