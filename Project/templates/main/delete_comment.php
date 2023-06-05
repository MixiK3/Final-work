<?php
include_once('db_connect.php');

$comment_id = $_GET['id'];

$query = "DELETE FROM comments WHERE id = '$comment_id'";
$result = mysqli_query($conn, $query);

if ($result) {
  header("Location: ".$_SERVER['HTTP_REFERER']); // перенаправляем на предыдущую страницу
  exit;
} else {
  echo "Ошибка при удалении комментария";
}
?>