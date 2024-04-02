-- Drop existing tables
SET FOREIGN_KEY_CHECKS = 0;
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
DROP TABLE IF EXISTS CompletesProject;

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
        ON UPDATE CASCADE
);
CREATE TABLE Images_ContainsImages (
    GalleryIndex INTEGER,
    ImageData MEDIUMTEXT NOT NULL,
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
    ImageData MEDIUMTEXT,
    Timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    Username VARCHAR(40) NOT NULL,
    PID INTEGER NOT NULL,
    FOREIGN KEY (Username) REFERENCES Users(Username)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
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
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (ReceiverUsername) REFERENCES Users(Username)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
CREATE TABLE ProjectWishlist_Creates (
    WLID INTEGER PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(60) NOT NULL,
    Username VARCHAR(40) NOT NULL,
    FOREIGN KEY (Username) REFERENCES Users(Username)
        ON DELETE CASCADE
        ON UPDATE CASCADE
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
INSERT INTO Users (Username, PasswordHash, City, JoinDate)
VALUES ('Future Fellow', '6104b739e435902b39b54085aa3953f9', 'Quebec City', '2025:01:01');


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

INSERT INTO Projects_PostsProject (Name, InstructionText, Username, Timestamp)
VALUES ('Arrange Plants', 'Arrange plants in an aesthetic way!', 'Bob Jones', '2023-03-28 16:30:57');
INSERT INTO Projects_PostsProject (Name, InstructionText, Username, Timestamp)
VALUES ('Read Textbook', 'Read the math textbook and finish the questions', 'Sally Jones', '2023-08-10 12:30:50');
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
VALUES ('A picture', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAlAQAAAAAsYlcCAAAACklEQVR4AWMaBQAIHgIHYH2qggAAAABJRU5ErkJggg==', 'Bob Jones', 3);
INSERT INTO Feedback_LeavesFeedback (Title, Stars, Username, PID)
VALUES ('I’m moderately happy', 4, 'John Fubar', 4);
INSERT INTO Feedback_LeavesFeedback (Title, Stars, Username, PID)
VALUES ('I’m very dissatisfied', 1, 'Jacob Zhu', 4);
INSERT INTO Feedback_LeavesFeedback (Title, Stars, Username, PID)
VALUES ('I’m happy', 5, 'Future Fellow', 4);
INSERT INTO Feedback_LeavesFeedback (Title, Stars, Username, PID)
VALUES ('Mid', 3, 'Bob Jones', 4);
INSERT INTO Feedback_LeavesFeedback (Title, Stars, Username, PID)
VALUES ('Pretty good', 4, 'Sally Jones', 4);
INSERT INTO Feedback_LeavesFeedback (Title, Stars, Username, PID)
VALUES ('I’m Michael Morbius!', 5, 'Michael Morbius', 4);
INSERT INTO Feedback_LeavesFeedback (Title, Stars, Username, PID)
VALUES ('Morbing out rn. 3/5.', 3, 'Michael Morbius', 1);
INSERT INTO Feedback_LeavesFeedback (Title, Stars, Username, PID)
VALUES ('Terrible!!!', 1, 'Sally Jones', 1);


INSERT INTO Images_ContainsImages (GalleryIndex, ImageData, Caption, PID)
VALUES (1, 'data:image/png;base64,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',
'A Cat', 1);
INSERT INTO Images_ContainsImages (GalleryIndex, ImageData, Caption, PID)
VALUES (2, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAlAQAAAAAsYlcCAAAACklEQVR4AWMaBQAIHgIHYH2qggAAAABJRU5ErkJggg==', 'A Dog', 1);
INSERT INTO Images_ContainsImages (GalleryIndex, ImageData, Caption, PID)
VALUES (1, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAlAQAAAAAsYlcCAAAACklEQVR4AWMaBQAIHgIHYH2qggAAAABJRU5ErkJggg==', 'My House', 2);
INSERT INTO Images_ContainsImages (GalleryIndex, ImageData, Caption, PID)
VALUES (1, 'data:image/png;base64,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',
'Twitter', 3);
INSERT INTO Images_ContainsImages (GalleryIndex, ImageData, Caption, PID)
VALUES (2, 'data:image/png;base64, iVBORw0KGgoAAAANSUhEUgAAASwAAAAeCAYAAACWuCNnAAAAYElEQVR42u3UAREAAAQEsJdcdHI4W4hVMh2AA0pYgLAAhAUIC0BYAMIChAUgLABhAcICEBaAsABhAQgLQFiAsACEBSAsQFgAwgIQFiAsAGEBCAsQFoCwAIQFCAtAWMB3C3LPLOP+J4YoAAAAAElFTkSuQmCC',
'A Flat Tire', 3);

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

SET FOREIGN_KEY_CHECKS = 1;
