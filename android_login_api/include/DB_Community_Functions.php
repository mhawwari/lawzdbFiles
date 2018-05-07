<?php
/**
 * post and comments php/Mysql interaction functions
 * User: Mohammad Hawwari
 * Date: 4/4/2018
 * Time: 6:29 PM
 */

class DB_Community_Functions {

    private $conn;

    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }

    // destructor
    function __destruct() {

    }

    /**
     * add a new post. true if success
     * @param $title
     * @param $content
     * @param $user_id
     * @param $topic
     * @param $image
     * @return bool
     */
    public function addPost($title, $content, $user_id, $topic, $image) {
        $stmt = $this->conn->prepare("INSERT INTO post(title, content, user_id, topic, image, create_date) VALUES(?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("sssss", $title, $content, $user_id, $topic);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful store
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * edit post's title, content and topic
     * @param $id
     * @param $title
     * @param $content
     * @param $topic
     * @return bool
     */
    public function editPost($id, $title, $content, $topic) {
        $stmt = $this->conn->prepare("UPDATE post SET title = ?, content = ?, topic = ?, modify_date = NOW() WHERE post_id = ?");
        $stmt->bind_param("ssii", $title, $content, $topic, $id);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful store
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * delete a post by it's id
     * @param $id
     * @return bool
     */
    public function deletePost($id) {
        $stmt = $this->conn->prepare("DELETE FROM post WHERE post_id = ?");
        $stmt->bind_param("i",$id);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful store
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * return all posts
     * @return array|null
     */
    public function getPosts() {
        $posts = array();
        $stmt = $this->conn->prepare("SELECT post.*, user.first_name, user.last_name FROM post INNER JOIN user ON post.user_id = user.user_id");

        if ($stmt->execute()) {
		$result = $stmt->get_result();
            while ($r = mysqli_fetch_assoc($result)){          
		$posts[] = $r;
            }
            $stmt->close();
            return $posts;
        }
        else {
            return NULL;
        }
    }

    /**
     * return post by the id from db
     * @param $id
     * @return array|null
     */
    public function getPostById($id) {

        $stmt = $this->conn->prepare("SELECT post.*, user.first_name, user.last_name FROM post INNER JOIN user ON post.user_id = user.user_id WHERE post_id = ?");
        $stmt->bind_param("s", $id);

        if ($stmt->execute()) {
            $post = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $post;
        } else {
            return NULL;
        }
    }

    /**
     * return a posts by their topics
     * @param $topic
     * @return array|null
     */
    public function getPostByTopic($topic) {
        $posts = array();
        $stmt = $this->conn->prepare("SELECT post.*, user.first_name, user.last_name FROM post INNER JOIN user ON post.user_id = user.user_id WHERE topic = ?");
        $stmt->bind_param("s", $topic);

        if ($stmt->execute()) {
		$result = $stmt->get_result();
            while ($r = mysqli_fetch_assoc($result)){          
		$posts[] = $r;
            }
            $stmt->close();
            return $posts;
        }
        else {
            return NULL;
        }
    }

    /** get posts by user id
     * @param $user_id
     * @return array|null
     */
    public function getPostByUser($user_id) {
        $posts = array();
        $stmt = $this->conn->prepare("SELECT * FROM post WHERE user_id = ?");
        $stmt->bind_param("s", $user_id);

        if ($stmt->execute()) {
            while ($r = $stmt->get_result()->fetch_assoc()){
                $posts[] = $r;
            }
            $stmt->close();
            return $posts;
        }
        else {
            return NULL;
        }
    }

    /**
     * return all posts
     * @param $search_text
     * @return array|null
     */
    public function SearchPosts($search_text) {
        $posts = array();
        $stmt = $this->conn->prepare("SELECT * FROM post WHERE content like ? or title like ?");
        $stmt->bind_param("ss", $search_text, $search_text);

        if ($stmt->execute()) {
            while ($r = $stmt->get_result()->fetch_assoc()){
                $posts[] = $r;
            }
            $stmt->close();
            return $posts;
        }
        else {
            return NULL;
        }
    }
    /*--------------------------------------------------------------------------------
     * -------------------------- Comment Operations ---------------------------------
    ---------------------------------------------------------------------------------*/

    /** Add a new comment
     * @param $content
     * @param $userid
     * @param $postid
     * @return bool
     */
    public function addComment($content, $userid, $postid) {
        $stmt = $this->conn->prepare("INSERT INTO comment(content, user_id, post_id, create_date) VALUES(?, ?, ?, NOW())");
        $stmt->bind_param("sss", $content, $userid, $postid);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful store
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /** edit comment content
     * @param $id
     * @param $content
     * @return bool
     */
    public function editComment($id, $content) {
        $stmt = $this->conn->prepare("UPDATE comment SET content = ?, modify_date = NOW() WHERE comment_id = ?");
        $stmt->bind_param("ss", $content, $id);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful store
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /** delete a comment by id
     * @param $id
     * @return bool
     */
    public function deleteComment($id) {
        $stmt = $this->conn->prepare("DELETE FROM comment WHERE comment_id = ?");
        $stmt->bind_param("s",$id);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful deletion
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /** return list of comments to a post
     * @param $post_id
     * @return array|null
     */
    public function getCommentByPost($post_id) {
        $comments = array();
        $stmt = $this->conn->prepare("SELECT * FROM comment WHERE post_id = ?");
        $stmt->bind_param("s", $post_id);

        if ($stmt->execute()) {
            while ($r = $stmt->get_result()->fetch_assoc()){
                $comments[] = $r;
            }
            $stmt->close();
            return $comments;
        }
        else {
            return NULL;
        }
    }

    /** get a comment by user id
     * @param $userid
     * @return array|null
     */
    public function getCommentByUser($userid) { // might not be needed
        $comments = array();
        $stmt = $this->conn->prepare("SELECT * FROM comment WHERE user_id = ? ");
        $stmt->bind_param("s",$userid);

        if ($stmt->execute()) {
            while ($r = $stmt->get_result()->fetch_assoc()){
                $comments[] = $r;
            }
            $stmt->close();
            return $comments;
        }
        else {
            return NULL;
        }
    }

    /** get a comment by its id
     * @param $id
     * @return array|null
     */
    public function getCommentById($id) {
        // this function might not be needed
        $stmt = $this->conn->prepare("SELECT * FROM comment WHERE comment_id = ?");
        $stmt->bind_param("s", $id);

        if ($stmt->execute()) {
            $comment = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $comment;
        } else {
            return NULL;
        }
    }

}
