CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) DEFAULT 'user',  -- Default role is 'user', you can change it to 'admin' if needed
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



CREATE TABLE donations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    jina_kamili VARCHAR(255) NOT NULL,
    jumla DECIMAL(10, 2),
    zaka DECIMAL(10, 2) NOT NULL,
    sadaka DECIMAL(10, 2),
    sadaka_58 DECIMAL(10, 2),
    sadaka_42 DECIMAL(10, 2),
    s_kambi DECIMAL(10, 2),
    ctf DECIMAL(10, 2),
    shule DECIMAL(10, 2),
    majengo DECIMAL(10, 2),
    idara_ya_wanawake DECIMAL(10, 2),
    idara_ya_elimu DECIMAL(10, 2),
    wahitaji DECIMAL(10, 2),
    amo_dorcas DECIMAL(10, 2),
    s_sabato DECIMAL(10, 2),
    kwaya DECIMAL(10, 2),
    idara_ya_vijana DECIMAL(10, 2),
    date DATE NOT NULL DEFAULT CURRENT_DATE  -- Automatically set the date to today's date
);


CREATE TABLE michango (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    email VARCHAR(255) NOT NULL,
    department VARCHAR(255) NOT NULL,
    donation_amount DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

