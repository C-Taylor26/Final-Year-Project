#Imports API keys
from keys import *

#Import alpaca trade api module
import alpaca_trade_api as tradeapi

#imprt requests for api calls
import requests

#Datatime module for managing time objects
import datetime

#API URLS
BASE_URL = "https://paper-api.alpaca.markets"
ACCOUNT_URL = "{}/v2/account".format(BASE_URL)
ORDERS_URL = "{}/v2/orders".format(BASE_URL)
POSITIONS_URL = "{}/v2/positions".format(BASE_URL)

#ALPACA MODULE
api = tradeapi.REST(API_KEY, SECRET_KEY, BASE_URL)

#Creates an order with a stop loss and take profit
def createOrder(symbol, qty, side, take_profit, stop_loss):
    data ={
        "symbol": symbol,
        "qty": qty,
        "side": side,
        "type": "market",
        "order_class": "bracket",
        "time_in_force": "day",
        "take_profit": {
            "limit_price": take_profit
        },
        "stop_loss": {
            "stop_price": stop_loss
        }
    }
    r = requests.post(ORDERS_URL, json=data, headers=HEADERS)
    data = r.json()

    return data

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
def getBarSet(symbol, start, end):
    r = api.get_barset(symbol, "5Min", start=start, end=end)
    data = r._raw

    data = data[symbol]
    return data

#Gets Moving Average for a given Timeframe
def getMASet(symbol, timeframe, end):
    total =0

    r = api.get_barset(symbol, "5Min", limit=timeframe, end=end)
    data = r._raw

    data = data[symbol]

    return data

def closeAll():
    r = requests.delete(ORDERS_URL, headers=HEADERS)
    r = requests.delete(POSITIONS_URL, headers=HEADERS)

def daysActivity():
    url = ACCOUNT_URL + "/portfolio/history"
    json = {
        "period":"1D",
        "timeframe":"1D"
    }
    r = requests.get(url, json=json, headers=HEADERS)
    data = r.json()

    return {"equity":data['equity'][-1], "change":data['profit_loss_pct'][-1]}
