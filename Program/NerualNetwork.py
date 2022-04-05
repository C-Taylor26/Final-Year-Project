import numpy as np
import math
import nnfs
from nnfs.datasets import spiral_data

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

class Loss:
    def calculate(self, output, y):
        sample_losses = self.foward(output, y)
        data_loss = np.mean(sample_losses)
        return data_loss

class Loss_CatCrossEnt(Loss):
    def foward(self, y_pred, y_true):
        samples = len(y_pred)
        y_pred_clipped = np.clip(y_pred, 1e-7, 1-1e-7)

        if len(y_true.shape) == 1:
            correct_confidences = y_pred_clipped[range(samples), y_true]
        elif len(y_true.shape) == 2:
            correct_confidences = np.sum(y_pred_clipped*y_true, axis=1)

        negative_log_likelihoods = -np.log(correct_confidences)
        return negative_log_likelihoods

def accuracy(outputs, targets): #Takes outputs and targets to calculate % of predictions that are correct.
    predictions = np.argmax(outputs, axis=1)
    acc = np.mean(predictions == targets)
    return acc

def example():
    X, y = spiral_data(samples=100, classes= 3)

    layer1 = Layer(2, 3)
    act1 = ReLu()

    layer2 = Layer(3,3)
    act2 = Softmax()

    layer1.foward(X)
    act1.foward(layer1.output)

    layer2.foward(act1.output)
    act2.foward(layer2.output)

    lossFunc = Loss_CatCrossEnt()
    loss = lossFunc.calculate(act2.output, y)

    print(loss)
    print (accuracy(act2.output, y))

example()


