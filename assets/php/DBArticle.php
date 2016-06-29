<?php
    include_once('ArticleParser.php');
    include_once('PagePrimitives.php');
/**
 * Created by PhpStorm.
 * User: Ian Murphy
 * Date: 6/17/2016
 * Time: 2:45 PM
 */
class DBArticle
{
    private $_connection;
    private $_articleCache;
    private $_cachedSortType = -1;
    private $_errno;
    public function __construct()
    {
        $this->_connection = new PDO('mysql:host=localhost;dbname=isogen', 'isogen', '');
        date_default_timezone_set('America/Los_Angeles');
    }



    public function addArticle($articleShort, $loud = false){
        $statement = $this->_connection->prepare("SELECT short_name FROM iso_articles WHERE short_name=:sname;");
        $statement->bindParam(':sname', $articleShort);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        /** If Article Exists End Function Here */
        if(count($results) > 0){
            $this->_errno = 'Attempted to add already existing article to database.';
            return false;
        }

        $sql = "INSERT INTO iso_articles (heading, subheading, image, author, date, path, short_name) VALUES(:head, :sub, :image, :author, :date, :path, :sname);";
        $statement = $this->_connection->prepare($sql);
        $article = ArticleParser($articleShort);
        if($article == false){
            $this->_errno = 'Article with short name "' . $articleShort . '" could not be found.';

            return false;
        }
        $statement->bindParam(':head', $article['h1']);
        $statement->bindParam(':sub', $article['h2']);
        $statement->bindParam(':image', $article['header_image']);
        $statement->bindParam(':author', $article['author']);
        $date = date('Y-m-d', strtotime($article['date']));
        $statement->bindParam(':date', $date);
        $path = '/articles/' . $articleShort;
        $statement->bindParam(':path', $path);
        $statement->bindParam(':sname', $articleShort);
        if(!$statement->execute()){
            $this->_errno = 'Execution of prepared statement has failed';
            return $err_msg;
        }
        else{
            $this->_errno = 'Article Added Successfully';
            return true;
        }
    }
    
    public function getAllArticles(){
        $start = microtime(true);
        $result = $this->_connection->query("SELECT * FROM iso_articles;");
        $this->_articleCache = $result->fetchAll(PDO::FETCH_ASSOC);
        $end = microtime(true);
        return $this->_articleCache;
    }

    public function getAllArticlesByDate($order){
        $order == DBArticle::ASCENDING ? $dir = 'ASC' : $dir = 'DESC';
        if($this->_cachedSortType !== $dir){
            $result = $this->_connection->query("SELECT * FROM iso_articles ORDER BY date " . $dir . ";");
            $this->_articleCache = $result->fetchAll(PDO::FETCH_ASSOC);
            $this->_cachedSortType = $dir;
        }
        return $this->_articleCache;
    }

    public function getArticlesByAuthor($author){
        try{

            $sql = "SELECT * FROM iso_articles WHERE author=:author;";
            $statement = $this->_connection->prepare($sql);
            $statement->bindParam(':author', $author);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e){
            return $e;
        }

    }

    public function getFeaturedArticle(){
        if($this->_cachedSortType == -1) $this->getAllArticles();

        foreach ($this->_articleCache as $article){
            if($article['featured']) return $article;
        }
        $this->_errno = 'Error: No featured article set';
        return false;
    }

    public function getError(){
        return $this->_errno;
    }

    const ASCENDING = 0;
    const DESCENDING = 1;
}

