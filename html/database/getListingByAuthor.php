<?php
    
    require_once "common.php";

    $dao  = new BookListingDAO();
    $searching = $_GET["author"];
    //var_dump($searching);
    $result = $dao->getListingByAuthor($searching);
    $searched_books = [];
    for($i = 0; $i < count($result); $i++)
    {
        //$result[$i]->getTitle();
        $temp_Lid = $result[$i]->getLid();
        array_push($searched_books,$temp_Lid);

    }
    //var_dump($searched_books);
    echo json_encode($searched_books);
    // header("Location:http://localhost/216/ReZERO%20project/rezero-exchange/html/testHome2.html");
    // exit();
    //var_dump($searched_books);
?>