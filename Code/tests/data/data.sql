/*
 *
 */
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
    VALUE
        (3, 'XXL',02-05-2021, 01-03-2021,05-03-2040,500);


CREATE TABLE `transporters` (
    `name` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;
INSERT INTO `transporters`(name)
VALUES
       ('Oles transport'),
       ('Einars levering'),
       ('Gro Anitas postservice'),
       ('Henriks utkjøring');

CREATE TABLE `Employees`(
    `number` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
  `department` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL
)
    ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;
    INSERT INTO 'Employees'(number, name, department)
    VALUES
           (1, 'Ragnhild', 'Customer-Rep'),
           (2, 'Tord', 'Storekeeper'),
           (3, 'Pelle', 'Production-Planner'),
           (4,'Oline','Customer-Rep');



CREATE TABLE `customer_representative` (
    `number` int(11) NOT NULL
)
    ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;
    INSERT INTO customer_representative(number)
    VALUES
           (1),
           (4);

CREATE TABLE `storekeeper` (
    `number` int(11) NOT NULL
)
    ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;
    INSERT INTO storekeeper(number)
    VALUES
           (2);


CREATE TABLE `production_planner` (
    `number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;
    INSERT INTO production_planner(number)
    VALUES
           (3);



CREATE TABLE `production_Plan` (
                                   `start_date` date NOT NULL,
                                   `end_date` date NOT NULL,
                                   `no_of_skis_per_day` int(11) NOT NULL,
                                   `production_planner_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;
INSERT INTO `production_Plan`(start_date, end_date, no_of_skis_per_day, production_planner_number)
    VALUES
           (22-04-2021, 19-05-2021, 1500, 1),
           (20-05-2021, 17-06-2021, 1400, 2),
           (18-06-2021, 15-07-2021, 1600, 3),
           (16-07-2021, 13-08-2021, 1800, 4),
           (14-08-2021, 11-09-2021, 2000, 5);

CREATE TABLE `production_list` (
                                   `amount` int(11) NOT NULL,
                                   `production_plan_start_date` date NOT NULL,
                                   `production_plan_end_date` date NOT NULL,
                                   `ski_type_model` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;
INSERT INTO `production_list`(amount, production_plan_start_date, production_plan_end_date, ski_type_model)
VALUES
       (1500, 22-04-2021, 19-05-2021, 'Active-Pro'),
       (1600, 18-06-2021, 15-07-2021, 'Redline'),
       (2000, 14-08-2021, 11-09-2021, 'Race Pro');


CREATE TABLE `product` (
                           `product_no` int(11) NOT NULL,
                           `ski_type` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;
INSERT INTO `product`(product_no, ski_type)
VALUES
       (202315, 'Active-Pro'),
       (885235, 'Active-Pro'),
       (329781, 'Active-Pro'),
       (592903, 'Redline'),
       (240444, 'Race Pro'),
       (881273, 'Race pro'),
       (328833, 'Redline'),
       (975634, 'Race pro'),
       (834480, 'Redline');

CREATE TABLE `address` (
                           `postal_code` int(4) NOT NULL,
                           `city_id` int(11) NOT NULL,
                           `street_name` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
                           `house_no` int(11) NOT NULL,
                           `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;
INSERT INTO address(postal_code, city_id, street_name, house_no, id)
VALUES
       (0150, 'Oslo', 'Langkaia', 1, 132),
       (5130, 'Bergen', 'Myrdalsvegen', 22, 154),
       (6005, 'Ålesund', 'Tøffeveien', 35, 124),
       (3085, 'Holmestrand', 'Taperveien', 45, 753);


CREATE TABLE `city` (
                        `city_id` int(11) NOT NULL,
                        `name` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
                        `county_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;
INSERT INTO city(city_id, name, county_no)
VALUES
       (51234,'Oslo',03),
       (15422, 'Bergen',13),
       (23124, 'Ålesund',15),
       (13513, 'Holmestrand',07);


CREATE TABLE `county` (
                          `county_no` int(11) NOT NULL,
                          `name` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;
INSERT INTO county(county_no, name)
VALUES
       (03, 'Oslo'),
       (13, 'Bergen'),
       (15, 'Møre_og_Romsdal'),
       (07,'Vestfold');


CREATE TABLE `orders` (
                          `order_no` int(11) NOT NULL,
                          `total_price` int(11) NOT NULL,
                          `status` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
                          `customer_id` int(11) NOT NULL,
                          `shipment_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;
INSERT INTO `orders`(order_no, total_price, status, customer_id, shipment_no)
VALUES
       (15232, 34000, 'new',1, 2),
       (12478,12000,'new',2,2),
       (15231,2500, 'new', 3, 3),
       (46029, 1000, 'new',2, 3),
       (19324, 2000, 'new', 3,1);


CREATE TABLE `order_items` (
                               `amount` int(11) DEFAULT NULL,
                               `order_no` int(11) NOT NULL,
                               `ski_type` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;
INSERT INTO `order_items`(amount, order_no, ski_type)
VALUES
       (150, 15232, 'Redline'),
       (200, 12478,'Active Pro'),
       (50, 15231, 'Race Pro'),
       (25, 46029, 'Intrasonic'),
       (30, 19324, 'Race Speed');

CREATE TABLE `items_picked` (
                                `amount` int(11) DEFAULT NULL,
                                `shipment_no` int(11) NOT NULL,
                                `product_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;
INSERT INTO `items_picked`(amount, shipment_no, product_no)
VALUES
       (150,1,592903),
       (200, 1, 240444),
       (50, 2, 975634),
       (25, 2, 834480);

CREATE TABLE `shipments` (
                             `shipment_no` int(11) NOT NULL,
                             `store_franchise_name` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
                             `pickup_date` date DEFAULT NULL,
                             `state` tinyint(1) NOT NULL,
                             `driver_id` int(11) DEFAULT NULL,
                             `transporter` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
                             `address_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;
INSERT INTO `shipments`(shipment_no, store_franchise_name, pickup_date, state, driver_id, transporter, address_id)
VALUES
(1, 'XXL',25-04-2021, 0, 1, 'Einars levering', 132),
(2, 'XXL', 28-06-2021, 0, 2, 'Gro Anitas postservice', 753);


CREATE TABLE `history` (
                           `date` datetime NOT NULL DEFAULT current_timestamp(),
                           `status` varchar(100) NOT NULL,
                           `order_no` int(11) NOT NULL,
                           `employee_no` int(11) NOT NULL
)
    ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;
    INSERT INTO `history`(date, status, order_no, employee_no)
    VALUES
           (22-04-2021,'Open',15232,1),
           (23-04-2021, 'Skiis-available',15232, 4),
           (24-04-2021, 'Ready-to-be-shipped', 15232, 2),
           (25-06-2020,'Open',12478,4),
           (26-06-2020, 'Skiis-available',12478, 1),
           (27-06-2020, 'Ready-to-be-shipped', 12478, 2);










