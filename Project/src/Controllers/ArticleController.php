<?php

namespace Controllers;
    use View\View;
    use Models\Articles\Article;
    use Models\Users\User;

    class ArticleController{

        private $view;

        public function __construct(){
            $this->view = new View(__DIR__.'/../../templates');
        }

        public function create(){
            $users = User::findAll();
            $this->view->renderHtml('articles/create.php', ['users'=>$users]);
        }

        public function show(int $id){
            $article = Article::getById($id);
            if ($article == null) $this->view->renderHtml('errors/error.php', [], 404);
                else $this->view->renderHtml('templates/articles/show.php', ['article'=>$article]);
        }

        public function edit(int $id){
            $article = Article::getById($id);
            $users = User::findAll();
            if ($article == null) $this->view->renderHtml('errors/error.php', [], 404);
                else $this->view->renderHtml('articles/edit.php', ['article'=>$article, 'users'=>$users]);
        }

        public function update(int $id){
            $article = Article::getById($id);
            $article->setName('new article');
            $article->setText('new text');
            $article->save();
        }

        public function store(){
            $article = new Article;
            $user = User::getById($_POST['author']);
            $article->setName($_POST['name']);
            $article->setText($_POST['text']);
            $article->setAuthorId($user);
            $article->save();
            $article->id = Article::lastInsertId();
            $this->view->renderHtml('articles/show.php', ['article'=>$article]);
        }

        public function destroy(int $id){
            $article = Article::getById($id);
            $article->delete();
        }
    }
