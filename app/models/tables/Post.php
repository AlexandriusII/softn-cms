<?php
/**
 * Post.php
 */

namespace SoftnCMS\models\tables;

use SoftnCMS\models\TableAbstract;

/**
 * Class Post
 * @author Nicolás Marulanda P.
 */
class Post extends TableAbstract {
    
    /** @var string */
    private $postTitle;
    
    /** @var int */
    private $postStatus;
    
    /** @var string */
    private $postDate;
    
    /** @var string */
    private $postUpdate;
    
    /** @var string */
    private $postContents;
    
    /** @var int */
    private $commentStatus;
    
    /** @var int */
    private $commentCount;
    
    /** @var int */
    private $userID;
    
    /**
     * @return string
     */
    public function getPostTitle() {
        return $this->postTitle;
    }
    
    /**
     * @param string $postTitle
     */
    public function setPostTitle($postTitle) {
        $this->postTitle = $postTitle;
    }
    
    /**
     * @return int
     */
    public function getPostStatus() {
        return $this->postStatus;
    }
    
    /**
     * @param int $postStatus
     */
    public function setPostStatus($postStatus) {
        $this->postStatus = $postStatus;
    }
    
    /**
     * @return string
     */
    public function getPostDate() {
        return $this->postDate;
    }
    
    /**
     * @param string $postDate
     */
    public function setPostDate($postDate) {
        $this->postDate = $postDate;
    }
    
    /**
     * @return string
     */
    public function getPostUpdate() {
        return $this->postUpdate;
    }
    
    /**
     * @param string $postUpdate
     */
    public function setPostUpdate($postUpdate) {
        $this->postUpdate = $postUpdate;
    }
    
    /**
     * @return string
     */
    public function getPostContents() {
        return $this->postContents;
    }
    
    /**
     * @param string $postContents
     */
    public function setPostContents($postContents) {
        $this->postContents = $postContents;
    }
    
    /**
     * @return int
     */
    public function getCommentStatus() {
        return $this->commentStatus;
    }
    
    /**
     * @param int $commentStatus
     */
    public function setCommentStatus($commentStatus) {
        $this->commentStatus = $commentStatus;
    }
    
    /**
     * @return int
     */
    public function getCommentCount() {
        return $this->commentCount;
    }
    
    /**
     * @param int $commentCount
     */
    public function setCommentCount($commentCount) {
        $this->commentCount = $commentCount;
    }
    
    /**
     * @return int
     */
    public function getUserID() {
        return $this->userID;
    }
    
    /**
     * @param int $userID
     */
    public function setUserID($userID) {
        $this->userID = $userID;
    }
    
}