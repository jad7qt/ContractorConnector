<?php

function admin_payments()
{
    global $db;
    $stmt = $db->prepare("SELECT CONCAT(User.firstName, ' ', User.lastName) as Customer_Name, Project.JobType, 
    Project.EndDate, FORMAT((Invoice.TotalPrice - TP.Total_Payment), 'C') as Remaining_Payment, Project.ProjectID
    FROM Invoice
    INNER JOIN 
        (SELECT Payment.ProjectID, SUM(Payment.Amount) as Total_Payment
        FROM Payment
        GROUP BY Payment.ProjectID
        ORDER BY ProjectID) as TP
    ON Invoice.ProjectID = TP.ProjectID
    INNER JOIN Project
    ON Project.ProjectID = Invoice.ProjectID
    INNER JOIN User
    ON Project.CustomerID = User.UserID
    HAVING Remaining_Payment > 0
	ORDER BY Project.EndDate");
    $stmt->execute();
    $result = $stmt->fetchAll();
    $stmt->closeCursor();
    return $result;
}

function tech_payments($UserID){
    global $db;
    $stmt = $db->prepare("SELECT CONCAT(User.firstName, ' ', User.lastName) as Customer_Name, Project.JobType, 
    Project.EndDate, FORMAT((Invoice.TotalPrice - TP.Total_Payment), 'C') as Remaining_Payment
    FROM Invoice
    INNER JOIN 
        (SELECT Payment.ProjectID, SUM(Payment.Amount) as Total_Payment
        FROM Payment
        GROUP BY Payment.ProjectID
        ORDER BY ProjectID) as TP
    ON Invoice.ProjectID = TP.ProjectID
    INNER JOIN Project
    ON Project.ProjectID = Invoice.ProjectID
    INNER JOIN User
    ON Project.CustomerID = User.UserID
    WHERE Project.TechnicianID = :UserID
    HAVING Remaining_Payment > 0
	ORDER BY Project.EndDate");
    $stmt->bindValue(':UserID', $UserID);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $stmt->closeCursor();
    return $result;
}

function cust_payments($UserID){
    global $db;
    $stmt = $db->prepare("SELECT CONCAT(User.firstName, ' ', User.lastName) as Customer_Name, Project.JobType, 
    Project.EndDate, FORMAT((Invoice.TotalPrice - TP.Total_Payment), 'C') as Remaining_Payment, Project.ProjectID
    FROM Invoice
    INNER JOIN 
        (SELECT Payment.ProjectID, SUM(Payment.Amount) as Total_Payment
        FROM Payment
        GROUP BY Payment.ProjectID
        ORDER BY ProjectID) as TP
    ON Invoice.ProjectID = TP.ProjectID
    INNER JOIN Project
    ON Project.ProjectID = Invoice.ProjectID
    INNER JOIN User
    ON Project.CustomerID = User.UserID
    WHERE Project.CustomerID = :UserID
    HAVING Remaining_Payment > 0
	ORDER BY Project.EndDate");
    $stmt->bindValue(':UserID', $UserID);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $stmt->closeCursor();
    return $result;
}

function getPrevPayments($UserID){
    global $db;
    $stmt = $db->prepare("SELECT FORMAT(Payment.Amount, 'C') as Amount, Payment.Type, Payment.PaymentID,
    Payment.PaymentDate, Project.JobType, Project.CustomerID
    FROM Payment
    INNER JOIN Project
    ON Payment.ProjectID = Project.ProjectID
    WHERE Project.CustomerID = :UserID;");

    $stmt->bindValue(':UserID', $UserID);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $stmt->closeCursor();
    return $result;
}

function addPaymentAdmin($proj_id, $type, $amount)
{
    global $db;
    $current_date = date('Y-m-d');

    $query = "INSERT INTO Payment(ProjectID, Type, Amount, PaymentDate) VALUES(:proj_id, :type, :amount, :payment_date)";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':proj_id', $proj_id);
    $stmt->bindValue(':type', $type);
    $stmt->bindValue(':amount', $amount);
    $stmt->bindValue(':payment_date', $current_date);
    $stmt->execute();
    $stmt->closeCursor();
}

function getNoInvoices(){
    global $db;
    $stmt = $db->prepare("SELECT CONCAT(User.FirstName, ' ', User.LastName) as Customer_Name,
    Project.JobType, Project.StartDate, Project.EndDate, Invoice.ProjectID, Invoice.TotalPrice
    FROM Project
    INNER JOIN Invoice
    ON Invoice.ProjectID = Project.ProjectID
    INNER JOIN User
    ON User.UserID = Project.CustomerID
    WHERE Invoice.TotalPrice IS NULL");

    $stmt->execute();
    $result = $stmt->fetchAll();
    $stmt->closeCursor();
    return $result;
}

function getTechInvoices($techID){
    global $db;
    $stmt = $db->prepare("SELECT CONCAT(User.FirstName, ' ', User.LastName) as Customer_Name,
    Project.JobType, Project.StartDate, Project.EndDate, Invoice.ProjectID, Invoice.TotalPrice
    FROM Project
    INNER JOIN Invoice
    ON Invoice.ProjectID = Project.ProjectID
    INNER JOIN User
    ON User.UserID = Project.CustomerID
    WHERE Invoice.TotalPrice IS NULL and Project.TechnicianID = :techID");

    $stmt->bindValue(':techID', $techID);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $stmt->closeCursor();
    return $result;
}

?>