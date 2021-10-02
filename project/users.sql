CREATE TABLE USERS (
	Email VARCHAR(254) NOT NULL,
	Password CHAR(32) NOT NULL,
	Name_First VARCHAR(72),
	Name_Last VARCHAR(128),
	Organization VARCHAR(128),
	Last_Login DATETIME,
	Admin_User BIT NOT NULL,
	Email_Verified BIT NOT NULL,
	Approved_By_Admin BIT NOT NULL,
	CONSTRAINT PK_USERS PRIMARY KEY (Email)
);