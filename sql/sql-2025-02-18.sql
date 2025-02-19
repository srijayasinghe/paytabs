CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'paid', 'refunded') NOT NULL DEFAULT 'pending'
);
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL
);
CREATE TABLE IF NOT EXISTS payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    request_payload TEXT NOT NULL,
    response_payload TEXT NOT NULL,
    status ENUM('pending', 'success', 'failed') NOT NULL DEFAULT 'pending',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS refunds (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    request_payload TEXT NOT NULL,
    response_payload TEXT NOT NULL,
    status ENUM('requested', 'processed', 'failed') NOT NULL DEFAULT 'requested',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(255) NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

INSERT INTO products (name, price) VALUES
('Laptop', 150000.00),
('Smartphone', 80000.00),
('Headphones', 15000.00),
('Smartwatch', 25000.00),
('Gaming Mouse', 10000.00),
('Mechanical Keyboard', 18000.00),
('Monitor 24"', 55000.00),
('External Hard Drive', 12000.00),
('Wireless Charger', 5000.00),
('Bluetooth Speaker', 20000.00);

INSERT INTO orders (order_date, status) VALUES
('2025-02-10 10:15:00', 'paid'),
('2025-02-12 14:30:00', 'pending'),
('2025-02-14 18:45:00', 'refunded'),
('2025-02-16 09:10:00', 'paid'),
('2025-02-18 12:00:00', 'pending');

INSERT INTO cart (session_id, product_id, quantity) VALUES
('SESSION_ABC123', 1, 2),  -- 2 Laptops
('SESSION_ABC123', 3, 1),  -- 1 Headphone
('SESSION_XYZ456', 2, 1),  -- 1 Smartphone
('SESSION_XYZ456', 5, 3),  -- 3 Gaming Mice
('SESSION_XYZ456', 7, 1);  -- 1 Monitor 24"

INSERT INTO payments (order_id, request_payload, response_payload, status, created_at) VALUES
(1, '{"amount": 150000, "currency": "LKR"}', '{"status": "success", "transaction_id": "TXN123"}', 'success', '2025-02-10 10:16:00'),
(2, '{"amount": 80000, "currency": "LKR"}', '{"status": "pending", "transaction_id": "TXN456"}', 'pending', '2025-02-12 14:32:00'),
(3, '{"amount": 15000, "currency": "LKR"}', '{"status": "success", "transaction_id": "TXN789"}', 'success', '2025-02-14 18:46:00'),
(4, '{"amount": 25000, "currency": "LKR"}', '{"status": "success", "transaction_id": "TXN012"}', 'success', '2025-02-16 09:12:00'),
(5, '{"amount": 10000, "currency": "LKR"}', '{"status": "pending", "transaction_id": "TXN345"}', 'pending', '2025-02-18 12:01:00');

INSERT INTO refunds (order_id, request_payload, response_payload, status, created_at) VALUES
(3, '{"reason": "defective item"}', '{"status": "processed", "refund_id": "RFND123"}', 'processed', '2025-02-15 10:00:00'),
(4, '{"reason": "customer request"}', '{"status": "processed", "refund_id": "RFND456"}', 'processed', '2025-02-17 11:20:00');

