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

#Importing functions from API module
from alpaca_api import getBarSet, getMA

class daysDataObj:
    def __init__(self, fiveMinChange, fiveMinVolume, daysChange, daysVolume, daysOpen, openMovingAverages, closeMovingAverages):
        self.fiveMinChange = fiveMinChange
        self.fiveMinVolume = fiveMinVolume
        self.daysChange = daysChange
        self.daysVolume = daysVolume
        self.daysOpen = daysOpen
        self.openMovingAverages = openMovingAverages
        self.closeMovingAverages = closeMovingAverages

class movingAverageObj:
    def __init__(self, twenty, fifty, twoHundered):
        self.twenty = twenty
        self.fifty = fifty
        self.twoHundered = twoHundered

def getDaysData(symbol, date):
    start, end = sanatiseDate(date)
    openMovingAverages = movingAverageObj(getMA(symbol, 20, start), getMA(symbol, 50, start), getMA(symbol, 200, start))
    closeMovingAverages = movingAverageObj(getMA(symbol, 20, end), getMA(symbol, 50, end), getMA(symbol, 200, end))

    data = getBarSet(symbol, start, end)

    daysOpen = data[0]['o']

    change = 0
    volume = 0

    for bar in data:
        change += (float(bar['c']) / float(bar['o']) -1)
        volume += bar['v']

    averageChange = change / len(data)
    averageVolume = volume / len(data)

    daysData = daysDataObj(averageChange, averageVolume, change, volume, daysOpen)
    print (vars(daysData))

def sanatiseDate(date):
    day = int(date.split('-')[0])
    month = int(date.split('-')[1])
    year = int(date.split('-')[2])

    now = datetime.datetime.now()
    start = now.replace(year=year, month=month, day=day, hour = 0, minute=0, second=0, microsecond=0).isoformat() + "Z"
    end = now.replace(year=year, month=month, day=day, hour = 23, minute=59, second=59, microsecond=0).isoformat() + "Z"
    return start, end

stocks = ["AAPL", "TSLA", "NFLX", "FB"]
dates = ["14-12-2021", "15-12-2021", "16-12-2021"]
for symbol in stocks:
    for date in dates:
        getDaysData(symbol, date)
    


