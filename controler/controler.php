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
    public static function getPost($idPost){
        require_once('model/PostManager.php');
        $postManager = new PostManager();
        $post = $postManager->getPost($idPost);
        return $post;
    }
    public static function idPostExists($idPost){
        require_once('model/PostManager.php');
        $postManager = new PostManager();
        $result = $postManager->idPostExists($idPost);
        return $result;
    }
    public static function addPost($data){
        require_once('model/Post.php');
        require_once('model/PostManager.php');
        $postManager = new PostManager();
        $post = new Post($data);
        $newPost = $postManager->addPost($post);
        return $newPost;
    }
    public static function updatePost($data){
        require_once('model/Post.php');
        require_once('model/PostManager.php');
        $postManager = new PostManager();
        $post = new Post($data);
        $postManager->updatePost($post);
        return $post;
    }
    public static function deletePost($idPost){
        require_once('model/PostManager.php');
        $postManager = new PostManager();
        $postManager->deletePost($idPost);
    }
    public static function getComments($idPost){
        require_once('model/CommentManager.php');
        $commentManager = new CommentManager();
        $comments = $commentManager->getComments($idPost);
        return $comments;
    }
    public static function addComment($idPost, $content){
        require_once('model/Comment.php');
        require_once('model/CommentManager.php');
        $commentManager = new CommentManager();
        if(isset($_SESSION['user'])){
            $user = $_SESSION['user'];
            $author = $user->getPseudo();
        }else{
            $author = 'anonyme';
        }
        $data = [
            'idPost' => $idPost,
            'author' => $author,
            'content' => $content
        ];
        $comment = new Comment($data);
        $commentManager->addComment($comment);
    }
    public static function getReportedComments(){
        require_once('model/ReportedCommentManager.php');
        $reportedCommentManager = new ReportedCommentManager();
        $reportedComments = $reportedCommentManager->getReportedComments();
        return $reportedComments;
    }
    public static function reportComment($idComment, $idPost){
        require_once('model/ReportedCommentManager.php');
        $reportedCommentManager = new ReportedCommentManager();
        $reportedCommentManager->reportComment($idComment, $idPost);
    }
    public static function deleteComment($idComment){
        require_once('model/CommentManager.php');
        require_once('model/ReportedCommentManager.php');
        $commentManager = new CommentManager();
        $reportedCommentManager = new ReportedCommentManager();
        $commentManager->deleteComment($idComment);
        $reportedCommentManager->deleteReportedComment($idComment);
    }
    public static function login($data){
        require_once('model/User.php');
        require_once('model/UserManager.php');
        $userManager = new UserManager();
        $user = new User($data);
        $result = $userManager->login($user);
        return $result;
    }
    public static function pseudoExists($pseudo){
        require_once('model/User.php');
        require_once('model/UserManager.php');
        $userManager = new UserManager();
        $data = [
            'pseudo' => $pseudo
        ];
        $user = new User($data);
        $result = $userManager->pseudoExists($user);
        return $result;
    }
    public static function createAccount($data){
        require_once('model/User.php');
        require_once('model/UserManager.php');
        $userManager = new UserManager();
        $user = new User($data);
        $newUser = $userManager->addUser($user);
        return $newUser;
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
    public static function updateUser($data){
        require_once('model/User.php');
        require_once('model/UserManager.php');
        $userManager = new UserManager();
        $updatedUser = new User($data);
        $user = $userManager->updateUser($updatedUser);
        return $user;
    }
    public static function updatePassword($data){
        require_once('model/User.php');
        require_once('model/UserManager.php');
        $userManager = new UserManager();
        $updatedUser = new User($data);
        $user = $userManager->updateUser($updatedUser);
        return $user;
    }
}