from sklearn.datasets import fetch_california_housing
from sklearn.preprocessing import StandardScaler
from sklearn.neural_network import MLPRegressor
import numpy as np
import pandas as pd

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

def predictAll():

    fields = ["Five_Minute_Change", "Average_Volume", "Days_Change", "20MA_Change", "50MA_Change", "200MA_Change"]
    inputs = pd.read_csv("dataAll19-21.csv", usecols=fields)
    fields = ["Next_Days_Change"]
    targets = pd.read_csv("dataAll19-21.csv", usecols=fields)

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
    for item in outputs:
        if item < 0 and targets[i] < 0:
            correct +=1
        elif item > 0 and targets[i] > 0:
            correct +=1
        i +=1
    
    percent = (correct / i) *100

    print ("Change Direction Correct - {}".format(correct))
    print ("Correct {}% of the time".format(percent))


newFunc()