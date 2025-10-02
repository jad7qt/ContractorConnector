<?php 

function rateTech($cust_id, $tech_id, $rating, $comment)
{
    global $db;
    $query1 = "INSERT INTO Ratings VALUES (:custid, :techid, :rating, :comment)";
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':custid', $cust_id);
    $statement1->bindValue(':techid', $tech_id);
    $statement1->bindValue(':rating', $rating);
    $statement1->bindValue(':comment', $comment);
    $statement1->execute();    
    $statement1->closeCursor();
}

function updateRateTech($cust_id, $tech_id, $rating, $comment)
{
    global $db;
    $query1 = "UPDATE Ratings SET Rating = :rating, Comment=:comment WHERE CustomerID = :custid AND TechnicianID = :techid";
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':custid', $cust_id);
    $statement1->bindValue(':techid', $tech_id);
    $statement1->bindValue(':rating', $rating);
    $statement1->bindValue(':comment', $comment);
    $statement1->execute();    
    $statement1->closeCursor();
}

function deleteRateTech($cust_id, $tech_id)
{
    global $db;
    $query1 = "DELETE FROM Ratings WHERE CustomerID = :custid AND TechnicianID = :techid";
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':custid', $cust_id);
    $statement1->bindValue(':techid', $tech_id);
    $statement1->execute();
    $statement1->closeCursor();
}

?>