/*CREATE TABLE users
(
    id         INT          NOT NULL AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name  VARCHAR(255) NOT NULL,
    email      VARCHAR(255) NOT NULL,
    password   VARCHAR(255) NOT NULL,
    username   VARCHAR(255) NOT NULL,
    admin      BOOLEAN DEFAULT FALSE
);

CREATE TABLE reports
(
    id                 INT          NOT NULL AUTO_INCREMENT PRIMARY KEY,
    animal_type        VARCHAR(255) NOT NULL,
    city               VARCHAR(255) NOT NULL,
    street             VARCHAR(255) NOT NULL,
    description        VARCHAR(255) NOT NULL,
    additional_aspects VARCHAR(255) NOT NULL,
    is_approve         INT          DEFAULT 0
);

CREATE TABLE images
(
    id                 INT          NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name               VARCHAR(255) NOT NULL,
    report_id          INT          NOT NULL,
    FOREIGN KEY (report_id) REFERENCES reports(id)
);*/

/*ALTER TABLE users
    ADD COLUMN admin BOOLEAN DEFAULT FALSE;
ALTER TABLE users DROP COLUMN admin;
DROP TABLE reports;*/

/*ALTER TABLE reports
    ADD COLUMN user_id INT,
    ADD CONSTRAINT fk_user_id
        FOREIGN KEY (user_id) REFERENCES users(id);*/

/*ALTER TABLE reports
    ADD COLUMN pub_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP;
*/

/*ALTER TABLE reports
    MODIFY COLUMN user_id INT NOT NULL;*/