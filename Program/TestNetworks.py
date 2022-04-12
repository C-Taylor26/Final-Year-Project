from dbConnection import *
from NeuralNetwork import NeuralNetwork
import numpy as np
import neurolab as nl
from getWeeklyData import getWeekly

def getWeeklyInputs(stock):
    data = getWeekly(stock)

    returnData = {"trainingIns":[], "trainingTs":[], "testingIns":[], "testingTs":[], "testingCs":[]}

    i = 0
    for week in data:
        weekData = []
        weekData.append(week.change)
        weekData.append(week.maChanges["20"])
        weekData.append(week.maChanges["50"])
        weekData.append(week.maChanges["200"])
        target = 1 if week.nextWeekChange > 0 else 0
        if i > 25:
            returnData["trainingIns"].append(weekData)
            returnData["trainingTs"].append([target])
        else:
            returnData["testingIns"].append(weekData)
            returnData["testingTs"].append([target])
            returnData["testingCs"].append(week.change)

        i+=1

    returnData["trainingIns"] = np.array(returnData["trainingIns"])
    returnData["trainingTs"] = np.array(returnData["trainingTs"])
    returnData["testingIns"] = np.array(returnData["testingIns"])
    returnData["testingTs"] = np.array(returnData["testingTs"])

    return returnData

def getDailyInputs(stock, dataType):
    data = getStockData(stock, dataType)

    inputData = []
    targets = []
    changes = []

    for point in data:
        daysData = []
        #daysData.append(point[3])

        #Days Price Change
        change = float((point[5] - point[4])/point[4])
        daysData.append(change)

        #Moving Averages Changes
        for i in range(6, 9):
            change = float((point[i+3] - point[i])/point[i])
            daysData.append(change)

        inputData.append(daysData)

        changes.append(point[12])

        target = []
        t = 1 if point[12] > 0 else 0 
        target.append(t)
        targets.append(target)

    return np.array(inputData), np.array(targets), changes

def trainNN(architecture, learingRate, epochs, inputs, targets):
    nn = NeuralNetwork(architecture, learingRate)
    nn.fit(inputs, targets, epochs)

    return nn

def testNetwork(stock, nn):

    if testType == "d":
        testingSet, testingTargets, changes = getDailyInputs(stock, "testing")
    else:
        testingSet = data["testingIns"]
        testingTargets = data["testingTs"]
        changes = data["testingCs"]
    
    predictions = []
    result = 0
    correctPreds = 0

    randResult =0
    randCorr =0

    libResult =0
    libCorr =0
    
    nlOut = neurolabTest(stock, nlSetup)

    for i in range(len(changes)):
        pred = nn.predict(testingSet[i])
        predictions.append(pred)

        if pred > .5:
            result += changes[i]
            if testingTargets[i][0] == 1:
                correctPreds += 1
        else:
            result -= changes[i]
            if testingTargets[i][0] == 0:
                correctPreds += 1

        rand = np.random.random()
        if rand > .5:
            randResult += changes[i]
            if testingTargets[i][0] == 1:
                randCorr += 1
        else:
            randResult -= changes[i]
            if testingTargets[i][0] == 0:
                randCorr += 1

        nlPred = nlOut[i][0]
        if nlPred > .5:
            randResult += changes[i]
            if testingTargets[i][0] == 1:
                libCorr += 1
        else:
            randResult -= changes[i]
            if testingTargets[i][0] == 0:
                libCorr += 1

        

    print("Network - Trading Score: {}\tAccuracy: {}".format(result, (correctPreds/len(testingSet))))
    print("Library - Trading Score: {}\tAccuracy: {}".format(libResult, (libCorr/len(testingSet))))
    print("Random  - Trading Score: {}\tAccuracy: {}".format(randResult, (randCorr/len(testingSet))))
    

def neurolabTest(stock, layers):
    if testType == "d":
        x, y, changes = getDailyInputs(stock, "training")
        testingInputs, testingTargets, testingChanges = getDailyInputs(stock, "testing")
    else:
        testingInputs = data["testingIns"]
        x = data["trainingIns"]
        y = data["trainingTs"]

    size = len(x)

    inputs = {"0":[], "1":[], "2":[], "3":[]}

    for set in x:
        inputs["0"].append(set[0])
        inputs["1"].append(set[1])
        inputs["2"].append(set[2])
        inputs["3"].append(set[3])

    for set in testingInputs:
        inputs["0"].append(set[0])
        inputs["1"].append(set[1])
        inputs["2"].append(set[2])
        inputs["3"].append(set[3])

    maxVals = {"0": max(inputs["0"]), "1": max(inputs["1"]), "2": max(inputs["2"]), "3": max(inputs["3"])}
    minVals = {"0": min(inputs["0"]), "1": min(inputs["1"]), "2": min(inputs["2"]), "3": min(inputs["3"])}

    minmax = [[minVals["0"], maxVals["0"]], [minVals["1"], maxVals["1"]], [minVals["2"], maxVals["2"]], [minVals["3"], maxVals["3"]]]

    network = nl.net.newff(minmax, layers)

    err = network.train(x,y, epochs=10000, show=100)

    out = network.sim(testingInputs)
    return out


stock = "AMD"
setup = [[4,10,10,10,1], 10000, .1]
nlSetup = setup[0][1:]
testType = "w" #d - Daily | w - Weekly
data = getWeeklyInputs(stock)

if testType == "d":
    trainingSet, trainingTargets, changes = getDailyInputs(stock, "training")
else:
    trainingSet = data["trainingIns"]
    trainingTargets = data["trainingTs"]


network = trainNN(setup[0], setup[2], setup[1], trainingSet, trainingTargets)
testNetwork(stock, network)
