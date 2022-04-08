#MySQL Module for database connections
import mysql.connector

def getStockData(stock, dataType):
    sql = "SELECT * FROM data WHERE datatype='{}' AND stock='{}' ORDER BY date".format(dataType, stock)
    return dbSatement(sql)

def dbSatement(sql):
    db = mysql.connector.connect(host="localhost", user="root", password="",database="fyp")
    cursor = db.cursor()
    cursor.execute(sql)
    results = cursor.fetchall()
    return results

results = getStockData("NFLX", "testing")

for x in results:
    print (x)