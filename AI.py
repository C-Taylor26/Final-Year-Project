from sklearn.datasets import fetch_california_housing
from sklearn.preprocessing import StandardScaler
from sklearn.neural_network import MLPRegressor
import numpy as np
import pandas as pd
import os.path

def demoFunc():
    data = fetch_california_housing()
    inputs = data["data"] #Data strucure array, dtype, max, min, shape, size
    targets = data["target"]

    scaler = StandardScaler()
    scaled = scaler.fit_transform(inputs)

    regressor = MLPRegressor()
    regressor.fit(scaled, targets)
    outputs = regressor.predict(scaled)
    print(np.mean(abs(outputs-targets)))

    pass

def predictSingle(stock):

    fields = ["20MA_Change", "50MA_Change", "200MA_Change"]
    inputs = pd.read_csv("data"+stock+"19-21.csv", usecols=fields)
    fields = ["Next_Days_Change"]
    targets = pd.read_csv("data"+stock+"19-21.csv", usecols=fields)

    inputs = inputs.values
    targets = targets.values

    scaler = StandardScaler()
    scaled = scaler.fit_transform(inputs)

    regressor = MLPRegressor()
    regressor.fit(scaled, targets)
    outputs = regressor.predict(scaled)
    print(np.mean(abs(outputs-targets)))

    i = 0
    correct = 0
    score = 0
    for item in outputs:
        if item < 0 and targets[i] < 0:
            correct +=1
        elif item > 0 and targets[i] > 0:
            correct +=1

        if item > 0:
            score += targets[i]
        i +=1
        
    percent = correct / i  
    print (score)
    if os.path.exists('Results.csv'):
        f = open("Results.csv", "a")
    else:
        f = open("Results.csv", "a")
        f.write("Test_Name, Stock, Total_Days, Correct, Percentage\n")

    f.write("{},{},{},{},{}\n".format(testName, stock, len(targets), correct, percent))
    f.close()
    
    print ("Change Direction Correct - {}".format(correct))
    print ("Correct {}% of the time".format(percent))


testName = input("Test Name: ")
predictSingle("AAPL")