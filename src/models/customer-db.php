<?php
function addUser($username, $password, $type, $fname, $lname)
{
    # Generate Hashed password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    global $db;
    $query = "INSERT INTO User(Username, Password, Type, FirstName, LastName) VALUES(:username, :password, :type, :fname, :lname)";
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->bindValue(':password', $hashedPassword);
    $statement->bindValue(':type', $type);
    $statement->bindValue(':fname', $fname);
    $statement->bindValue(':lname', $lname);
    $statement->execute();
    $statement->closeCursor();
}

function usernameTaken($username)
{
    global $db;
    $query = "SELECT * FROM User WHERE Username=:username";
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $users = $statement->fetch();
    $statement->closeCursor();
    if(empty($users)){
        return False;
    }
    return True;
}

function newUsernameTaken($username)
{
    global $db;
    $query = "SELECT * FROM User WHERE Username=:username";
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $users = $statement->fetch();
    $statement->closeCursor();
    if(!empty($users)){
        return $users;
    }
    return NULL;
}

function addCustomer($username, $street, $city, $state, $zip)
{
    global $db;
    $query1 = "SELECT UserID FROM User WHERE Username=:username";
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':username', $username);
    $statement1->execute();    
    $user = $statement1->fetch();
    $statement1->closeCursor();

    $query2 = "INSERT INTO Customer VALUES(:user_id, :street, :city, :state, :zip)";
    $statement2 = $db->prepare($query2);
    $statement2->bindValue(':user_id', $user["UserID"]);
    $statement2->bindValue(':street', $street);
    $statement2->bindValue(':city', $city);
    $statement2->bindValue(':state', $state);
    $statement2->bindValue(':zip', $zip);
    $statement2->execute();
    $statement2->closeCursor();
}

function addTechnician($username, $occupation_type)
{
    global $db;
    $query1 = "SELECT UserID FROM User WHERE Username=:username";
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':username', $username);
    $statement1->execute();    
    $user = $statement1->fetch();
    $statement1->closeCursor();

    $query2 = "INSERT INTO Technician(UserID, OccupationType) VALUES(:user_id, :occupation_type)";
    $statement2 = $db->prepare($query2);
    $statement2->bindValue(':user_id', $user["UserID"]);
    $statement2->bindValue(':occupation_type', $occupation_type);
    $statement2->execute();
    $statement2->closeCursor();
}

function updateUser($userid, $username, $fname, $lname)
{
    global $db;
    $query = "UPDATE User SET Username=:username, FirstName=:fname, LastName=:lname WHERE UserID=:userid";
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->bindValue(':fname', $fname);
    $statement->bindValue(':lname', $lname);
    $statement->bindValue(':userid', $userid);
    $statement->execute();
    $statement->closeCursor();
}

function updateCust($userid, $street, $city, $state, $zip)
{
    global $db;
    $query = "UPDATE Customer SET Street=:street, City=:city, State=:state, Zip=:zip WHERE UserID=:userid";
    $statement = $db->prepare($query);
    $statement->bindValue(':street', $street);
    $statement->bindValue(':city', $city);
    $statement->bindValue(':state', $state);
    $statement->bindValue(':zip', $zip);
    $statement->bindValue(':userid', $userid);
    $statement->execute();
    $statement->closeCursor();
}

function updateAdmin($userid, $street, $city, $state, $zip)
{
    global $db;
    $query = "UPDATE Administrator SET Street=:street, City=:city, State=:state, Zip=:zip WHERE UserID=:userid";
    $statement = $db->prepare($query);
    $statement->bindValue(':street', $street);
    $statement->bindValue(':city', $city);
    $statement->bindValue(':state', $state);
    $statement->bindValue(':zip', $zip);
    $statement->bindValue(':userid', $userid);
    $statement->execute();
    $statement->closeCursor();
}

function getCustAddressSep($user_id){
    global $db;
    $query1 = "SELECT Street, City, State, Zip
    FROM Customer
    WHERE UserID = :cust_id";
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':cust_id', $user_id);
    $statement1->execute();    
    $Address = $statement1->fetchAll();
    $statement1->closeCursor();
    return $Address[0];

}

function getAdminAddressSep($user_id){
    global $db;
    $query1 = "SELECT Street, City, State, Zip
    FROM Administrator
    WHERE UserID = :adminID";
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':adminID', $user_id);
    $statement1->execute();
    $Address = $statement1->fetchAll();
    $statement1->closeCursor();
    return $Address[0];
}

?>