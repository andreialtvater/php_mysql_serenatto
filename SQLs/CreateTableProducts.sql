CREATE TABLE IF NOT EXISTS serenatto.produtos (
    id INT NOT NULL AUTO_INCREMENT,
    type VARCHAR(45) NOT NULL,
    name VARCHAR(45) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(80) NOT NULL,
    price DECIMAL(5,2) NOT NULL,
    PRIMARY KEY (id));