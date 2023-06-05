<?php include __DIR__ . "/../header.php"; ?>

<h2>
    <?= $article->getName(); ?>
</h2>
<p>
    <?= $article->getText(); ?>
</p>
<p>
    <?= $article->getAuthorId()->getNickname(); ?>
</p>
<a href="../edit/<?= $article->getId(); ?>">Редактировать</a>
<a href="../destroy/<?= $article->getId(); ?>">Удалить</a>

<?php include __DIR__ . "/../footer.html"; ?>