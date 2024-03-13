-- Optional: create database
-- CREATE DATABASE creatables
-- USE creatables

-- Drop existing tables
DROP TABLE IF EXISTS CompletesProject;
DROP TABLE IF EXISTS Contains;
DROP TABLE IF EXISTS Equipment_NeedsTools;
DROP TABLE IF EXISTS PurchaseLink_Name;
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