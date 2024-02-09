const host = 'localhost';
const username = 'root';
const password = '';
const dbname = 'test';

// Соединяемся с БД
const conn = new mysqli(host, username, password, dbname);
if (conn.connect_error) {
console.log("Ошибка подключения: " + conn.connect_error);
}