<?php

namespace Models;

USE User ;


class Reader extends User {

      

    public function addcoment( $user_id ,$article_id ,  $content ){

     $stmt = $this->pdo->prepare(" INSERT INTO comments ");






    }






}