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

from alpaca_api import getCandle

class daysDataObj:
    def __init__(self, fiveMinChange, fiveMinVolume, daysChange, daysVolume, daysOpen):
        self.fiveMinChange = fiveMinChange
        self.fiveMinVolume = fiveMinVolume
        self.daysChange = daysChange
        self.daysVolume = daysVolume
        self.daysOpen = daysOpen

def getDaysData(symbol, date):
    
    data = getCandle(symbol, date)

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

stocks = ["AAPL", "TSLA", "NFLX", "FB"]
dates = ["14-12-2021", "15-12-2021", "16-12-2021"]
for symbol in stocks:
    for date in dates:
        getDaysData(symbol, date)
    


