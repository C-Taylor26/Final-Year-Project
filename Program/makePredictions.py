from dbConnection import *
from NeuralNetwork import NeuralNetwork

def getInputs(stock):
    data = getStockData(stock, "training")

    inputData = []
    targets = []
    changes = []

    for point in data:
        daysData = []
        daysData.append(point[3])
        for i in range(4, 12):
            daysData.append(float(point[i]))
        inputData.append(daysData)

        changes.append(point[12])

        target = []
        t = 1 if point[12] > 0 else 0 
        target.append(t)
        targets.append(target)

    return inputData, targets, changes

def trainNN(architecture, learingRate, epochs, inputs, targets):
    nn = NeuralNetwork(architecture, learingRate)
    nn.fit(inputs, targets, epochs)

    return nn

def testNetwork(stock, nn):
    testingSet, testingTargets, changes = getInputs(stock, "testing")
    predictions = []
    result = []
    correctPreds = 0

    for i in range(testingSet):
        pred = nn.predict(testingSet[i])
        predictions.append(pred)

        if pred > .5:
            result += changes[i]
            if testingTargets[i][0] > 0:
                correctPreds += 1
        else:
            result -= changes[i]
            if testingTargets[i][0] < 0:
                correctPreds += 1
    
    print("Trading Score: {}\nAccuracy: {}".format(result, (correctPreds/len(testingSet))))

def networkSetup():
    network = []
    netArc = [5]
    while True:
        newLayer = int(input("Hidden Layer Neurons (0 if no more to add): "))
        if newLayer == 0:
            break
        else:
            netArc.append(newLayer)
    
    netArc.append(1)
    network.append(netArc)

    epochs = input("Number of iterations: ")
    network.append(epochs)

    learningRate = input("Network Learning Rate: ")



            