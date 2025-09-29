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
    if($tech_id == "no"){ // NO TECH SELECTED 
        $query2 = "INSERT INTO Project(CustomerID, JobType, Description, StartDate, EndDate, Completed)
        VALUES(:cust_id, :jobtype, :description, :startdate, :enddate, 0)";
    }else{
    $query2 = "INSERT INTO Project(CustomerID, TechnicianID, JobType, Description, StartDate, EndDate, Completed)
     VALUES(:cust_id, :tech_id, :jobtype, :description, :startdate, :enddate, 0)";
    }
    $statement2 = $db->prepare($query2);
    $statement2->bindValue(':cust_id', $cust_id);
    if($tech_id != "no"){
        $statement2->bindValue(':tech_id', $tech_id);
    }
    $statement2->bindValue(':jobtype', $jobtype);
    $statement2->bindValue(':description', $description);
    $statement2->bindValue(':startdate', $startdate);
    $statement2->bindValue(':enddate', $enddate);
    $statement2->execute();
    $statement2->closeCursor();

    if($tech_id == "no"){ // NO TECH SELECTED 
        $query4 = "SELECT * FROM Project WHERE CustomerID = :cust_id AND JobType = :jobtype AND Description = :description";
    }else{
        $query4 = "SELECT * FROM Project WHERE CustomerID = :cust_id AND TechnicianID = :tech_id AND JobType = :jobtype AND Description = :description";
    }
    $statement4 = $db->prepare($query4);
    $statement4->bindValue(':cust_id', $cust_id);
    if($tech_id != "no"){
        $statement4->bindValue(':tech_id', $tech_id);
    }
    $statement4->bindValue(':jobtype', $jobtype);
    $statement4->bindValue(':description', $description);
    $statement4->execute();
    $projectResult = $statement4->fetchALL();
    $statement4->closeCursor();
    $projid = $projectResult[0]['ProjectID'];

    $query3 = "INSERT INTO Invoice(ProjectID) VALUES(:projid)";
    $statement3 = $db->prepare($query3);
    $statement3->bindValue(':projid', $projid);
    $statement3->execute();
    $statement3->closeCursor();

    // ADD DOWN PAYMENT OF 20
    addPaymentAdmin($projid, "credit", 20);
}

function postComment($projid, $userid, $comment)
{
    global $db;
    $currenttime = date('Y-m-d H:i');
    $query2 = "INSERT INTO Comment(UserID, DateTime, ProjectID, Text)
    VALUES(:userid, :currenttime, :projid, :text)";
    $statement2 = $db->prepare($query2);
    $statement2->bindValue(':userid', $userid);
    $statement2->bindValue(':projid', $projid);
    $statement2->bindValue(':text', $comment);
    $statement2->bindValue(':currenttime', $currenttime);
    $statement2->execute();
    $statement2->closeCursor();
}

function deleteComment($userid, $datetime)
{
    global $db;
    $query2 = "DELETE FROM Comment WHERE UserID=:userid AND DateTime=:datetime";
    $statement2 = $db->prepare($query2);
    $statement2->bindValue(':userid', $userid);
    $statement2->bindValue(':datetime', $datetime);
    $statement2->execute();
    $statement2->closeCursor();
}

?>