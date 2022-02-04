import random
import pandas as pd

def readData(stock):
    
    fields = ["Next_Days_Change"]
    data = pd.read_csv("data"+stock+"19-21.csv", usecols=fields)
    data = data.values
    return data


def randomResults(data):
    score = 0 
    for day in data:
        rand = random.random()
        if rand > 0.5:
            score += day


    return score
        
print(randomResults(readData("AAPL")))
