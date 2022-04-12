import numpy as np
import neurolab as nl
from makePredictions import getInputs

def neurolabTest(stock, layers):
    x, y, changes = getInputs(stock, "training")
    testingInputs, testingTargets, testingChanges = getInputs(stock, "testing")

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

    network = nl.net.newff(minmax, [5,5,5,1])

    err = network.train(x,y, epochs=10000, show=10000)



    out = network.sim(testingInputs)
    return out