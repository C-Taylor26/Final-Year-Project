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
def getCandle(symbol, date):
    day = int(date.split('-')[0])
    month = int(date.split('-')[1])
    year = int(date.split('-')[2])

    now = datetime.datetime.now()
    start = now.replace(year=year, month=month, day=day, hour = 0, minute=0, second=0, microsecond=0).isoformat() + "Z"
    end = now.replace(year=year, month=month, day=day, hour = 23, minute=59, second=59, microsecond=0).isoformat() + "Z"

    r = api.get_barset(symbol, "5Min", start=start, end=end)
    data = r._raw

    data = data["TSLA"][1:]
    return data

#Gets open positions for a given stock
