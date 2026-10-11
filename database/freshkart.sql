
CREATE TABLE users(
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100),
 address TEXT,
 pincode VARCHAR(10),
 phone VARCHAR(15),
 email VARCHAR(100),
 password VARCHAR(255),
 role VARCHAR(20) DEFAULT 'user'
);

CREATE TABLE products(
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100),
 category VARCHAR(50),
 weight VARCHAR(20),
 price FLOAT,
 offer INT,
 image VARCHAR(200)
);

CREATE TABLE cart(
 id INT AUTO_INCREMENT PRIMARY KEY,
 user_id INT,
 product_id INT,
 quantity INT
);

CREATE TABLE orders(
 id INT AUTO_INCREMENT PRIMARY KEY,
 user_id INT,
 total FLOAT,
 status VARCHAR(50),
 payment_mode VARCHAR(50),
 delivery_boy VARCHAR(50)
);
UPDATE orders
SET delivery_boy='Amit',
    status='Out for Delivery'
WHERE id=ORDER_ID;

UPDATE orders
SET status='Delivered'
WHERE id=ORDER_ID;

CREATE TABLE favourites (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  product_id INT
);


-- ADMIN
CREATE TABLE admin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- USERS
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100),
  phone VARCHAR(20),
  password VARCHAR(255),
  address TEXT
) ENGINE=InnoDB;

-- CATEGORIES
CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100)
) ENGINE=InnoDB;

-- PRODUCTS
CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT,
  name VARCHAR(100),
  price DECIMAL(10,2),
  image VARCHAR(255),
  description TEXT
) ENGINE=InnoDB;

-- CART
CREATE TABLE cart (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  product_id INT,
  quantity INT
) ENGINE=InnoDB;

-- ORDERS
CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  total DECIMAL(10,2),
  status VARCHAR(50) DEFAULT 'Placed',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ORDER ITEMS
CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT,
  product_id INT,
  quantity INT,
  price DECIMAL(10,2)
) ENGINE=InnoDB;

-- DELIVERY BOYS
CREATE TABLE delivery_boys (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  phone VARCHAR(20),
  password VARCHAR(255),
  latitude VARCHAR(50),
  longitude VARCHAR(50)
) ENGINE=InnoDB;

-- DELIVERY LOCATIONS (GPS)
CREATE TABLE delivery_locations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT,
  delivery_id INT,
  latitude VARCHAR(50),
  longitude VARCHAR(50),
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- RETURNS (MOST IMPORTANT)
CREATE TABLE returns (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT,
  user_id INT,
  reason TEXT,
  status VARCHAR(50) DEFAULT 'Pending',
  refund_status VARCHAR(50) DEFAULT 'Pending',
  pickup_status VARCHAR(50) DEFAULT 'Pending',
  pickup_boy INT DEFAULT NULL,
  refund_account VARCHAR(50),
  refund_ifsc VARCHAR(20),
  refund_holder VARCHAR(100),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- FEEDBACK
CREATE TABLE feedback (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  message TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- FAVOURITES
CREATE TABLE favourites (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  product_id INT
) ENGINE=InnoDB;

-- NOTIFICATIONS
CREATE TABLE notifications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  message TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
