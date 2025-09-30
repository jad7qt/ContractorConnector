<?php
require('payments-db.php');

function selectAllTechs()
{
    global $db;
    $query2 = "SELECT * FROM Technician NATURAL JOIN User ORDER BY FirstName";
    $statement2 = $db->prepare($query2);
    $statement2->execute();    
    $techs = $statement2->fetchAll();
    $statement2->closeCursor();
    return $techs;
}

function newProject($cust_id, $tech_id, $jobtype, $description, $startdate, $enddate)
{
    global $db;
    if($tech_id == "NONE"){ // NO TECH SELECTED 
        $query1 = "INSERT INTO Project(CustomerID, JobType, Description, StartDate, EndDate, Completed)
        VALUES(:cust_id, :jobtype, :description, :startdate, :enddate, 0)";
    }else{
        $query1 = "INSERT INTO Project(CustomerID, TechnicianID, JobType, Description, StartDate, EndDate, Completed)
        VALUES(:cust_id, :tech_id, :jobtype, :description, :startdate, :enddate, 0)";
    }
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':cust_id', $cust_id);
    if($tech_id != "NONE"){
        $statement1->bindValue(':tech_id', $tech_id);
    }
    $statement1->bindValue(':jobtype', $jobtype);
    $statement1->bindValue(':description', $description);
    $statement1->bindValue(':startdate', $startdate);
    $statement1->bindValue(':enddate', $enddate);
    $statement1->execute();
    $proj_id = $db->lastInsertId(); // Get project ID of newly created project
    $statement1->closeCursor();


    $query2 = "INSERT INTO Invoice(ProjectID) VALUES(:proj_id)";
    $statement2 = $db->prepare($query2);
    $statement2->bindValue(':proj_id', $proj_id);
    $statement2->execute();
    $statement2->closeCursor();

    // ADD DOWN PAYMENT OF 20
    addPaymentAdmin($proj_id, "credit", 20);
}

function postComment($projid, $userid, $comment)
{
    global $db;
    $currenttime = date('Y-m-d H:i');
    $query2 = "INSERT INTO Comment(UserID, CommentTime, ProjectID, Text)
    VALUES(:userid, :currenttime, :projid, :text)";
    $statement2 = $db->prepare($query2);
    $statement2->bindValue(':userid', $userid);
    $statement2->bindValue(':projid', $projid);
    $statement2->bindValue(':text', $comment);
    $statement2->bindValue(':currenttime', $currenttime);
    $statement2->execute();
    $statement2->closeCursor();
}

function deleteComment($commentid) {
    global $db;
    $query = "DELETE FROM Comment WHERE CommentID=:commentid";
    $statement = $db->prepare($query);
    $statement->bindValue(':commentid', $commentid);
    $statement->execute();
    $statement->closeCursor();
}

?>