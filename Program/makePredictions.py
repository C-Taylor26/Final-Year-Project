#get stock from table 
#get stcoks training data
#put data into NN readable format
#run nn
#run testing data
#record accuracy & final score 

from dbConnection import *

def getInputs(stock):
    data = getStockData(stock, "training")

    inputData = []
    targets = []
    for point in data:
        daysData = []
        daysData.append(point[3])
        for i in range(4, 12):
            daysData.append(float(point[i]))
        target = []
        target.append(point[12])
        targets.append(target)
        inputData.append(daysData)

    return inputData, targets

def 