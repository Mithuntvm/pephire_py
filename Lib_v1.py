# -*- coding: utf-8 -*-
"""
Created on Mon Aug  2 12:52:47 2021

@author: Sentient
"""

import pandas as pd
import requests,json,re,datetime,time,os

from config import pephire_db_trans,GetChatTexturl,SendChatTexturl,GetContactStatusurl,DbOperationsurl#Translateurl
import csv

# def GetMalText(string):
#     json_Data = [{"String":string}]
#     txt = requests.post(Translateurl, json.dumps(json_Data)).text    
#     return txt


def db_read(sQry,database,Type):
    json_Data = [{"Query":sQry,"Database":database,"Type":Type}]
    df_read = pd.DataFrame(json.loads(requests.post(DbOperationsurl, json.dumps(json_Data)).text))
    sQry,json_Data='',''
    return df_read

def db_write(InitialInsQry,database,Type):
    InitialInsFlag = ''
    InitialInsData = [{"Query":InitialInsQry,"Database":database,"Type":Type}]
    InitialInsFlag = requests.post(DbOperationsurl, json.dumps(InitialInsData)).text
    InitialInsQry,InitialInsData='',''
    return InitialInsFlag


      
def logger(string,ph):
    print(string)
    f = open("WhatsApplog.log","a",encoding='utf-8')
    f.write(str(datetime.datetime.now()) +' , '+ ph + ','+  string)
    f.write("\n---------------------------\n")
    f.close()
    


            
