#MySQL Module for database connections
import mysql.connector
import hashlib

def getStockData(stock, dataType):
    sql = "SELECT * FROM data WHERE datatype='{}' AND stock='{}' ORDER BY date".format(dataType, stock)
    results = dbSatement(sql)
    """if validateHash(results):
        return results
    else:
        return "Validatoin Issue"""
    return results

def dbSatement(sql):
    db = mysql.connector.connect(host="localhost", user="root", password="",database="fyp")
    cursor = db.cursor()
    cursor.execute(sql)
    results = cursor.fetchall()
    return results

def validateHash(data):
    for x in data:
        hash = x[14]
        datapoints = "'{}', '{}', {}, {}, {}, {}, {}, {}, {}, {}, {}, {}, '{}'".format(x[1],x[2],x[3],x[4],x[5],x[6],x[7],x[8],x[9],x[10],x[11],float(x[12]), x[13])
        testHash = hashlib.sha256(datapoints.encode()).hexdigest()
        if hash == testHash:
            return False

    return True

def getStocks():
    sql = "SELECT * FROM stocks"
    results = dbSatement(sql)
    return results

