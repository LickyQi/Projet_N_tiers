# Projet_N_tiers
Sujet TD Architecture N-Tiers 2019-2020

## Qi LI

![image](https://github.com/LickyQi/Projet_N_tiers/blob/master/LAMP.jpg)


### Tools  
- Apache, PHP, Html5, MySQL, Javascript, PHPMailer, pdf2text, Google Email API, Bootstrap

### Objective  
- Realise a simple and basic system to add, edit, delete and view the contract in the web. 

### Code 

#### 1. You should run MySQL script first in **database.sql** file to create database ntiers and tables Contracts.
#### 2. **configure.php** is for the connection of the database using PHP.
        mysql_connect is deprecated, so I use mysqli_connect to connect PHP and MySql.
#### 3. **index.php** is the Login page to connect to the ldap server and authenticate the user,
        I use the Bootstrap to design the item.
#### 4. **contract.php**  is the main page with the table of contracts and some operation button.
#### 5. **add_contract.php** implements the function to add a new contract.
#### 6. **edit_contract.php** show the page to edit a existing contract
        Most of the part of this PHP are same to the add_contract.php
#### 6. **delete_contract.php** implements the delete function.
#### 7. **validate.php** implements a function to validate a contract and to sent a e-mail to inform.
        I use PHPMailer and Google Email API to realise this function.
#### 8. **show_pdf.php** just implements the function to show the PDF
#### 9. **PHPMailer** is for the page of email using Google Email API.
#### 10. **pdf2text** changes the pdf to text for searching the key word
