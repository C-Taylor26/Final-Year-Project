from dbConnection import dbSatement
import datetime
import random

#sql = "INSERT INTO dayChange (date, percentageChange) VALUES ('{}', {})".format(date, data["change"])
#results = dbSatement(sql)


startDate = datetime.datetime.now().replace(day=1)
i = 0
data = []
total = 0
while len(data) < 60:
    newDate = startDate - datetime.timedelta(days=i)
    if newDate.weekday() < 5:
        date = newDate.strftime("%Y-%m-%d")
        change = random.uniform(-0.075, .1)
        total +=change
        data.append([date,change])
    i += 1

print(total)
data.reverse()

for d in data:
    sql = "INSERT INTO dayChange (date, percentageChange) VALUES ('{}', {})".format(d[0],d[1])
    results = dbSatement(sql)


    