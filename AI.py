from sklearn.datasets import fetch_california_housing
from sklearn.preprocessing import StandardScaler
from sklearn.neural_network import MLPRegressor
import numpy as np
import pandas as pd
def demoFunc():
    data = fetch_california_housing()
    inputs = data["data"]
    targets = data["target"]

    scaler = StandardScaler()
    scaled = scaler.fit_transform(inputs)

    regressor = MLPRegressor()
    regressor.fit(scaled, targets)
    outputs = regressor.predict(scaled)
    print(np.mean(abs(outputs-targets)))

    pass

def newFunc():
    df = pd.read_csv("csvData.csv")
    print (df.to_string())


newFunc()