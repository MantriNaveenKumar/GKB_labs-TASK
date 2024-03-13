CREATE DATABASE Gkblabs;

-- Active: 1692864209117@@127.0.0.1@5432@gkblabs@public
CREATE TABLE candidates (
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    age INT,
    dob DATE
);

CREATE TABLE admin_credentials (
    id SERIAL PRIMARY KEY,
  admin_username VARCHAR(50) UNIQUE NOT NULL,
    admin_password VARCHAR(100) NOT NULL
);