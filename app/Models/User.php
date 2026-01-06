<?php


abstract class User {

protected $pdo ;   
protected $id ;
protected $name;
protected $email;
protected $password;
protected $role;

public function __construct($pdo){

   $this->pdo = $pdo ;
}


public function signup(array $data){

$stmt = $this->pdo->prepare(
    "INSERT INTO users (name , email , password , role , created_at) VALUES (?, ?, ?, ?, NOW())"
);

$hashedpassword = password_hash($data['password'] , PASSWORD_DEFAULT);


return $stmt->execute([
$data['name'],
$data['email'],
$hashedpassword,
$data['role']
]);

}

public static function findByEmail($pdo , $email ){

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]) ;

return $stmt->fetch(PDO::FETCH_ASSOC);

}


public function login($email , $password){

$user = self::findByEmail($this->pdo  , $email) ;

if($user && password_verify($password , $user['password'])){

    $this->id = $user['id'];
    $this->name = $user['name'];
    $this->email = $user['email'];
    $this->role = $user['role'];
  
    
    return true ;
}
return false;

}
}

?>