CREATE TABLE 'ski'(
    'model' varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
        'ski_type' varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
        'temperature' varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
        'grip_system' varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
        'size' integer NOT NULL ,
        'weight_class' varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
        'description' varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
        'historical' boolean NOT NULL,
        'photo_url' varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
        'retail_price' integer NOT NULL ,
        'production_date' DATE NOT NULL
    )
    ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

    INSERT INTO 'ski'(model, ski_type, temperature, grip_system, size, weight_class,
                      description, historical, photo_url, retail_price, production_date)
                      VALUES
    ('Active','classic', 'cold','wax', 142, '20-30', 'Bra ski', false, 'bildet', 1200,20-03-2021),
    ('Active Pro','skate', 'warm','intelligrip', 147, '30-40', 'Rævva ski', false, 'bildet', 1400, 02-04-2021),
    ('Endurance','double-pole', 'warm','wax', 152, '40-50', 'Ok ski', false, 'bildet', 1500,03-12-2021),
    ('Intrasonic','classic', 'cold','intelligrip', 157, '40-50', 'Litt bra ski', false, 'bildet', 1500,05-10-2021),
    ('Race Pro','skate', 'warm','wax', 162, '50-60', 'Ræser ski', false, 'bildet', 2200,28-04-2021),
    ('Race Speed','double-pole', 'warm','intelligrip', 167, '70-80', 'Beste skia', false, 'bildet', 36000,01-01-2017),
    ('Redline','skate', 'cold','wax', 172, '80-90', 'Verste skia', false, 'bildet', 200,22-07-2012);

CREATE TABLE 'individual store'(
    'customer_id' integer NOT NULL ,
        'name' varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
        'contract_duration' DATE NOT NULL ,
        'start_date' DATE NOT NULL ,
        'end_date' DATE NOT NULL ,
        'Buying_price' integer NOT NULL
)
    ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;
    INSERT INTO 'individual store'(customer_id, name, contract_duration, start_date, end_date, Buying_price)
    VALUE (1,'Gamletorvet sport Oslo sportslager', 01-03-2021, 01-03-2021,05-03-2035, 1000);

CREATE TABLE 'Team skiers'(
    'customer_id' integer NOT NULL ,
    'name' varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
    'contract_duration' DATE NOT NULL ,
    'start_date' DATE NOT NULL ,
    'end_date' DATE NOT NULL ,
    'date_of_birth' DATE NOT NULL ,
    'Club' VARCHAR(100) COLLATE utf8mb4_danish_ci NOT NULL,
    'no_skies_per_year' INTEGER NOT NULL
)
    ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;
    INSERT INTO `Team skiers`(customer_id, name, contract_duration, start_date, end_date, date_of_birth, Club, no_skies_per_year)
    VALUE(2, 'Han Raske', 02-05-2021, 01-03-2021,05-03-2023, 01-05-1995, 'Gutta',15);

CREATE TABLE 'Franchises'(
    'customer_id' integer NOT NULL ,
    'name' varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
    'contract_duration' DATE NOT NULL ,
    'start_date' DATE NOT NULL ,
    'end_date' DATE NOT NULL ,
    'Buying_price' integer NOT NULL
)
    ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;
    INSERT INTO 'Franchises'(customer_id, name, contract_duration, start_date, end_date, Buying_price)
    VALUE(3, 'XXL',02-05-2021, 01-03-2021,05-03-2040,500);






