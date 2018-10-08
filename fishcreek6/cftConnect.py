import mysql.connector

conn = mysql.connector.connect(user="root",password="Qry3_!zrY&8jSV4", host="127.0.0.1", database="cft")
cursor = conn.cursor()



cursor.execute("SELECT * FROM portals")

for i in cursor:
    print(i)




cursor.close()
conn.close()