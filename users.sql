CREATE TABLE USERS (
	Email VARCHAR(254) NOT NULL,
	Password CHAR(32) NOT NULL,
	Name_First VARCHAR(72),
	Name_Last VARCHAR(128),
	Organization VARCHAR(128),
	Last_Login DATETIME,
	Two_Factor_Code CHAR(32),
	Two_Factor_Approved BIT NOT NULL DEFAULT 0,
	Verification_Code CHAR(32) NOT NULL,
	Admin_User BIT NOT NULL DEFAULT 0,
	Email_Verified BIT NOT NULL DEFAULT 0,
	Approved_By_Admin BIT NOT NULL DEFAULT 0,
	CONSTRAINT PK_USERS PRIMARY KEY (Email)
);