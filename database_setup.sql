-- Optional: create database
-- CREATE DATABASE creatables
-- USE creatables

-- Drop existing tables
DROP TABLE IF EXISTS CompletesProject;
DROP TABLE IF EXISTS Contains;
DROP TABLE IF EXISTS Equipment_NeedsTools;
DROP TABLE IF EXISTS PurchaseLink_Name;
DROP TABLE IF EXISTS ProjectWishlist_Creates;
DROP TABLE IF EXISTS Message_Sends;
DROP TABLE IF EXISTS Feedback_LeavesFeedback;
DROP TABLE IF EXISTS Images_ContainsImages;
DROP TABLE IF EXISTS Materials_MadeWith;
DROP TABLE IF EXISTS Projects_PostsProject;
DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS City_Timezones;

-- Create tables
CREATE TABLE City_Timezones (
    City VARCHAR(40) PRIMARY KEY,
    Timezone INTEGER
);
CREATE TABLE Users (
    Username VARCHAR(40) PRIMARY KEY,
    PasswordHash CHAR(32) NOT NULL,
    JoinDate DATE DEFAULT (CURDATE()),
    City VARCHAR(40),
    FOREIGN KEY (City) REFERENCES City_Timezones(City)
);
CREATE TABLE Projects_PostsProject (
    PID INTEGER PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(60) NOT NULL,
    InstructionText VARCHAR(2500),
    Timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    Username VARCHAR(40) NOT NULL,
    FOREIGN KEY (Username) REFERENCES Users(Username)
        ON DELETE CASCADE
);
CREATE TABLE Images_ContainsImages (
    GalleryIndex INTEGER,
    ImageData MEDIUMBLOB NOT NULL,
    Caption VARCHAR(100),
    PID INTEGER,
    PRIMARY KEY (GalleryIndex, PID),
    FOREIGN KEY (PID) REFERENCES Projects_PostsProject(PID)
        ON DELETE CASCADE
);
CREATE TABLE Feedback_LeavesFeedback (
    FBID INTEGER PRIMARY KEY AUTO_INCREMENT,
    Title VARCHAR(60),
    Stars TINYINT,
    Comment VARCHAR(500),
    ImageData MEDIUMBLOB,
    Timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    Username VARCHAR(40) NOT NULL,
    PID INTEGER NOT NULL,
    FOREIGN KEY (Username) REFERENCES Users(Username)
        ON DELETE CASCADE,
    FOREIGN KEY (PID) REFERENCES Projects_PostsProject(PID)
        ON DELETE CASCADE
);
CREATE TABLE Message_Sends (
    MSID INTEGER PRIMARY KEY AUTO_INCREMENT,
    Text VARCHAR(1000) NOT NULL,
    Timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    SenderUsername VARCHAR(40) NOT NULL,
    ReceiverUsername VARCHAR(40) NOT NULL,
    FOREIGN KEY (SenderUsername) REFERENCES Users(Username)
        ON DELETE CASCADE,
    FOREIGN KEY (ReceiverUsername) REFERENCES Users(Username)
        ON DELETE CASCADE
);
CREATE TABLE ProjectWishlist_Creates (
    WLID INTEGER PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(60) NOT NULL,
    Username VARCHAR(40) NOT NULL,
    FOREIGN KEY (Username) REFERENCES Users(Username)
        ON DELETE CASCADE
);
CREATE TABLE PurchaseLink_Name (
    PurchaseLink VARCHAR(100) PRIMARY KEY,
    Name VARCHAR(60)
);
CREATE TABLE Equipment_NeedsTools (
    EID INTEGER PRIMARY KEY AUTO_INCREMENT,
    PurchaseLink VARCHAR(100) NOT NULL,
    PID INTEGER NOT NULL,
    FOREIGN KEY (PurchaseLink) REFERENCES PurchaseLink_Name(PurchaseLink)
        ON DELETE CASCADE,
     FOREIGN KEY (PID) REFERENCES Projects_PostsProject(PID)
        ON DELETE CASCADE
);
CREATE TABLE Materials_MadeWith (
    MID INTEGER PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(60) NOT NULL,
    Quantity INTEGER,
    QuantityUnit VARCHAR(10),
    PID INTEGER NOT NULL,
    FOREIGN KEY (PID) REFERENCES Projects_PostsProject(PID)
        ON DELETE CASCADE
);
CREATE TABLE Contains (
    WLID INTEGER,
    PID INTEGER,
    PRIMARY KEY (WLID, PID),
    FOREIGN KEY (WLID) REFERENCES ProjectWishlist_Creates(WLID)
        ON DELETE CASCADE,
    FOREIGN KEY (PID) REFERENCES Projects_PostsProject(PID)
        ON DELETE CASCADE
);
CREATE TABLE CompletesProject (
    Username VARCHAR(40),
    PID INTEGER,
    Timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (Username, PID),
    FOREIGN KEY (Username) REFERENCES Users(Username)
        ON DELETE CASCADE,
    FOREIGN KEY (PID) REFERENCES Projects_PostsProject(PID)
        ON DELETE CASCADE
);
-- Insert data
INSERT INTO City_Timezones (City, Timezone)
VALUES ('Vancouver', -7);
INSERT INTO City_Timezones (City, Timezone)
VALUES ('Victoria', -7);
INSERT INTO City_Timezones (City, Timezone)
VALUES ('Quebec City', -4);
INSERT INTO City_Timezones (City, Timezone)
VALUES ('Toronto', -4);
INSERT INTO City_Timezones (City, Timezone)
VALUES ('Seattle', -7);
INSERT INTO City_Timezones (City, Timezone)
VALUES ('Geneva', 1);
INSERT INTO City_Timezones (City, Timezone)
VALUES ('London', 0);
INSERT INTO City_Timezones (City, Timezone)
VALUES ('Berlin', 1);

