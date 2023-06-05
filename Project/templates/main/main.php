<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Мой блог</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

    <h1 class="h1">Мой блог</h1>

    <?php 
    include_once('db_connect.php');
    $query = "SELECT * FROM articles";
    $result = mysqli_query($conn, $query);
    $articles = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach ($articles as $article): 
        $article_id = $article['id'];
        $query = "SELECT * FROM comments WHERE article_id = '$article_id'";
        $comments = mysqli_query($conn, $query);
    ?>
    
        <div class="main-block">
            <h2 class="h2"><a href="article/show/<?= $article['id']; ?>"><?= $article['name']; ?></a></h2>
            <p class="artic-p"><?= $article['text']; ?></p>
        </div>
        
        <?php if(mysqli_num_rows($comments) > 0): ?>
            <h2 class="title">Комментарии к статье №<?= $article_id; ?></h2>
            <?php while ($comment = mysqli_fetch_assoc($comments)): ?>
            <div class="comment-wrapper">
                <p class="comment"><?= $comment['text']; ?></p>
                <div class="comment-actions">
                  <a href="edit_comment.php?id=<?= $comment['id']; ?>" class="edit-link">Редактировать</a>
                  <a href="delete_comment.php?id=<?= $comment['id']; ?>" class="del-link">Удалить</a>
                </div>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align:center;">Комментариев пока нет</p>
        <?php endif; ?>
        
        <a href="add_comment.php?article_id=<?= $article['id']; ?>" class="add-link">Добавить комментарий</a>
        <hr>
    <?php endforeach; ?>

</body>

</html>