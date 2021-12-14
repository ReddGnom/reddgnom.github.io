CREATE TABLE OWNER(
	ownerID int(11) NOT NULL AUTO_INCREMENT,
	ownerEmail varchar(255) NOT NULL,
	ownerPassword varchar(255) NOT NULL,
	ownerSubscriptionDate date NOT NULL,
	PRIMARY KEY(ownerID)
	);
	
CREATE TABLE COUNTRY(
	countryID int(11) NOT NULL AUTO_INCREMENT,
	countryName varchar(255) NOT NULL,
	PRIMARY KEY(countryID)
	);
	
CREATE TABLE CITY(
	cityID int(11) NOT NULL AUTO_INCREMENT,
	cityName varchar(255) NOT NULL,
	countryID int(11) NOT NULL,
	PRIMARY KEY(cityID),
	FOREIGN KEY(countryID) REFERENCES COUNTRY(countryID)
	);

CREATE TABLE STREET(
	streetID int(11) NOT NULL AUTO_INCREMENT,
	streetName varchar(255) NOT NULL,
	cityID int(11) NOT NULL,
	PRIMARY KEY(streetID),
	FOREIGN KEY(cityID) REFERENCES CITY(cityID)
	);
	
CREATE TABLE RESTAURANT(
	restaurantID int(11) NOT NULL AUTO_INCREMENT,
	restaurantPhoneNumber varchar(255) NOT NULL,
	restaurantName varchar(255) NOT NULL,
	streetID int(11) NOT NULL,
	/*complaintID int(11) NOT NULL,  DROP * FROM RESTAURANT WHERE COUNT(complaintID) = 5 */
	ownerID int(11) NOT NULL,
	PRIMARY KEY(restaurantID),
	FOREIGN KEY(ownerID) REFERENCES OWNER(ownerID),
	FOREIGN KEY(streetID) REFERENCES STREET(streetID)
	);

CREATE TABLE USERS(
	userID int(11) NOT NULL AUTO_INCREMENT,
	userName varchar(255) NOT NULL,
	userPassword varchar(255) NOT NULL,
	userPhoneNumber varchar(255) NOT NULL,
	userEmail varchar(255) NOT NULL,
	/*userNoShow int(1) NOT NULL,  SELECT * FROM USER WHERE USER u BRANCH B u.userID = b.userID AND COUNT(b.bookingStatus = 'No_Show';*/
	PRIMARY KEY(userID)
	);
	
CREATE TABLE BOOKING(
	bookingID int(11) NOT NULL AUTO_INCREMENT,
	restaurantID int(11) NOT NULL,
	userID int(11) NOT NULL,
	bookingStatus ENUM('Pending', 'Confirmed', 'Cancelled', 'No_Show') NOT NULL DEFAULT 'Pending',
	bookingTime time NOT NULL,
	bookingDate date NOT NULL,
	bookingGuestNumber int(4) NOT NULL,
	PRIMARY KEY(bookingID),
	FOREIGN KEY(restaurantID) REFERENCES RESTAURANT(restaurantID),
	FOREIGN KEY(userID) REFERENCES USERS(userID)
	);
	
CREATE TABLE REVIEW(
	reviewID int(11) NOT NULL AUTO_INCREMENT,
	bookingID int(11) NOT NULL,
	reviewStar int(1) NOT NULL,
	reviewHeading varchar(255) NOT NULL,
	reviewBody varchar(500) NOT NULL,
	PRIMARY KEY(reviewID),
	FOREIGN KEY(bookingID) REFERENCES BOOKING(bookingID)
	);
	
CREATE TABLE COMPLAINT(
	complaintID int(11) NOT NULL AUTO_INCREMENT,
	bookingID int(11) NOT NULL,
	complaintDescription varchar(500) NOT NULL,
	complaintDate date NOT NULL, /* Drop * where complaintDate > 12 ago */
	PRIMARY KEY(complaintID),
	FOREIGN KEY(bookingID) REFERENCES BOOKING(bookingID)
	);
	
CREATE TABLE CARD(
	cardID int(11) NOT NULL AUTO_INCREMENT,
	cardNumber bigint(16) NOT NULL,
	cardExpiry varchar(5) NOT NULL,
	cardType ENUM('Visa', 'Visa_Debit', 'American_Express', 'Mastercard') NOT NULL,
	cardCVV int(4) NOT NULL,
	ownerID int(11) NOT NULL,
	PRIMARY KEY(cardID),
	FOREIGN KEY(ownerID) REFERENCES OWNER(ownerID)
	);