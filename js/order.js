function order(id, user_id) {
    // Проверяем, авторизован ли пользователь на сайте
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '../php/check_auth.php');
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Получаем ответ о статусе авторизации пользователя
            var auth = JSON.parse(xhr.responseText);
            if (auth.status === 'authorized') {
                // Получаем данные пользователя из PHP-сессии
                var name = auth.name;
                var email = auth.email;
                var phone = auth.phone;
                // Получаем данные о товаре из сервера
                var xhrProduct = new XMLHttpRequest();
                xhrProduct.open('GET', '../php/get_car.php?id=' + id);
                xhrProduct.onload = function() {
                    if (xhrProduct.status === 200) {
                        // Получаем данные о товаре
                        var product = JSON.parse(xhrProduct.responseText);
                        var title = product.title;
                        var price = product.price;
                        // Отображаем модальное окно с данными пользователя и о товаре
                        var modal = document.createElement('div');
                        modal.classList.add('modal');
                        modal.innerHTML = '<div class="modal-content">' +
                                                '<h2>Оформление заказа</h2>' +
                                                '<h3>' + title + '</h3>' +
                                                '<p>Стоимость: ' + price + '</p>' +
                                                '<form name="order-form" method="post" action="../php/send_mail.php">' +
                                                    '<input type="hidden" name="car_id" value="' + id + '">' +
                                                    '<input type="hidden" name="user_id" value="' + user_id + '">' +
                                                    '<label>Ваше имя:</label>'+
                                                 '<input type="text" name="name" value="' + name + '">' +
                                                '<label>Email:</label>' +
                                                '<input type="email" name="email" value="' + email + '">' +
                                                '<label>Телефон:</label>' +
                                                '<input type="tel" name="phone" value="' + phone + '">' +
                                                '<label>Комментарий к заказу:</label>' +
                                                '<textarea name="comment"></textarea>' +
                                                '<br><button name="modal" type="submit">Заказать</button><br><br>' +
                                                '<span class="close">Закрыть</span>' +
                                            '</form>' +
                                        '</div>';
                    document.body.appendChild(modal);
                    // Добавляем обработчик клика для закрытия модального окна
                    var modalClose = modal.querySelector('.close');
                    modalClose.addEventListener('click', function() {
                        modal.remove();
                    });
                } else {
                    console.log('Ошибка ' + xhrProduct.status);
                }
            };
            xhrProduct.send();
        } else {
            // Перенаправляем пользователя на страницу регистрации, если он не авторизован
window.location.href = 'register.php';
}
} else {
console.log('Ошибка ' + xhr.status);
}
};
xhr.send();
}

