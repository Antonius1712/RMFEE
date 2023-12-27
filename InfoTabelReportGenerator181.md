
# TABLE

---

## Log Activity Engineering Fee
- ***Log_Activity_Engineering_Fee***
    - voucher varchar
    - status int
    - user_id int
    - user_name varchar
    - action varchar
    - comment text
    - next_email_role varchar
    - email_sent
    - 

    
    ### SQL :
    ```SQL
        CREATE TABLE Log_Activity_Engineering_Fee (
            Voucher Varchar(255),
            NIK Int,
            Username Varchar(75),
            Date Varchar(25),
            Time Varchar(25),
            Comment Text
        );
    ```

## Another Table
- ***Status_Engineering_Fee***
    ### Status Engineering Fee
    ```SQL
        CREATE TABLE Status_Engineering_Fee (
            id int,
            order int,
            status varchar(100),
            next_id int,
            back_id int nullable,
            primary key id
        );
    ```