# -*- coding: utf-8 -*-
"""
Created on Mon Jul 25 19:30:55 2022

@author: mithun
"""

import pandas as pd
import time
import requests
import os
from config import pephire_db_trans,currDir,lang
os.chdir(currDir)
from Lib_v1 import  db_read,db_write,logger,GetMalText
import os
from flask import jsonify
import json
from flask import Flask, redirect, url_for, request
from WhatsAppFunctions_v1 import GetDeltaChats
from config import pephire_db_trans,currDir,lang,pephire,pephire_trans,pephire_static
t = 1653457868
while True:       
    try:
        df_Chats,df_Candidates,df_Latest,df_Responses,df_LastConv2,df_maxtime = pd.DataFrame(),pd.DataFrame(),pd.DataFrame(),pd.DataFrame(),pd.DataFrame(),pd.DataFrame()
        LastConv,Phone,maxtimeint,LastTime,LastTimeAdj='' ,'','','',''
        try:
            #get the new chats
            df_Chats = GetDeltaChats(str(t+1))
            #Check if there is new chats
            if df_Chats.shape[0]>0:               
                #Groupby to get the latest message to or from a number 
                df_Latest = df_Chats.groupby('Contact').agg({'Time':'max'}).reset_index()
                df_Latest = pd.merge(df_Latest,df_Chats,on=['Contact','Time'])
                #Load all candidate basic details
                sQry = "select id,organization_id,user_id,phone from "+pephire+".candidates where flag='1'"   
                df_Candidates = db_read(sQry,pephire_db_trans,"select")
                df_Candidates['phone'] = df_Candidates['phone'].str.replace('+','').str.replace(' ','')
                #get the responses only from candidates
                df_Responses = df_Latest[df_Latest['Direction']=='inbound']

                if df_Responses.shape[0]>0:  
                    #merge with the candidates who are in chat with whatsapp web
                    df_Responses['Contact'] = df_Responses['Contact'].str.replace('+','').str.replace(' ','')
                    df_Responses = pd.merge(df_Responses,df_Candidates,left_on='Contact',right_on='phone')
                    df_Responses['Time'] = df_Responses['Time'].astype(int)
                    if df_Responses.shape[0]>0:
                        for i, row in df_Responses.iterrows():
                            try:
                                df_Responses_cand=pd.DataFrame()
                                #get the candidates details
                                Phone = row['Contact']
                                #Get the max time of the latest message send to the candidate
                                df_maxtime = db_read("select max(timestamp) from "+pephire_trans+".conversation_timestamp where phoneNumber = "+Phone ,pephire_db_trans,"select")
                                LastTime = str(df_maxtime['max(timestamp)'].iloc[0])
                                LastTime = LastTime[0:10]
                                #6 sec time gap btw currenttime and twilio time stamp
                                #LastTimeAdj =int(LastTime) -9
                                LastTimeAdj =int(LastTime) 
                                
                                
                                # df_Responses_cand = df_Responses[df_Responses['Contact']==Phone]
                                # df_Responses_cand['Time'] =df_Responses_cand['Time'].astype(int)
                                
                                
                                
                                # #get the latest response after the last message being send from UI
                                # df_Responses_cand = df_Responses_cand[df_Responses_cand['Time']>LastTimeAdj] 
                                
                                if row['Time']>LastTimeAdj:
                                #get the message
                                    LastConv = row['Message']
                                    #get the candidates details
                                    Phone = row['Contact']
                                    print(Phone)
                                    string = Phone + "," + "lastconv was " + LastConv 
                                    oid = row['organization_id']
                                    uid = row['user_id']
                                    id= row['id']
                                    #Check whether the last conversation table has a record expecting a reply
                                    sQry = "select * from " + pephire_trans + ".last_conversation_v2 where candidatePhone = '" +Phone + "' and message_source = 'WEB' and organization_id ='" + str(oid) + "'"
                                    df_LastConv2 = pd.DataFrame()
                                    df_LastConv2 = db_read(sQry,pephire_db_trans,"select")
                                    sQry =''
                                    if df_LastConv2.shape[0]>0:
                                        #Update the tables if the response is for the question asked
                                        
                                        sQry = """update pephire_trans.conversation_details_v2 set response=\""""+LastConv+"""\",ValidResponse='yes',Recieved=now() where candidatePhone='""" + Phone +"""' and organization_id ='""" + str(oid) + """' and message_source =  'WEB' and Sent =  (select max(created_at) FROM """ + pephire_trans+""".last_conversation_v2 where message_source ='WEB' and candidatePhone='"""+  Phone +"');"""
                                        Flag = db_write(sQry,pephire_db_trans,"others")
                                        sQry = '' 
                                        
                                        if Flag !='1':
                                            logger('Update conversation details table failed .' , Phone)
                                        #Deleting entry for that phone number last conversation table
                                        sQry = "delete FROM "+pephire_trans+".last_conversation_v2 where candidatePhone = '" +Phone + "' and message_source = 'WEB' and organization_id ='" + str(oid) + "'"
                                        Flag = db_write(sQry,pephire_db_trans,"others")
                                        sQry = ''
                                        if Flag =='1':
                                            logger('Delete from last conversation table ' , Phone)
                                            print("updates done")
                            except:
                                print("no response from" +str(Phone))
                           
            t= int(max(df_Chats['Time']))          
        except Exception as e:           
            print(e)
    except Exception as e:       
        print(e)  
    print('Listening')
      
        
        
# import urllib
# localhost = urllib.urlopen("http://localhost:8000/MSG")
# print(localhost.read(100))
# import requests as req

# resp = req.get("http://127.0.0.1:8000/MSG")

# print(resp.text)


