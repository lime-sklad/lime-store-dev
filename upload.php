<?php
// 3805950

// Путь к файлу, который вы хотите отправить
$file_path = 'img/lime_sklad.png';


// URL Google Формы для отправки данных
$form_url = 'https://docs.google.com/forms/u/3/d/e/1FAIpQLSdP9OFW-omEDqzLJdT0RQcsEPEW17PW6NOfyt2BnGfQBNpiQA/formResponse'; // Замените ФОРМАТ_ИДЕНТИФИКАТОР_ФОРМЫ на фактический идентификатор вашей Google Формы

// Данные для отправки
$data = array(
    'entry.3805950' => 'Значение поля 1', // Замените entry.1234567890 на идентификатор поля в Google Форме
 );

// Открываем файл и считываем его содержимое
$file_content = file_get_contents($file_path);

// Добавляем данные файла в данные для отправки
$data['file'] = base64_encode($file_content);

// Форматируем данные для отправки в виде строки запроса
$post_data = http_build_query($data);

// Опции запроса
$options = array(
    'http' => array(
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => $post_data,
    ),
);

// Создаем контекст запроса
$context = stream_context_create($options);

// Отправляем запрос на Google Форму
$result = file_get_contents($form_url, false, $context);

// Обработка результата
if ($result !== false) {
    echo "Данные успешно отправлены на Google Форму.";
} else {
    echo "Ошибка при отправке данных на Google Форму.";
}
?>
