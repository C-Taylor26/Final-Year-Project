from ctypes import DEFAULT_MODE
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

def newFunc():
    fields = ["Five_Minute_Change", "Average_Volume", "Days_Change", "20MA_Change", "50MA_Change", "200MA_Change"]
    inputs = pd.read_csv("csvData - Copy.csv", usecols=fields)
    fields = ["Next_Days_Change"]
    targets = pd.read_csv("csvData - Copy.csv", usecols=fields)
    print ("Data Read")

    scaler = StandardScaler()
    scaled = scaler.fit_transform(inputs)

    regressor = MLPRegressor()
    regressor.fit(scaled, targets)
    outputs = regressor.predict(scaled)
    print(np.mean(abs(outputs-targets)))
    
newFunc()