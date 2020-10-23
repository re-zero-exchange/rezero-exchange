<?php
    class BookListingDAO{


        function getAllListingGenre()  #Works tgt with getAllBookListing()
        {
            $connManager = new ConnectionManager();
            $pdo = $connManager->getConnection();
            $sql = "select * from BOOK_GENRE";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $results = [];
            while ($row = $stmt->fetch()){
                $l_id = $row['l_id'];
                $genre = $row['genre'];
                $results[] = [$l_id, $genre];
            }
            $pdo = null;
            $stmt = null;
            return $results;
        }

        function getListingGenre($l_id)
        {
            $connManager = new ConnectionManager();
            $pdo = $connManager->getConnection();
            $sql = "select * from BOOK_GENRE WHERE l_id = :l_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":l_id", $l_id, PDO::PARAM_STR);
            $stmt->execute();
            $results = [];
            while ($row = $stmt->fetch()){
                $l_id = $row['l_id'];
                $genre = $row['genre'];
                $results[] = [$l_id, $genre];
            }
            $pdo = null;
            $stmt = null;
            return $results;
        }



        function getAllBookListing()  #Works with getAllListingGenre()
        {
            $connManager = new ConnectionManager();
            $pdo = $connManager->getConnection();
            $sql = "select * from book_listing";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $results = [];
            while ($row = $stmt->fetch()){
                $l_id = $row['l_id'];
                $ownerEmail = $row['owner_email'];
                $isbn = $row['isbn'];
                $bookTitle = $row['book_title'];  
                $itemDesc = $row['item_desc'];  
                $availability = $row['availability'];       
                
                $user = new BookListing($l_id, $ownerEmail, $bookTitle, $isbn, '' , $itemDesc, $availability);
                $results[] = $user;
            }
            $pdo = null;
            $stmt = null;
            return $results;
        }

        function getFinalAllBookListing()
        {
            $bookList = $this->getAllBookListing();
            $bookGenre = $this->getAllListingGenre();

            for($i = 0; $i < count($bookGenre); $i++)
            {
                for($z = 0; $z < count($bookList); $z ++)
                {
                    if($bookList[$z]->getLid() == $bookGenre[$i][0])
                    {
                        $genre = $bookList[$z]->getGenre();
                        if($genre != "")
                        {
                            $bookList[$z]->setGenre($genre . ", " . $bookGenre[$i][1]);
                        }
                        else
                        {
                            $bookList[$z]->setGenre($bookGenre[$i][1]);
                        }
                    }
                }
            }

            return $bookList;

        }

        function getListingByAuthor($author)
        {
            $connManager = new ConnectionManager();
            $pdo = $connManager->getConnection();
            $sql = "select * from book_listing where author = :author";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":author", $author, PDO::PARAM_STR);
            $stmt->execute();
            $results = [];
            while ($row = $stmt->fetch()){
                $l_id = $row['l_id'];
                $ownerEmail = $row['owner_email'];
                $isbn = $row['isbn'];
                $bookTitle = $row['book_title'];  
                $itemDesc = $row['item_desc'];  
                $availability = $row['availability'];       
                
                $book = new BookListing($l_id, $ownerEmail, $bookTitle, $isbn, '' , $itemDesc, $availability);
                $results[] = $book;


                for($z = 0; $z < count($results); $z++)
                {
                    $genre = $this->getListingGenre($results[$z]->getLid());
                    if($results[$z]->getGenre() == "")
                    {
                        $results[$z]->setGenre($genre);
                    }
                    else
                    {
                        $currGenre = $results[$z]->getGenre();
                        $results[$z]->setGenre($currGenre . ", " . $genre);
                    }
                }

            }
            $pdo = null;
            $stmt = null;
            return $results;
        }
        

        function getListingByOwner($email)
        {
            $connManager = new ConnectionManager();
            $pdo = $connManager->getConnection();
            $sql = "select * from book_listing where owner_email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->execute();
            $results = [];
            while ($row = $stmt->fetch()){
                $l_id = $row['l_id'];
                $ownerEmail = $row['owner_email'];
                $isbn = $row['isbn'];
                $bookTitle = $row['book_title'];  
                $itemDesc = $row['item_desc'];  
                $availability = $row['availability'];       
                
                $book = new BookListing($l_id, $ownerEmail, $bookTitle, $isbn, '' , $itemDesc, $availability);
                $results[] = $book;


                for($z = 0; $z < count($results); $z++)
                {
                    $genre = $this->getListingGenre($results[$z]->getLid());
                    if($results[$z]->getGenre() == "")
                    {
                        $results[$z]->setGenre($genre);
                    }
                    else
                    {
                        $currGenre = $results[$z]->getGenre();
                        $results[$z]->setGenre($currGenre . ", " . $genre);  #Bug not fixed yet but codes works, YOLO
                    }
                }

            }
            $pdo = null;
            $stmt = null;
            return $results;
        }


        function getListingByTitle($title)
        {
            $connManager = new ConnectionManager();
            $pdo = $connManager->getConnection();
            $sql = "select * from book_listing where book_title = :title";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":title", $title, PDO::PARAM_STR);
            $stmt->execute();
            $results = [];
            while ($row = $stmt->fetch()){
                $l_id = $row['l_id'];
                $ownerEmail = $row['owner_email'];
                $isbn = $row['isbn'];
                $bookTitle = $row['book_title'];  
                $itemDesc = $row['item_desc'];  
                $availability = $row['availability'];       
                
                $book = new BookListing($l_id, $ownerEmail, $bookTitle, $isbn, '' , $itemDesc, $availability);
                $results[] = $book;


                for($z = 0; $z < count($results); $z++)
                {
                    $genre = $this->getListingGenre($results[$z]->getLid());
                    if($results[$z]->getGenre() == "")
                    {
                        $results[$z]->setGenre($genre);
                    }
                    else
                    {
                        $currGenre = $results[$z]->getGenre();
                        $results[$z]->setGenre($currGenre . ", " . $genre);  #Bug not fixed yet but codes works, YOLO
                    }
                }

            }
            $pdo = null;
            $stmt = null;
            return $results;
        }

        function getListingByIsbn($isbn)
        {
            $connManager = new ConnectionManager();
            $pdo = $connManager->getConnection();
            $sql = "select * from book_listing where isbn = :isbn";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":isbn", $title, PDO::PARAM_STR);
            $stmt->execute();
            $results = [];
            while ($row = $stmt->fetch()){
                $l_id = $row['l_id'];
                $ownerEmail = $row['owner_email'];
                $isbn = $row['isbn'];
                $bookTitle = $row['book_title'];  
                $itemDesc = $row['item_desc'];  
                $availability = $row['availability'];       
                
                $book = new BookListing($l_id, $ownerEmail, $bookTitle, $isbn, '' , $itemDesc, $availability);
                $results[] = $book;


                for($z = 0; $z < count($results); $z++)
                {
                    $genre = $this->getListingGenre($results[$z]->getLid());
                    if($results[$z]->getGenre() == "")
                    {
                        $results[$z]->setGenre($genre);
                    }
                    else
                    {
                        $currGenre = $results[$z]->getGenre();
                        $results[$z]->setGenre($currGenre . ", " . $genre);  #Bug not fixed yet but codes works, YOLO
                    }
                }

            }
            $pdo = null;
            $stmt = null;
            return $results;
        }



    }//end of class




?>