INSERT INTO Users (Username, PasswordHash, City)
VALUES ('Bob Jones', '5f4dcc3b5aa765d61d8327deb882cf99', 'Vancouver');
INSERT INTO Users (Username, PasswordHash, City)
VALUES ('John Fubar', '6134b81f81f5f52f023e9a56d7cd8cf2', 'Seattle');
INSERT INTO Users (Username, PasswordHash, City)
VALUES ('Jacob Zhu', 'faae576dc6a876e23fcb61cd03cff032', 'Geneva');
INSERT INTO Users (Username, PasswordHash, City)
VALUES ('Sally Jones', 'b8bba2baae4c2a08fdff4e223458577d', 'London');
INSERT INTO Users (Username, PasswordHash, City)
VALUES ('Michael Morbius', '6104b739e435902b40b54085aa3953f9', 'Berlin');

INSERT INTO Message_Sends (Text, ReceiverUsername, SenderUsername)
VALUES ('Hello!', 'Sally Jones', 'Bob Jones');
INSERT INTO Message_Sends (Text, ReceiverUsername, SenderUsername)
VALUES ('Hi Jacob', 'Jacob Zhu', 'Bob Jones');
INSERT INTO Message_Sends (Text, ReceiverUsername, SenderUsername)
VALUES ('Check out my projects', 'Jacob Zhu', 'Michael Morbius');
INSERT INTO Message_Sends (Text, ReceiverUsername, SenderUsername)
VALUES ('My wife left me because of your project.', 'Michael Morbius', 'Bob Jones');
INSERT INTO Message_Sends (Text, ReceiverUsername, SenderUsername)
VALUES ('Hello world!', 'Jacob Zhu', 'Sally Jones');

INSERT INTO Projects_PostsProject (Name, InstructionText, Username)
VALUES ('Arrange Plants', 'Arrange plants in an aesthetic way!', 'Bob Jones');
INSERT INTO Projects_PostsProject (Name, InstructionText, Username)
VALUES ('Read Textbook', 'Read the math textbook and finish the questions', 'Sally Jones');
INSERT INTO Projects_PostsProject (Name, InstructionText, Username)
VALUES ('Take a walk', 'Take a walk outside!', 'Jacob Zhu');
INSERT INTO Projects_PostsProject (Name, InstructionText, Username)
VALUES ('Tear down drywall', 'Use hammer to deconstruct drywall', 'Bob Jones');
INSERT INTO Projects_PostsProject (Name, InstructionText, Username)
VALUES ('Construct bed', 'Build IKEA bed', 'Michael Morbius');

INSERT INTO Feedback_LeavesFeedback (Title, Comment, Username, PID)
VALUES ('I hate this product', 'My wife left me because of these unclear instructions', 'Michael Morbius', 1);
INSERT INTO Feedback_LeavesFeedback (Title, Stars, Username, PID)
VALUES ('I’m confused', 2, 'Jacob Zhu', 2);
INSERT INTO Feedback_LeavesFeedback (Title, Comment, Username, PID)
VALUES ('I’m Satisfied', 'My wife managed to follow these instructions', 'Bob Jones', 1);
INSERT INTO Feedback_LeavesFeedback (Title, ImageData, Username, PID)
VALUES ('A picture', 'image data would go here', 'Bob Jones', 3);
INSERT INTO Feedback_LeavesFeedback (Title, Stars, Username, PID)
VALUES ('I’m moderately happy', 4, 'John Fubar', 4);

