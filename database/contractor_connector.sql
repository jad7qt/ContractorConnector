CREATE DATABASE IF NOT EXISTS ContractorConnector;
USE ContractorConnector;

CREATE TABLE User(
  UserID INT AUTO_INCREMENT PRIMARY KEY,
  Username VARCHAR(25) NOT NULL UNIQUE,
  Password VARCHAR(255) NOT NULL,
  Type ENUM('Administrator', 'Technician', 'Customer') NOT NULL,
  FirstName VARCHAR(25),
  LastName VARCHAR(25)
);

CREATE TABLE Administrator (
  UserID INT PRIMARY KEY,
  Street VARCHAR(100),
  City VARCHAR(25),
  State VARCHAR(25),
  Zip VARCHAR(10),
  FOREIGN KEY (UserID) REFERENCES User(UserID) ON DELETE CASCADE
);

CREATE TABLE Technician (
  UserID INT PRIMARY KEY,
  OccupationType VARCHAR(50),
  FOREIGN KEY (UserID) REFERENCES User(UserID) ON DELETE CASCADE
);

CREATE TABLE Customer (
  UserID INT PRIMARY KEY,
  Street VARCHAR(100),
  City VARCHAR(50),
  State VARCHAR(50),
  Zip VARCHAR(10),
  FOREIGN KEY (UserID) REFERENCES User(UserID) ON DELETE CASCADE
);

CREATE TABLE Ratings (
  CustomerID INT,
  TechnicianID INT,
  Rating INT CHECK (Rating BETWEEN 0 AND 5),
  Comment TEXT,
  FOREIGN KEY (CustomerID) REFERENCES Customer(UserID) ON DELETE CASCADE,
  FOREIGN KEY (TechnicianID) REFERENCES Technician(UserID) ON DELETE CASCADE,
  PRIMARY KEY (CustomerID, TechnicianID)
);

CREATE TABLE Project (
  ProjectID INT AUTO_INCREMENT PRIMARY KEY,
  CustomerID INT NOT NULL,
  TechnicianID INT,
  JobType VARCHAR(50),
  Description TEXT,
  StartDate DATE,
  EndDate DATE,
  Completed BOOLEAN DEFAULT FALSE,
  FOREIGN KEY (CustomerID) REFERENCES Customer(UserID) ON DELETE CASCADE,
  FOREIGN KEY (TechnicianID) REFERENCES Technician(UserID) ON DELETE CASCADE
);

CREATE TABLE Invoice (
  ProjectID INT PRIMARY KEY,
  TotalPrice DECIMAL(10,2),
  FOREIGN KEY (ProjectID) REFERENCES Project(ProjectID) ON DELETE CASCADE
);

CREATE TABLE Comment (
  CommentID INT AUTO_INCREMENT PRIMARY KEY,
  UserID INT NOT NULL,
  ProjectID INT NOT NULL,
  CommentTime DATETIME,
  Text TEXT,
  FOREIGN KEY (UserID) REFERENCES User(UserID) ON DELETE CASCADE,
  FOREIGN KEY (ProjectID) REFERENCES Project(ProjectID) ON DELETE CASCADE
);

CREATE TABLE Payment (
  PaymentID INT AUTO_INCREMENT PRIMARY KEY,
  ProjectID INT,
  Type VARCHAR(50),
  Amount DECIMAL(10,2),
  PaymentDate DATE,
  FOREIGN KEY (ProjectID) REFERENCES Project(ProjectID) ON DELETE CASCADE
);

CREATE TABLE PhoneNumber (
  UserID INT,
  Type VARCHAR(20),
  Number VARCHAR(15),
  FOREIGN KEY (UserID) REFERENCES User(UserID) ON DELETE CASCADE,
  PRIMARY KEY (UserID, Type)
);

-- Sample Project Data

INSERT INTO User (Username, Password, Type, FirstName, LastName) VALUES
('admin_test', '$2y$10$kFcGWMVm91r5PoW8fVLn4elo0IpzrWkn3yDpzpIZyaq18Z/E.AuCy', 'Administrator', 'Alice', 'Admin'),
('tech_test', '$2y$10$kFcGWMVm91r5PoW8fVLn4elo0IpzrWkn3yDpzpIZyaq18Z/E.AuCy', 'Technician', 'Bob', 'Builder'),
('cust_test', '$2y$10$kFcGWMVm91r5PoW8fVLn4elo0IpzrWkn3yDpzpIZyaq18Z/E.AuCy', 'Customer', 'Carol', 'Client');

INSERT INTO Administrator (UserID, Street, City, State, Zip)
SELECT UserID, '10th Admin Rd.', 'Charlottesville', 'VA', '22901'
FROM User
WHERE Username = 'admin_test';

INSERT INTO Technician (UserID, OccupationType)
SELECT UserID, 'Electrician'
FROM User
WHERE Username = 'tech_test';

INSERT INTO Customer (UserID, Street, City, State, Zip)
SELECT UserID, '104 Customer St.', 'Harrisonburg', 'VA', '22801'
FROM User
WHERE Username = 'cust_test';

INSERT INTO PhoneNumber (UserID, Type, Number)
SELECT UserID, 'Mobile', '800-588-2300'
FROM User
WHERE Username = 'tech_test';