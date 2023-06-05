<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Comment Form</title>
    <style>
        body {
            background-color: #eee;
            color: #333;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #fff;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            display: block;
            margin-top: 10px;
            padding: 5px 10px;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #444;
        }
        textarea {
            width: 100%;
            height: 150px;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }
        p {
            color: #ccc;
        }
    </style>
</head>
<body>

<?php
include_once('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $text = $_POST['text'];

    $query = "UPDATE comments SET text = '$text' WHERE id = '$id'";
    mysqli_query($conn, $query);

    // Получаем данные комментария после обновления
    $updated_comment_query = "SELECT * FROM comments WHERE id = '$id'";
    $updated_comment_result = mysqli_query($conn, $updated_comment_query);
    $updated_comment = mysqli_fetch_assoc($updated_comment_result);

    // Получаем значение article_id из обновленного комментария
    $article_id = $updated_comment['article_id'];

    header("Location: main.php?id=$article_id");
    exit;
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM comments WHERE id = '$id'";
    $comment_result = mysqli_query($conn, $query);
    $comment = mysqli_fetch_assoc($comment_result);
    
}
?>

<div class="form-container">

<?php if ($comment) { ?>
    <form method="post" action="edit_comment.php">
        <input type="hidden" name="id" value="<?php echo $comment['id']; ?>">
        <label for="text">Редактировать комментарий:</label>
        <textarea id="text" name="text"><?php echo $comment['text']; ?></textarea>
        <input type="submit" value="Сохранить">
    </form>
    
<?php } else { ?>
    <p>Комментарий не найден.</p>
<?php } ?>

</div>
    
</body>
</html>