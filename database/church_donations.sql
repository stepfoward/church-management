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
    jumla DECIMAL(10, 2),
    zaka DECIMAL(10, 2),
    sadaka_part1 DECIMAL(10, 2),
    sadaka_part2 DECIMAL(10, 2),
    s_kambi DECIMAL(10, 2),
    ctf DECIMAL(10, 2),
    shule DECIMAL(10, 2),
    majengo DECIMAL(10, 2),
    idara_ya_wanawake DECIMAL(10, 2),
    idara_ya_elimu DECIMAL(10, 2),
    amo_dorcas DECIMAL(10, 2),
    s_sabato DECIMAL(10, 2),
    kwaya DECIMAL(10, 2),
    idara_ya_vijana DECIMAL(10, 2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
