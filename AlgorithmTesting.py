import pandas as pd
import random as r
from itertools import permutations

def readData(stock):  
    fields = ["Days_Change","20MA_Change","50MA_Change","200MA_Change","Next_Days_Change"]
    data = pd.read_csv("data"+stock+"19-21.csv", usecols=fields)
    data = data.values
    return data

def indicatorScoring(data):
    #check each % against next day % diff = score.
    #Average score = score
    #lowest score = best
    indicators = {"daysChange":0,"20MA":0,"50MA":0,"200MA":0}
    scores = {"daysChange":0,"20MA":0,"50MA":0,"200MA":0}
    for day in data:
        i = 0 
        for ind in indicators:
            indicators[ind] += abs(day[i] - day[4])
            i += 1
    
    for ind in indicators:
        scores[ind] = indicators[ind]/len(data)

    return scores

def getAverage(nums):
    total = 0
    for number in nums:
        total += number
    return total / len(nums)

def test(data, indicators):
    trade = False
    stats = {"tradeDays":0, "upDays":0, "score": 0}
    for day in data:
        avData = [(day[0]*indicators["daysChange"]),
                    (day[1]*indicators["20MA"]),
                    (day[2]*indicators["50MA"]),
                    (day[3]*indicators["200MA"])]
        average = getAverage(avData)
        print ("AVERAGE - {} | {} DAY".format(average, day[4]))
        if average > 0:
            trade = True
        else:
            trade = False
        if trade == True:
            stats["score"] += day[4]
            stats["tradeDays"] += 1
            if day[4] > 0:
                stats["upDays"] += 1
        
    print("Trading Days: {}/{}".format(stats["tradeDays"], len(data)))
    print("Correct Trade Days: {}/{}".format(stats["upDays"], stats["tradeDays"]))
    print("Final Score: {}".format(stats["score"]))

def randomIndicatorScores(data):
    trade = False
    stats = {"tradeDays":0, "upDays":0, "score": 0}
    indicators = {"daysChange":r.randint(-9,9),"20MA":r.randint(-9,9),"50MA":r.randint(-9,9),"200MA":r.randint(-9,9)}
    for day in data:
        avData = [(day[0]*indicators["daysChange"]),
                    (day[1]*indicators["20MA"]),
                    (day[2]*indicators["50MA"]),
                    (day[3]*indicators["200MA"])]
        average = getAverage(avData)

        if average > 0:
            trade = True
        else:
            trade = False
        if trade == True:
            stats["score"] += day[4]
            stats["tradeDays"] += 1
            if day[4] > 0:
                stats["upDays"] += 1
    
    return stats, indicators 
    
def randIndicatorsResults(stats, inds, bestStats, bestInds):
    if stats["score"] > bestStats["score"]:
        return stats, inds
    else:
        return bestStats, bestInds

def permIdicators(data, inds):
    trade = False
    stats = {"tradeDays":0, "upDays":0, "score": 0}
    
    for day in data:
        avData = [(day[0]*inds["daysChange"]),
                    (day[1]*inds["20MA"]),
                    (day[2]*inds["50MA"]),
                    (day[3]*inds["200MA"])]
        average = getAverage(avData)

        if average > 0:
            trade = True
        else:
            trade = False
        if trade == True:
            stats["score"] += day[4]
            stats["tradeDays"] += 1
            if day[4] > 0:
                stats["upDays"] += 1
    
    return stats 

def generateList(numberRange):
    bottom = 0 - numberRange +1
    top = numberRange

    nums = []
    for i in range(bottom, top):
        nums.append(i)
    print (nums)
    return nums


data = readData("FB")

perms = permutations(generateList(10), 4)

bestIndicators = {"daysChange":1,"20MA":1,"50MA":1,"200MA":1}
bestStats = permIdicators(data, bestIndicators)
print ("Benchmark Score: {}".format(bestStats["score"]))

for p in list(perms):
    indicators = {"daysChange":p[0],"20MA":p[1],"50MA":p[2],"200MA":p[3]}
    stats = permIdicators(data, indicators)
    if stats["score"] > bestStats["score"]:
        bestStats = stats
        bestIndicators = indicators
        print (stats["score"])

print(bestStats)
print(bestIndicators)

