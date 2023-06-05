<?php include __DIR__."/../header.php";?>
<h3>Редактировать статью</h3>
<form action="../update/<?=$article->getId();?>" method="post">
    <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Заголовок статьи</label>
            <input name="name" type="text" class="form-control" id="exampleFormControlInput1" value="<?=$article->getName();?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Текст статьи</label>
            <textarea type="text" name="text" class="form-control" id="exampleFormControlTextarea1" rows="3"><?=$article->getText();?></textarea>
        </div>
        <div class="mb-3">
            <select name="author" class="form-control" aria-label="Default select example">
            <option selected><?=$article->getAuthorId()->getNickName();?></option>
            <?php foreach($users as $user):?>
                <option value="<?=$user->getId();?>"><?=$user->getNickName();?></option>
                <?=$user->getNickName().'<br>';?>
            <?php endforeach;?>
            </select>
    </div>
    <button class="btn btn-success" type="submit">Обновить</button>
</form>
   
<?php include __DIR__."/../footer.html";?>