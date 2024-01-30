# -*- coding: utf-8 -*-
"""
Created on Tue Jul  5 19:02:57 2022

@author: Dell
"""
from twilio.rest import Client 
import pandas as pd 
from twilio.base.exceptions import TwilioRestException
import mysql.connector
from datetime import datetime,timedelta
from config import pephire_db_stat, pephire_db,engine_string
account_sid = 'AC48809ecbaf0e280c32189adb51ca1c71' 
auth_token = '9e367d4db03be363e3cf75bc5a4c18d7' 
client = Client(account_sid, auth_token) 
mydb_static = mysql.connector.connect(**pephire_db_stat)
mycursor_static = mydb_static.cursor()
df_Chats = pd.read_sql('select max(created_on) as dt from pephire_trans.whatsappchats',mydb_static)
sMaxTime = df_Chats['dt'].iloc[0]
if sMaxTime == None:
    print('None')
    NewDtFilter = datetime(2022, 8, 1, 0, 0, 0)
    
else:
    NewDtFilter = datetime.strptime(sMaxTime,'%Y-%m-%d %H:%M:%S+00:00')
 
df = pd.DataFrame()
client = Client(account_sid, auth_token) 
for sms in client.messages.list(date_sent_after=NewDtFilter):
  data = pd.DataFrame({"To":[sms.to],"From":[sms.from_],  "Body":[sms.body],"Direction":[sms.direction],"Status":[sms.status], "Created_on":[str(sms.date_created)]})
  df = df.append(data)
if df.shape[0]>0:
    sQry = "delete from pephire_trans.whatsappchats where created_on ='" + sMaxTime + "'"
    mycursor_static.execute(sQry)
    mydb_static.commit()
    for i, rw in df.iterrows():
        sQry = "insert into pephire_trans.whatsappchats values('" + rw['To'] + "','" + rw['From'] + "','" + rw['Body'] + "','" + rw['Direction'] + "','" + rw['Status']+ "','" + rw['Created_on'] + "')"  
        mycursor_static.execute(sQry)
    mydb_static.commit()
mydb_static.close()
