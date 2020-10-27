<?php

function Createdb() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "examsystem";

    // Create connection

    $connection = mysqli_connect($servername, $username, $password);

    // check connection

    if(!$connection) {
        die("Connection Failed:".mysqli_connect_err());
    }

    // Create Database

    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";

    if(mysqli_query($connection, $sql)) {
        $connection = mysqli_connect($servername, $username, $password, $dbname);
        
        return $connection;
    }
    else { 
        echo "Error while Creating the Database".mysqli_error($connection);
    }  
}

function createTables() {

    $connection = Createdb();

    $sql = "CREATE TABLE IF NOT EXISTS admin_table (
            admin_id VARCHAR(10) PRIMARY KEY,
            admin_Name VARCHAR(20) NOT NULL,
            admin_email VARCHAR(30) NOT NULL UNIQUE,
            admin_password VARCHAR(15) NOT NULL
            )";
    
    mysqli_query($connection, $sql);

    $sql = "INSERT INTO admin_table (admin_id, admin_Name, admin_email, admin_password) VALUES ('AD_Uday', 'Uday Ingale', 'uday.ingale@vit.edu', 'UdayIngale@11')";

    mysqli_query($connection, $sql);

    $sql = "CREATE TABLE IF NOT EXISTS branches (
            branch_Id VARCHAR(4) PRIMARY KEY,
            branch_Name VARCHAR(50)
    )";

    mysqli_query($connection, $sql);

    $sql = "INSERT INTO branches (branch_Id, branch_Name) VALUES ('CS', 'Computer Science')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO branches (branch_Id, branch_Name) VALUES ('IT', 'Information Technology')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO branches (branch_Id, branch_Name) VALUES ('ELE', 'Electronics')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO branches (branch_Id, branch_Name) VALUES ('ENT', 'Electronics & Telecommunication')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO branches (branch_Id, branch_Name) VALUES ('INS', 'Instrumentation')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO branches (branch_Id, branch_Name) VALUES ('MEC', 'Mechanical')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO branches (branch_Id, branch_Name) VALUES ('IND', 'Industrial')";
    mysqli_query($connection, $sql);

    $sql = "CREATE TABLE IF NOT EXISTS students (
            GR_No VARCHAR(10) PRIMARY KEY,
            first_Name VARCHAR(20) NOT NULL,
            middle_Name VARCHAR(20) NOT NULL,
            last_Name VARCHAR(20) NOT NULL,
            Email VARCHAR(35) NOT NULL UNIQUE,
            Department VARCHAR(80) NOT NULL,
            Pswd VARCHAR(12) NOT NULL,
            branch_Id VARCHAR(4),
            FOREIGN KEY(branch_Id) REFERENCES branches(branch_Id),
            Personal_Email VARCHAR(35) UNIQUE,
            C_address VARCHAR(60),
            P_addess VARCHAR(60),
            contact_No VARCHAR(12),
            guardians_contact_No VARCHAR(12),
            Semister VARCHAR(25),
            Divison VARCHAR(10),
            Roll_No VARCHAR(3),
            Elective_1 VARCHAR(30),
            Elective_2 VARCHAR(30),
            Elective_3 VARCHAR(30),
            Elective_4 VARCHAR(30)
    )";

    mysqli_query($connection, $sql);

    $sql = "CREATE TABLE IF NOT EXISTS subjects (
            subject_id VARCHAR(10) PRIMARY KEY,
            branch_Id VARCHAR(4),
            FOREIGN KEY(branch_Id) REFERENCES branches(branch_Id),
            subject_Name VARCHAR(20)   
    )";

    mysqli_query($connection, $sql);

    
    $sql = "CREATE TABLE IF NOT EXISTS classrooms (
            classroom_id VARCHAR(10) PRIMARY KEY,
            branch_Id VARCHAR(4),
            FOREIGN KEY(branch_Id) REFERENCES branches(branch_Id),            
            classroom_Name VARCHAR(20) 
    )";

    mysqli_query($connection, $sql);

    $sql = "CREATE TABLE IF NOT EXISTS teachers (
            Ref_ID VARCHAR(10) PRIMARY KEY,
            first_Name VARCHAR(20) NOT NULL,
            middle_Name VARCHAR(20) NOT NULL,
            last_Name VARCHAR(20) NOT NULL,
            Email VARCHAR(35) NOT NULL UNIQUE,
            Department VARCHAR(80) NOT NULL,
            Subjects VARCHAR(20) NOT NULL,
            Pswd VARCHAR(12) NOT NULL
            )";

    mysqli_query($connection, $sql);

}

createTables();
?>