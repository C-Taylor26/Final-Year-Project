#Imports API keys
from keys import *

#Import alpaca trade api module
import alpaca_trade_api as tradeapi

#imprt requests for api calls
import requests

#API URLS
BASE_URL = "https://paper-api.alpaca.markets"
ACCOUNT_URL = "{}/v2/account".format(BASE_URL)

#ALPACA MODULE
api = tradeapi.REST(API_KEY, SECRET_KEY, BASE_URL)

#Creates an order with a stop loss and take profit


#Closes any pending orders or open positions


#Gets account information
def getAccount():   
    r =  requests.get(ACCOUNT_URL, headers=HEADERS)
    data = r.json()
    return data

#Gets account equity, returns Float value
def getEquity():
    data = getAccount()
    equity = float(data['equity'])
    return equity

#Gets bar sets (Candle stick cart)


#Gets open positions for a given stock

