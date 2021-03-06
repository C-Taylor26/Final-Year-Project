#Datetime module
import datetime

#Time Module
import time

#MySQL Module for database connections
import mysql.connector 

#Alpaca API functions
from alpaca_api import getBarSet, getMASet

#Hashing Library
import hashlib

#Data Object
class daysDataObj:
    def __init__(self, stock, date, daysVolume, daysOpen, daysClose, openMovingAverages, closeMovingAverages, nextDayChange):
        self.stock = stock
        self.date = date
        self.daysVolume = daysVolume
        self.daysOpen = daysOpen
        self.daysClose = daysClose
        self.openMovingAverages = openMovingAverages
        self.closeMovingAverages = closeMovingAverages
        self.nextDayChange = nextDayChange

#Moving Avergaes Object
class movingAverageObj:
    def __init__(self, twenty, fifty, twoHundered):
        self.twenty = twenty
        self.fifty = fifty
        self.twoHundered = twoHundered

###
# Given Symbol - get data for 2 date ranges/
# Training 01/01/2021
# Testing 01/01/2022
# 
# Upload each day to database (correct table)
# Do for single stock 
    
def getDaysData(date):
    #Getting Dates Market hours
    start, end = getMarketTimes(date)

    #Opening Moving Averages
    twenty, fifty, twoHundered = getMAs(start)
    openMovingAverages = movingAverageObj(twenty, fifty, twoHundered)

    #Closing Moving Averages 
    twenty, fifty, twoHundered = getMAs(end)
    closeMovingAverages = movingAverageObj(twenty, fifty, twoHundered)

    #Days Data
    data = getBarSet(stock, start, end)

    #Len 0 when weekend/holiday
    if len(data) != 0:
        daysOpen = data[0]['o']
        daysClose = data[-1]['c']
    else:
        return 0

    #Days Total Volume
    volume = 0
    for bar in data:
            volume += bar['v']

    nextDayChange = "X"
    i = 1
    while nextDayChange == "X":
        nextDay = date + datetime.timedelta(days=i)
        nextDayStart, nextDayEnd = getMarketTimes(nextDay)

        nextDayData = getBarSet(stock, nextDayStart, nextDayEnd)

        if len(nextDayData) != 0:
            open = nextDayData[0]['o']
            close = nextDayData[-1]['c']
            nextDayChange = (float(close)/float(open)-1)
        else:
            i += 1

    daysData = daysDataObj(stock, date, volume, daysOpen, daysClose, openMovingAverages, closeMovingAverages, nextDayChange)
    
    return daysData
    
def getMarketTimes(date):
    start = date.replace(hour = 14, minute=30, second=0, microsecond=0).isoformat() +"Z"
    end = date.replace(hour = 21, minute=0, second=0, microsecond=0).isoformat() +"Z"
    return start, end

def getMAs(end):
    data = getMASet(stock, 200, end)

    MAs = [data[-20:], data[-50:], data]

    calculated = []
    for timeframe in MAs:
        total = 0
        for bar in timeframe:
            total += bar['c']
        average = total/len(timeframe)
        average = round(average, 2)
        calculated.append(average)
        
    return calculated[0], calculated[1], calculated[2]

def getData():
    #Training Data ~12 months (15-08-20/15-08-21)
    #Testing Data ~6 Months (15-08-21/15-02-22)
    startDate = datetime.datetime(year=2020, month =8, day=15)
    trainingEnd = datetime.datetime(year=2021, month =8, day=15)
    endDate = (datetime.datetime.now() - datetime.timedelta(days=1))

    date = startDate
    while date < endDate:
        #Checking Date range to classify as trainging or testing
        if date > trainingEnd:
            table = "testing"
        else:
            table = "training"

        data = getDaysData(date)
        #0 returned for null data (Weekend)
        if data != 0:
            dataUpload(table, data)
            time.sleep(1)
        date += datetime.timedelta(days=1)


def dataUpload(datatype, data): #Uploads data to given table in database
    db = mysql.connector.connect(host="localhost", user="root", password="",database="fyp")

    upload = db.cursor()

    columns = "stock, date, volume, open, close, 20ma_open, 50ma_open, 200ma_open, 20ma_close, 50ma_close, 200ma_close, next_day_change, datatype, hash"
    #Formatting Data
    oMAs = data.openMovingAverages
    cMAs = data.closeMovingAverages
    MAs = "{}, {}, {}, {}, {}, {}".format(oMAs.twenty, oMAs.fifty, oMAs.twoHundered, cMAs.twenty, cMAs.fifty, cMAs.twoHundered)
    date = data.date.strftime("%Y-%m-%d")
    values = "'{}', '{}', {}, {}, {}, {}, {}, '{}'".format(data.stock, date, data.daysVolume, data.daysOpen, data.daysClose, MAs, data.nextDayChange, datatype)

    input = "{}, '{}'".format(values, hashlib.sha256(values.encode()).hexdigest())

    sql = "insert into data ({}) values ({})".format(columns, input)
    upload.execute(sql)
    db.commit()
    db.close()
    print("{} --- {}".format(stock, date))

def stockUpload(ticker, name):
    db = mysql.connector.connect(host="localhost", user="root", password="",database="fyp")
    upload = db.cursor()

    columns = "ticker, name"

    input = "'{}', '{}'".format(ticker, name)
    sql = "insert into stocks ({}) values ({})".format(columns, input)
    upload.execute(sql)
    db.commit()
    db.close()

stocks = {"NFLX":"Netflix", "AAPL":"Apple", "SPY":"S&P 500", "AMD":"AMD",}
for s in stocks:
    stockUpload(s, stocks[s])
    stock = s
    getData()