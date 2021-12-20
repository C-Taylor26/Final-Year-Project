######
# 
# Collects data points from a given day 
#
# To be used as a starting point for older data that will be used in training
# 
# later used each day to keep data up to date
#   
##### 

# 
# Data Points [5min average Change and Volume, total change and volume, Ma change, MA start, day start]
# 

#Importing Datetime module
import datetime

#importing csv module
import csv
from os import write

#Importing functions from API module
from alpaca_api import getBarSet, getMA

class daysDataObj:
    def __init__(self, symbol, fiveMinChange, fiveMinVolume, daysChange, daysVolume, daysOpen, openMovingAverages, movingAverageChange, nextDayChange):
        self.symbol = symbol
        self.fiveMinChange = fiveMinChange
        self.fiveMinVolume = fiveMinVolume
        self.daysChange = daysChange
        self.daysVolume = daysVolume
        self.daysOpen = daysOpen
        self.openMovingAverages = openMovingAverages
        self.movingAverageChange = movingAverageChange
        self.nextDayChange = nextDayChange

class movingAverageObj:
    def __init__(self, twenty, fifty, twoHundered):
        self.twenty = twenty
        self.fifty = fifty
        self.twoHundered = twoHundered

def getDaysData(symbol, date):
    start, end = sanatiseDate(date)
    try:
        openMovingAverages = movingAverageObj(getMA(symbol, 20, start), getMA(symbol, 50, start), getMA(symbol, 200, start))
        closeMovingAverages = movingAverageObj(getMA(symbol, 20, end), getMA(symbol, 50, end), getMA(symbol, 200, end))
        movingAveragesChange = movingAverageObj((closeMovingAverages.twenty/openMovingAverages.twenty)-1,
                                                (closeMovingAverages.fifty/openMovingAverages.fifty)-1,
                                                (closeMovingAverages.twoHundered/openMovingAverages.twoHundered)-1)
        
        data = getBarSet(symbol, start, end)

        daysOpen = data[0]['o']

        change = 0
        volume = 0

        for bar in data:
            change += (float(bar['c']) / float(bar['o']) -1)
            volume += bar['v']

        averageChange = change / len(data)
        averageVolume = volume / len(data)

        splitDate = end.split("-")
        day = int(splitDate[2].split("T")[0])
        month = int(splitDate[1])
        year = int(splitDate[0])

        newDate = datetime.datetime(day=day, month=month, year=year)
        if newDate.weekday() == 5:
            newDate = newDate + datetime.timedelta(days=2)
        elif newDate.weekday() == 4:
            newDate = newDate + datetime.timedelta(days=3)
        else:
            newDate = newDate + datetime.timedelta(days=1)

        newStart, newEnd = sanatiseDate(newDate.strftime("%d-%m-%Y"))

        r = getBarSet(symbol, newStart, newEnd)
    
    
        nextDayOpen = float(r[0]["o"])
        nextDayClose = float(r[-1]["c"])
        nextDayChange = (nextDayClose / nextDayOpen) - 1

        daysData = daysDataObj(symbol, averageChange, averageVolume, change, volume, daysOpen, openMovingAverages, movingAveragesChange, nextDayChange)
    except:
        openMovingAverages = movingAverageObj(0,0,0)
        movingAveragesChange = movingAverageObj(0,0,0)
        daysData = daysDataObj("NULL", 0, 0, 0, 0, 0, openMovingAverages, movingAveragesChange, 0)
    return daysData

def sanatiseDate(date):
    day = int(date.split('-')[0])
    month = int(date.split('-')[1])
    year = int(date.split('-')[2])

    now = datetime.datetime.now()
    start = now.replace(year=year, month=month, day=day, hour = 0, minute=0, second=0, microsecond=0).isoformat() +"Z"
    end = now.replace(year=year, month=month, day=day, hour = 23, minute=59, second=59, microsecond=0).isoformat()+"Z"
    return start, end

def writeCSV(data):
    f = open('csvData.csv', 'a', newline="")
    writer = csv.writer(f)

    if data == 0:
        header = ["Symbol",
                  "Five Minute Change", 
                  "Average Volume", 
                  "Total Volume", 
                  "Days Open", 
                  "Days Change", 
                  "20MA Open",
                  "50MA Open",
                  "200MA Open",
                  "20MA Change",
                  "50MA Change",
                  "200MA Change",
                  "Next Day Change"]
        writer.writerow(header)
    else:
        printData = [data.symbol,
                     data.fiveMinChange,
                     data.fiveMinVolume,
                     data.daysVolume,
                     data.daysOpen,
                     data.daysChange,
                     data.openMovingAverages.twenty,
                     data.openMovingAverages.fifty,
                     data.openMovingAverages.twoHundered,
                     data.movingAverageChange.twenty,
                     data.movingAverageChange.fifty,
                     data.movingAverageChange.twoHundered,
                     data.nextDayChange]       
        writer.writerow(printData)
    f.close()

def collectData(symbol, startDate, endDate):
    i = 0
    date = startDate
    while date != endDate:
        date = startDate + datetime.timedelta(days=i)
        if date.weekday() > 4:
            i +=1
        else:
            daysData = getDaysData(symbol, date.strftime("%d-%m-%Y"))
            writeCSV(daysData)
            i +=1
        print(i)

startDate = datetime.datetime(day=16, month=12, year=2020)
endDate = datetime.datetime(day=16, month=12, year=2021)

stocks = ["AAPL", "TSLA", "NFLX", "FB"]
writeCSV(0)

for symbol in stocks:
    collectData(symbol, startDate, endDate)