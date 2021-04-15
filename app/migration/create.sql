CREATE TABLE vehicles
(
    id bigserial primary key,
    name text NOT NULL UNIQUE,
    number_plate text NOT NULL UNIQUE,
    updated_at timestamp default NULL,
    created_at timestamp default NULL
);