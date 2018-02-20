<?php
class Controler
{
    public static function paging($page){
        require_once('model/Paging.php');
        require_once('model/PostManager.php');
        $paging = new Paging();
        $postManager = new PostManager();
        $numberOfPosts = $postManager->countPosts();
        $paging->setPage($page);
        $paging->setLimit(5);
        $paging->setOffset();
        $paging->setNumberOfPosts($numberOfPosts);
        $paging->setNumberOfPages();
        return $paging;
    }
    public static function getAllPosts(Paging $paging){
        require_once('model/PostManager.php');
        $postManager = new PostManager();
        $posts = $postManager->getAllPosts($paging);
        return $posts;
    }
    public static function getPost(){
        require_once('model/PostManager.php');
        $postManager = new PostManager();
        $post = $postManager->getPost();
        return $post;
    }
    public static function idPostExists(){
        require_once('model/PostManager.php');
        $postManager = new PostManager();
        $result = $postManager->idPostExists();
        return $result;
    }
    public static function addPost(){
        require_once('model/Post.php');
        require_once('model/PostManager.php');
        $post = new Post();
        $postManager = new PostManager();
        $title = utf8_decode($_POST['title']);
        $content = utf8_decode($_POST['content']);
        $post->setTitle($title);
        $post->setContent($content);
        $post->setExcerpt();
        $postId = $postManager->addPost($post);
        return $postId;
    }
    public static function updatePost(){
        require_once('model/Post.php');
        require_once('model/PostManager.php');
        $post = new Post();
        $postManager = new PostManager();
        $title = utf8_decode($_POST['title']);
        $content = utf8_decode($_POST['content']);
        $post->setTitle($title);
        $post->setContent($content);
        $post->setExcerpt();
        $postManager->updatePost($post);
    }
    public static function deletePost(){
        require_once('model/PostManager.php');
        $postManager = new PostManager();
        $postManager->deletePost();
    }
    public static function getComments(){
        require_once('model/CommentManager.php');
        $commentManager = new CommentManager();
        $comments = $commentManager->getComments();
        return $comments;
    }
    public static function addComment(){
        require_once('model/Comment.php');
        require_once('model/CommentManager.php');
        $comment = new Comment();
        $commentManager = new CommentManager();
        if(isset($_SESSION['user'])){
            $user = $_SESSION['user'];
            $comment->setAuthor($user->getPseudo());
        }else{
            $comment->setAuthor('anonyme');
        }
        $content = utf8_decode($_POST['content']);
        $comment->setContent($content);
        $comment->setIdPost((int)$_GET['idPost']);
        $commentManager->addComment($comment);
    }
    public static function getReportedComments(){
        require_once('model/ReportedCommentManager.php');
        $reportedCommentManager = new ReportedCommentManager();
        $reportedComments = $reportedCommentManager->getReportedComments();
        return $reportedComments;
    }
    public static function reportComment(){
        require_once('model/ReportedCommentManager.php');
        $reportedCommentManager = new ReportedCommentManager();
        $reportedCommentManager->reportComment();
    }
    public static function deleteComment(){
        require_once('model/CommentManager.php');
        require_once('model/ReportedCommentManager.php');
        $commentManager = new CommentManager();
        $reportedCommentManager = new ReportedCommentManager();
        $commentManager->deleteComment();
        $reportedCommentManager->deleteReportedComment();
    }
    public static function login(){
        require_once('model/User.php');
        require_once('model/UserManager.php');
        $user = new User();
        $userManager = new UserManager();
        $pseudo = utf8_decode($_POST['pseudo']);
        $password = utf8_decode($_POST['password']);
        $user->setPseudo($pseudo);
        $user->setPassword($password);
        $result = $userManager->login($user);
        $row=$result->fetch();
        if($row['pseudo']==$user->getPseudo() && $row['password']==$user->getPassword()){
            $user->setEmail($row['email']);
            $user->setAdmin($row['admin']);
            return $user;
        }else{
            return 'Le pseudo et/ou le mot de passe est incorrect';
        }
    }
    public static function pseudoExists(){
        require_once('model/User.php');
        require_once('model/UserManager.php');
        $user = new User();
        $userManager = new UserManager();
        $pseudo = utf8_decode($_POST['pseudo']);
        $user->setPseudo($pseudo);
        $result = $userManager->pseudoExists($user);
        return $result;
    }
    public static function createAccount(){
        require_once('model/User.php');
        require_once('model/UserManager.php');
        $user = new User();
        $userManager = new UserManager();
        $pseudo = utf8_decode($_POST['pseudo']);
        $password = utf8_decode($_POST['password']);
        $email = utf8_decode($_POST['email']);
        $user->setPseudo($pseudo);
        $user->setPassword($password);
        $user->setEmail($email);
        $user->setAdmin(false);
        $userManager->addUser($user);
        return $user;
    }
    public static function sendEmail(){
        $user = $_SESSION['user'];
        $to = $user->getEmail();
        $pseudo = ucfirst($user->getPseudo());
        $subject = 'Bienvenue dans mon blog !';
        $message = <<<EOD
        <p>Bienvenue $pseudo !<br/><br/>
        Merci de ton inscription à mon blog<br/></p>
        <img src="https://media1.tenor.com/images/b0321de1096222775688294decbd823e/tenor.gif?itemid=5183369" alt="Jake's Eyes Sparkling Gif"/>
EOD;
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        mail($to, $subject, $message, $headers);
    }
    public static function updateUser(){
        require_once('model/User.php');
        require_once('model/UserManager.php');
        $updatedUser = new User();
        $userManager = new UserManager();
        $pseudo = utf8_decode($_POST['pseudo']);
        $email = utf8_decode($_POST['email']);
        $updatedUser->setPseudo($pseudo);
        $updatedUser->setEmail($email);
        $userManager->updateUser($updatedUser);
        $user = $_SESSION['user'];
        $user->setPseudo($pseudo);
        $user->setEmail($email);
        return $user;
    }
    public static function updatePassword(){
        require_once('model/User.php');
        require_once('model/UserManager.php');
        $updatedUser = new User();
        $userManager = new UserManager();
        $password = utf8_decode($_POST['password']);
        $updatedUser->setPassword($password);
        $userManager->updateUser($updatedUser);
    }
}