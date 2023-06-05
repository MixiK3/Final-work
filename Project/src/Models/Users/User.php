<?php

namespace Models\Users;
use Models\ActiveRecordEntity;

    class User extends ActiveRecordEntity{
        protected $email;
        protected $nickname;
        protected $isConfirmed;
        protected $role;
        protected $passwordHash;
        protected $authToken;
        protected $createdAt;

        public function getNickName(){
            return $this->nickname;
        }

        protected static function getTableName():string 
        {
            return 'users';
        }
    }