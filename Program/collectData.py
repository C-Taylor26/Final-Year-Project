#Datetime module
from calendar import month
import datetime

from webob import day, year

#Alpaca API functions
from alpaca_api import getBarSet, getMASet

#Data Object
class daysDataObj:
    def __init__(self, symbol, date, daysVolume, daysOpen, daysClose, openMovingAverages, closeMovingAverages):
        self.symbol = symbol
        self.date = date
        self.daysVolume = daysVolume
        self.daysOpen = daysOpen
        self.daysClose = daysClose
        self.openMovingAverages = openMovingAverages
        self.closeMovingAverages = closeMovingAverages

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
    start = date.replace(hour = 14, minute=30, second=0, microsecond=0).isoformat() +"Z"
    end = date.replace(hour = 21, minute=0, second=0, microsecond=0).isoformat() +"Z"

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

    daysData = daysDataObj(stock, date, volume, daysOpen, daysClose, openMovingAverages, closeMovingAverages)
    
    return daysData
    
def getMAs(end):
    data = getMASet(stock, 200, end)

    MAs = [data[-20:], data[-50:], data]

    calculated = []
    for timeframe in MAs:
        total = 0
        for bar in timeframe:
            total += bar['c']
        average = total/len(timeframe)
        calculated.append(average)
        
    return calculated[0], calculated[1], calculated[2]

def getData():
    #Block of data (Limiting DB calls and RAM usage)
    dataBlock = []

    #Training Data ~12 months (31-08-20/15-08-21)
    #Testing Data 6 Months (15-08-21/15-02-22)
    startDate = datetime.datetime(year=2020, month =8, day=31)
    endDate = (datetime.datetime.now() - datetime.timedelta(days=1))

    date = startDate
    while date < endDate:
        if len(dataBlock) == 10:
            dataBlock = []
            pass #Upload data

        data = getDaysData(date)
        #0 returned for null data (Weekend)
        if data != 0:
            dataBlock.append(data)
            print ("{} --- {}".format(data.daysOpen, data.date))
        
        
        date += datetime.timedelta(days=1)

stock = "AAPL"

getData()