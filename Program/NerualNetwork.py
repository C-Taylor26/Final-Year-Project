from operator import imod
import numpy as np

class Layer: #Layer Class
    def __init__(self, nInputs, nNeurons):
        self.weights = 0.1* np.random.randn(nInputs, nNeurons)
        self.biases = np.zeros((1, nNeurons))
    def foward(self, inputs):
        self.output = np.dot(inputs, self.weights) + self.biases

class ReLu: #Rectified Linear Activation Function
    def foward(self, inputs):
        self.output = np.maximum(0, inputs)

class Softmax: #Output layer activation function (returns probabilities of each output)
    def foward(self, inputs):
        expVals = np.exp(inputs - np.max(inputs, axis=1, keepdims=True))#Exponentiates inputs
        probs = expVals / np.sum(expVals, axis=1, keepdims=True)
        self.output = probs





