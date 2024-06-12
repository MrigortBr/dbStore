CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  login VARCHAR(100) NOT NULL,
  password VARCHAR(100) NOT NULL,
  typeUser ENUM("user", "store")
);

CREATE TABLE products (
  id INT PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(100) NOT NULL,
  image VARCHAR(150) NOT NULL,
  price FLOAT NOT NULL,
  visible BOOLEAN,
  stock INT NOT NULL,
  store_id INT,
  FOREIGN KEY (store_id) REFERENCES users(id)
);

CREATE TABLE sales (
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  product_id INT NOT NULL,
  buyer_id INT NOT NULL,
  amount INT NOT NULL,
  pricePerProduct FLOAT NOT NULL,
  priceFinal FLOAT NOT NULL,
  FOREIGN KEY (product_id) REFERENCES products(id),
  FOREIGN KEY (buyer_id) REFERENCES users(id)
);
