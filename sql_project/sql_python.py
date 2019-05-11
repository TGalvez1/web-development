import mysql.connector
import os
"""
Plan:
    Create a database with python
    Insert into tables
    Update records
    Select various fields and use them in python
    Library
"""

def insertBook(conn):
    cursor = conn.cursor()
    name = input("Name of Book: ")
    author = input("Author of Book: ")
    genre = input("Genre of Book: ")
    cursor.execute(f"INSERT INTO books (name,author,genre) VALUES (\"{name}\",\"{author}\",\"{genre}\");")
    conn.commit()
    cursor.close()
    
    print("The book was inserted successfully!")
    os.system("pause")
    
    menu(conn)

def insertUser(conn):
    cursor = conn.cursor()
    username = input("Username: ")
    email = input("Email Address: ")

    cursor.execute(f"INSERT INTO users (username,email) VALUES (\"{username}\",\"{email}\");")
    conn.commit()
    cursor.close()
    
    print("The users information was inserted successfully!")
    os.system("pause")
    
    menu(conn)

def updateUser(conn):
    cursor = conn.cursor()
    os.system("cls")
    print("What user information would you like to update: ")
    print("1. Email")
    print("2. Amount owed")
    choice = input("Selection: ")
    
    if choice.isnumeric():
        choice = int(choice)
        if choice == 1:
            current_email = input("Please input the current email address: ")
            new_email = input("Please input the new email address: ")
            cursor.execute(f"UPDATE users SET email = \"{new_email}\" WHERE email = \"{current_email}\"; ")
            conn.commit()
        elif choice == 2:
            print("What is the users affliction: ")
            print("1. Must return a book")
            print("2. Damaged a book")
            choice2 = input("Selection: ")
            if choice2 == "1":
                email = input("Users email address: ")
                book_title = input("What book needs to be returned: ")
                cursor.execute(f"SELECT book_id FROM books WHERE name = \"{book_title}\";")
                book_id = cursor.fetchall()[0][0]
                cursor.execute(f"SELECT user_id FROM users WHERE email = \"{email}\";")
                user_id = cursor.fetchall()[0][0]
                cursor.execute(f"INSERT INTO users_x_returns (user_id, book_id, description, fee) VALUES ({user_id},{book_id},\"User has an overdue book\",20.00);")
                conn.commit()
                cursor.execute(f"UPDATE users SET amount_owed = (SELECT SUM(fee) FROM users_x_returns WHERE user_id = {user_id}) WHERE user_id = {user_id};")
                conn.commit()
            elif choice2 == "2":
                email = input("Users email address: ")
                book_title = input("What book has been damaged: ")
                cursor.execute(f"SELECT book_id FROM books WHERE name = \"{book_title}\";")
                book_id = cursor.fetchall()[0][0]
                cursor.execute(f"SELECT user_id FROM users WHERE email = \"{email}\";")
                user_id = cursor.fetchall()[0][0]
                cursor.execute(f"INSERT INTO users_x_returns (user_id, book_id, description, fee) VALUES ({user_id},{book_id},\"User has destroyed a book\", 100.00);")
                conn.commit()
                cursor.execute(f"UPDATE users SET amount_owed = (SELECT SUM(fee) FROM users_x_returns WHERE user_id = {user_id}) WHERE user_id = {user_id};")
                conn.commit()
                cursor.execute(f"UPDATE books SET needs_repair = 1 WHERE book_id = {book_id};")
                conn.commit()
    
    print("The updated information was inserted successfully!")
    os.system("pause")
    
    cursor.close()
    menu(conn)


def updateBook(conn):
    cursor = conn.cursor()
    os.system("cls")
    print("What book information would you like to update: ")
    print("1. Book checked out")
    print("2. Book damaged")
    choice = input("Selection: ")

    if choice == "1":
        book_title = input("What book has been checked out: ")
        cursor.execute(f"SELECT book_id FROM books WHERE name = \"{book_title}\";")
        book_id = cursor.fetchall()[0][0]
        cursor.execute(f"UPDATE books SET checked_out = 1 WHERE book_id = {book_id};")
        conn.commit()
    if choice == "2":
        book_title = input("What book has been checked out: ")
        cursor.execute(f"SELECT book_id FROM books WHERE name = \"{book_title}\";")
        book_id = cursor.fetchall()[0][0]
        cursor.execute(f"UPDATE books SET needs_repair = 1 WHERE book_id = {book_id};")
        conn.commit()
    
    print("The updated information was inserted successfully!")
    os.system("pause")

    cursor.close()
    menu(conn)

def showBooks(conn):
    cursor = conn.cursor()
    os.system("cls")
    cursor.execute("SELECT * FROM books;")
    books = cursor.fetchall()
    print("Here are all the books currently in the library: ")
    for book in books:
        book_id = book[0]
        name = book[1]
        checked_out = book[2]
        author = book[3]
        genre = book[4]
        damaged = book[5]
        if checked_out == 1:
            checked_out = "true"
        else:
            checked_out = "false"
        if damaged == 1:
            damaged = "true"
        else:
            damaged = "false"
        print(f"{book_id}. {name}  \tAuthor:  {author}  \tGenre: {genre}  \tChecked Out: {checked_out} \tDamaged: {damaged}")

    os.system("pause")
    menu(conn)

def showUsers(conn):
    cursor = conn.cursor()
    os.system("cls")
    cursor.execute("SELECT user_id,username FROM users;")
    users = cursor.fetchall()
    print("Here are all the currently registered users: ")
    for user in users:
        user_id = user[0]
        name = user[1]

        print(f"{user_id}. {name}")
    
    os.system("pause")
    menu(conn)

def menu(conn):
    os.system("cls")
    print("Welcome to your public library database")
    print("You can access, update, and see return information for ALL books and users")
    print("1. Add a book to the library")
    print("2. Register a new user to the library")
    print("3. Update an existing books information")
    print("4. Update an existing users information")
    print("5. Show books in library")
    print("6. Show registered users")
    print("7. Exit")

    choice = input("Selection: ")

    if choice.isnumeric():
        choice = int(choice)
    else:
        print("Your input must be a number")
        os.system("pause")
        menu(conn)

    if choice == 1:
        insertBook(conn)
    elif choice == 2:
        insertUser(conn)
    elif choice == 3:
        updateBook(conn)
    elif choice == 4:
        updateUser(conn)
    elif choice == 5:
        showBooks(conn)
    elif choice == 6:
        showUsers(conn)
    else:
        exit()


if __name__ == "__main__":
    conn = mysql.connector.connect(user="root", password="",host="127.0.0.1",port=3306,database="sql_project")
    menu(conn)
