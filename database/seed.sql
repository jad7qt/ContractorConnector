INSERT INTO User (Username, Password, Type, FirstName, LastName) VALUES
('admin_test', '$2y$10$kFcGWMVm91r5PoW8fVLn4elo0IpzrWkn3yDpzpIZyaq18Z/E.AuCy', 'Administrator', 'Alice', 'Admin'),
('tech1_test', '$2y$10$kFcGWMVm91r5PoW8fVLn4elo0IpzrWkn3yDpzpIZyaq18Z/E.AuCy', 'Technician', 'Bob', 'Builder'),
('tech2_test', '$2y$10$kFcGWMVm91r5PoW8fVLn4elo0IpzrWkn3yDpzpIZyaq18Z/E.AuCy', 'Technician', 'Tim', 'ToolMan'),
('cust_test', '$2y$10$kFcGWMVm91r5PoW8fVLn4elo0IpzrWkn3yDpzpIZyaq18Z/E.AuCy', 'Customer', 'Carol', 'Client');

INSERT INTO Administrator (UserID, Street, City, State, Zip)
SELECT UserID, '10th Admin Rd.', 'Charlottesville', 'VA', '22901'
FROM User
WHERE Username = 'admin_test';

INSERT INTO Technician (UserID, OccupationType)
SELECT UserID, 'Electrician'
FROM User
WHERE Username = 'tech1_test';

INSERT INTO Technician (UserID, OccupationType)
SELECT UserID, 'General Contractor'
FROM User
WHERE Username = 'tech2_test';

INSERT INTO Customer (UserID, Street, City, State, Zip)
SELECT UserID, '104 Customer St.', 'Harrisonburg', 'VA', '22801'
FROM User
WHERE Username = 'cust_test';

INSERT INTO PhoneNumber (UserID, Type, Number)
SELECT UserID, 'Mobile', '800-588-2300'
FROM User
WHERE Username = 'tech1_test';

INSERT INTO Project (CustomerID, TechnicianID, JobType, Description, StartDate, EndDate, Completed)
SELECT
    (SELECT UserID FROM User WHERE Username = 'cust_test'),
    (SELECT UserID FROM User WHERE Username = 'tech1_test'),
    'Electrical',
    'Install new lighting fixtures in the living room.',
    '2024-10-01',
    '2024-10-03',
    TRUE;

INSERT INTO Project (CustomerID, TechnicianID, JobType, Description, StartDate, EndDate, Completed)
SELECT
    (SELECT UserID FROM User WHERE Username = 'cust_test'),
    (SELECT UserID FROM User WHERE Username = 'tech2_test'),
    'Carpentry',
    'Build outdoor patio deck.',
    '2025-10-01',
    '2025-11-03',
    FALSE;

INSERT INTO Invoice (ProjectID, TotalPrice)
SELECT
    (SELECT ProjectID FROM Project WHERE Description = 'Install new lighting fixtures in the living room.'),
    500.00;

INSERT INTO Payment (ProjectID, Type, Amount, PaymentDate)
SELECT
    (SELECT ProjectID FROM Project WHERE Description = 'Install new lighting fixtures in the living room.'),
    'Credit Card',
    450.00,
    '2024-10-04';