<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add_comment</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php
    include_once('db_connect.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $author_id = $_POST['author_id'];
        $article_id = $_POST['article_id'];
        $text = $_POST['text'];

        $query = "INSERT INTO comments (author_id, article_id, text) VALUES ('$author_id', '$article_id', '$text')";
        mysqli_query($conn, $query);

        header("Location: main.php?id=$article_id");
        exit;
    }
    ?>

    <form method="post" action="add_comment.php" class="comment-form">
        <input type="hidden" name="article_id"
            value="<?php echo isset($_GET['article_id']) ? $_GET['article_id'] : 1; ?>">

        <label for="author_id" class="comment-form__label">ID автора:</label>
        <input type="number" id="author_id" name="author_id" class="comment-form__input">
        <label for="text" class="comment-form__label">Комментарий:</label>
        <textarea id="text" name="text" class="comment-form__textarea"></textarea>
        <input type="submit" value="Добавить" class="comment-form__button">
    </form>



</body>

</html>
<!-- Далее идет PHP код, который подключает файл `db_connect.php`, получает данные из отправленной формы методом POST и добавляет их в базу данных. 

Затем идет форма, которая содержит поля для ввода `author_id` (ID автора) и `text` 
(текст комментария), а также кнопку для отправки формы. Когда форма отправляется, данные передаются в тот же файл `add_comment.php`, который обрабатывает данные. 

В целом, этот код позволяет добавлять комментарии к статье на веб-странице. -->