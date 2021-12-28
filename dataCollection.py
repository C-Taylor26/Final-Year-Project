
#Importing Datetime module
import datetime

#importing csv module
import csv

#Importing functions from API module
from alpaca_api import getBarSet, getMA

#For Console Clearing
import os
clear = lambda: os.system('cls')
clear()

#Data object Class
class daysDataObj:
    def __init__(self, symbol, fiveMinChange, fiveMinVolume, daysChange, daysVolume, daysOpen, openMovingAverages, movingAverageChange):
        self.symbol = symbol
        self.fiveMinChange = fiveMinChange
        self.fiveMinVolume = fiveMinVolume
        self.daysChange = daysChange
        self.daysVolume = daysVolume
        self.daysOpen = daysOpen
        self.openMovingAverages = openMovingAverages
        self.movingAverageChange = movingAverageChange

#Class for moving Avergaes
class movingAverageObj:
    def __init__(self, twenty, fifty, twoHundered):
        self.twenty = twenty
        self.fifty = fifty
        self.twoHundered = twoHundered

#Function to collect all relevant data from given day
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
        daysClose = data[-1]['c']
        daysChange = (daysClose / daysOpen)-1

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

        daysData = daysDataObj(symbol, averageChange, averageVolume, daysChange, volume, daysOpen, openMovingAverages, movingAveragesChange)
    except:
        openMovingAverages = movingAverageObj(0,0,0)
        movingAveragesChange = movingAverageObj(0,0,0)
        daysData = daysDataObj("NULL", 0, 0, 0, 0, 0, openMovingAverages, movingAveragesChange)
    return daysData

#Converts inputted string to a valid datatime to be used by the API
def sanatiseDate(date):
    day = int(date.split('-')[0])
    month = int(date.split('-')[1])
    year = int(date.split('-')[2])

    now = datetime.datetime.now()
    start = now.replace(year=year, month=month, day=day, hour = 14, minute=30, second=0, microsecond=0).isoformat() +"Z"
    end = now.replace(year=year, month=month, day=day, hour = 21, minute=0, second=0, microsecond=0).isoformat()+"Z"
    return start, end

#Writes each line of data to csv file
def writeCSV(data):
    f = open('dataAll19-21.csv', 'a', newline="")
    writer = csv.writer(f)

    if data == 0:
        header = ["Symbol",
                  "Five_Minute_Change", 
                  "Average_Volume", 
                  "Total_Volume", 
                  "Days_Open", 
                  "Days_Change", 
                  "20MA_Open",
                  "50MA_Open",
                  "200MA_Open",
                  "20MA_Change",
                  "50MA_Change",
                  "200MA_Change"]
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
                     data.movingAverageChange.twoHundered]       
        writer.writerow(printData)
    f.close()

#Collects data over a given time period
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
        clear()
        print("{:.2f}%".format(((i+j)/2,928)*100))

startDate = datetime.datetime(day=16, month=12, year=2019)
endDate = datetime.datetime(day=16, month=12, year=2021)

stocks = ["AAPL", "TSLA", "NFLX", "FB"]
writeCSV(0)
j = 0
for symbol in stocks:
    collectData(symbol, startDate, endDate)
    j += 366