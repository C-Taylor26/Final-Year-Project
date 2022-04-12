import requests
from keys import *

class Week:
    def __init__(self, date, open, close, change, maChanges, nextWeekChange):
        self.date = date
        self.open = open
        self.close = close
        self.change = change
        self.maChanges = maChanges
        self.nextWeekChange = nextWeekChange

def getWeekly(stock):
    json = {"function":"TIME_SERIES_WEEKLY","symbol":stock,"datatype":"json"}
    r = requests.request("GET", VANTAGE_URL, headers=VANTAGE_HEADERS, params=json)
    data = r.json()

    data = data['Weekly Time Series']
    weeklyData = []
    count = -1
    for week in data:
        if count < 0:
            count +=1
            continue
        elif count > 104:
            break
        else:
            open = float(data[week]["1. open"])
            close = float(data[week]["4. close"])

            if len(weeklyData) != 0:
                nwc = weeklyData[count-1].change
            else:
                nwc = 0

            newWeek = Week(week, open, close, ((close-open)/open), {"20":0,"50":0,"200":0}, nwc)
            weeklyData.append(newWeek)
            count +=1
        
    weeklyData = getMAs(stock, weeklyData[1:])
    
    return weeklyData

def getMAs(stock, weeklyData):
    for tp in ["20", "50", "200"]:
        json = {"time_period":tp,
                       "interval":"daily",
                       "series_type":"close",
                       "function":"SMA",
                       "symbol":stock,
                       "datatype":"json"}
        r = requests.request("GET", VANTAGE_URL, headers=VANTAGE_HEADERS, params=json)
        data = r.json()
        data = data["Technical Analysis: SMA"]

        maArray = []
        for item in data:
            maArray.append({"date":item,"ma":data[item]["SMA"]})

        i = 0
        for week in weeklyData:
            i = 0
            while True:
                if maArray[i]["date"] == week.date:
                    close = float(maArray[i]["ma"])
                    open = float(maArray[i+4]["ma"])
                    change = (close - open)/open
                    week.maChanges[tp] = change
                    break
                i +=1
    
    return weeklyData

