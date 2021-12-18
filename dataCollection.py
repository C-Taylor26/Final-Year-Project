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
# Data Points [Average 5m/30m/1h Change, Days change, Average 5m/30m/1h volume, days Volume, 20/50/200 MA change/end, days candle]
# 

class daysDataObj:
    def __init__(self, changeData, volumeData, maData, dayCandle):
        self.changeData = changeData
        self.volumeData = volumeData
        self.maData = maData
        self.dayCandle = dayCandle

class dataTimeFrameObj:
    def __init__(self, fiveMin, thirtyMin, oneHour, day):
        self.fiveMin = fiveMin
        self.thirtyMin = thirtyMin
        self.oneHour = oneHour
        self.day = day

class maDataObj:
    def __init__(self, twentyChange, fiftyChange, twoHunderedChange, twentyEnd, fiftyEnd, twoHunderedEnd):
        self.twentyChange = twentyChange
        self.fiftyChange = fiftyChange
        self.twoHunderedChange = twoHunderedChange
        self.twentyEnd = twentyEnd
        self.fiftyEnd = fiftyEnd
        self.twoHunderedEnd = twoHunderedEnd
        