INSERT INTO Images_ContainsImages (GalleryIndex, ImageData, Caption, PID)
VALUES (1, 'cat image data would go here', 'A Cat', 1);
INSERT INTO Images_ContainsImages (GalleryIndex, ImageData, Caption, PID)
VALUES (2, 'dog image data would go here', 'A Dog', 1);
INSERT INTO Images_ContainsImages (GalleryIndex, ImageData, Caption, PID)
VALUES (1, 'house image data would go here', 'My House', 2);
INSERT INTO Images_ContainsImages (GalleryIndex, ImageData, Caption, PID)
VALUES (1, 'selfie image data would go here', 'Selfie', 3);
INSERT INTO Images_ContainsImages (GalleryIndex, ImageData, Caption, PID)
VALUES (2, 'tire image data would go here', 'A Flat Tire', 3);

INSERT INTO ProjectWishlist_Creates (Name, Username)
VALUES ('Coding Project', 'Sally Jones');
INSERT INTO ProjectWishlist_Creates (Name, Username)
VALUES ('Interior Furnishing', 'Bob Jones');
INSERT INTO ProjectWishlist_Creates (Name, Username)
VALUES ('My TodoList', 'Michael Morbius');
INSERT INTO ProjectWishlist_Creates (Name, Username)
VALUES ('Homework Research', 'Sally Jones');
INSERT INTO ProjectWishlist_Creates (Name, Username)
VALUES ('Hiking Preparation', 'Jacob Zhu');

INSERT INTO PurchaseLink_Name (PurchaseLink, Name)
VALUES ('https://www.amazon.ca/hammer/s?k=hammer', 'Hammer');
INSERT INTO PurchaseLink_Name (PurchaseLink, Name)
VALUES ('https://www.bestbuy.ca/en-ca/category/laptops-macbooks/20352', 'Macbook Laptop');
INSERT INTO PurchaseLink_Name (PurchaseLink, Name)
VALUES ('https://www.amazon.ca/b?ie=UTF8&node=15306831', 'Calculus Textbook');
INSERT INTO PurchaseLink_Name (PurchaseLink, Name)
VALUES ('https://www.homedepot.ca/en/home/categories/outdoors/lawn-and-garden-centre/watering-and-irrigation/garden-hoses.html', 'Garden Hose');
INSERT INTO PurchaseLink_Name (PurchaseLink, Name)
VALUES ('https://www.homedepot.com/b/Tools-Hand-Tools-Screwdrivers-Nut-Drivers-Screwdrivers/N-5yc1vZc993', 'Screwdrivers');

INSERT INTO Equipment_NeedsTools (PurchaseLink, PID)
VALUES ('https://www.amazon.ca/hammer/s?k=hammer', 1);
INSERT INTO Equipment_NeedsTools (PurchaseLink, PID)
VALUES ('https://www.bestbuy.ca/en-ca/category/laptops-macbooks/20352', 3);
INSERT INTO Equipment_NeedsTools (PurchaseLink, PID)
VALUES ('https://www.amazon.ca/b?ie=UTF8&node=15306831', 4);
INSERT INTO Equipment_NeedsTools (PurchaseLink, PID)
VALUES ('https://www.homedepot.ca/en/home/categories/outdoors/lawn-and-garden-centre/watering-and-irrigation/garden-hoses.html', 2);
INSERT INTO Equipment_NeedsTools (PurchaseLink, PID)
VALUES ('https://www.homedepot.com/b/Tools-Hand-Tools-Screwdrivers-Nut-Drivers-Screwdrivers/N-5yc1vZc993', 5);

INSERT INTO Materials_MadeWith (Name, Quantity, QuantityUnit, PID)
VALUES ('Wood', 1, 'LBS', 1);
INSERT INTO Materials_MadeWith (Name, Quantity, QuantityUnit, PID)
VALUES ('Water', 2, 'L', 2);
INSERT INTO Materials_MadeWith (Name, Quantity, QuantityUnit, PID)
VALUES ('PLA Filament', 0.5, 'KG', 3);
INSERT INTO Materials_MadeWith (Name, Quantity, QuantityUnit, PID)
VALUES ('Wood', 4, 'LBS', 4);
INSERT INTO Materials_MadeWith (Name, Quantity, QuantityUnit, PID)
VALUES ('Wood', 5, 'LBS', 5);

INSERT INTO Contains (WLID, PID)
VALUES(1, 1);
INSERT INTO Contains (WLID, PID)
VALUES(1, 2);
INSERT INTO Contains (WLID, PID)
VALUES(3, 2);
INSERT INTO Contains (WLID, PID)
VALUES(4, 3);
INSERT INTO Contains (WLID, PID)
VALUES(4, 4);

INSERT INTO CompletesProject (Username, PID)
VALUES ('Bob Jones', 1);
INSERT INTO CompletesProject (Username, PID)
VALUES ('John Fubar', 2);
INSERT INTO CompletesProject (Username, PID)
VALUES ('Jacob Zhu', 3);
INSERT INTO CompletesProject (Username, PID)
VALUES ('Sally Jones', 4);
INSERT INTO CompletesProject (Username, PID)
VALUES ('Michael Morbius', 5);
