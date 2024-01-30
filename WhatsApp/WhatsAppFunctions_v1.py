# -*- coding: utf-8 -*-
"""
Created on Thu Sep 30 10:58:28 2021

@author: mithun
"""   
import pandas as pd
import requests
import os
from config import pephire_db_trans,currDir,lang ,twilionumber
os.chdir(currDir)
from Lib_v1 import  db_read,db_write,logger,GetMalText
#######################
import mysql.connector, json,datetime
import re
import json
import time
from datetime import datetime,timedelta
######################
###########twilio modules
from twilio.rest import Client 
from twilio.base.exceptions import TwilioRestException


#Get the events with their priorities
df_StagePriority = db_read("SELECT * FROM pephire_trans.event_priority_v2;",pephire_db_trans,"select")
account_sid = 'AC48809ecbaf0e280c32189adb51ca1c71' 
auth_token = '9e367d4db03be363e3cf75bc5a4c18d7' 

def GetCurrentEvent(phone,oid):
    #function to get the current event of the candidate based on the priority
    sQry = "SELECT * FROM pephire_trans.candidate_stages_v2 where id in (SELECT id FROM pephire.candidates where phone='"+phone+"' and organization_id ='" + str(oid) + "')"
    df_Stages=db_read(sQry,pephire_db_trans,"select")
    if df_Stages.shape[0]>0:
        df_Stages = pd.merge(df_Stages,df_StagePriority,on='event')
        #return event with highest priority
        df_Stages = df_Stages[df_Stages['priority']==max(df_Stages['priority'])]
        return df_Stages['event'].iloc[0]  
    else:
        return 0
    
def GetCurrentInvterviewerEvent(phone,oid):
    #function to get the current event of the candidate based on the priority
    sQry = "SELECT * FROM pephire_trans.candidate_stages_v2 where id in (SELECT interview_trans_id FROM pephire.interviewer_details where contact_number='"+phone+"' and oid ='" + str(oid) + "')"
    df_Stages=db_read(sQry,pephire_db_trans,"select")
    if df_Stages.shape[0]>0:
        df_Stages = pd.merge(df_Stages,df_StagePriority,on='event')
        #return event with highest priority
        df_Stages = df_Stages[df_Stages['priority']==max(df_Stages['priority'])]
        return df_Stages['event'].iloc[0]  
    else:
        return 0         
   
def GetFeedbackCurrentEvent(id,oid):
    sQry=''
    sQry = "SELECT * FROM pephire_trans.candidate_stages_v2 where id ='" + str(id) + "'"
    df_Stages=db_read(sQry,pephire_db_trans,"select")
    if df_Stages.shape[0]>0:
        df_Stages = pd.merge(df_Stages,df_StagePriority,on='event')
        #return event with highest priority
        df_Stages = df_Stages[df_Stages['priority']==max(df_Stages['priority'])]
        return df_Stages['event'].iloc[0]  
    else:
        return 0
    

def ConversationStart(Phone,oid,uid,Event,id):
    #Function to get the conversation started
    try:
        #select first question from qn_master
        #####select template from qn master
        sQry = "select qnText from pephire_trans.qn_master_v2 where event = '"+Event+"' and organization_id='"+str(oid)+"';"
        df_firstQn = db_read(sQry,pephire_db_trans,"select")
        frstQn = df_firstQn['qnText'].iloc[0]
        ##############
        #selecting template 



        #select first question id
        df_frstQnDetails=db_read("SELECT qnid,ResponseSource FROM pephire_trans.qn_master_v2 where  organization_id='"+str(oid)+ "' and qnText = '"+frstQn+"';",pephire_db_trans,"select")
        frstQnID = df_frstQnDetails['qnid'].iloc[0]
        frstRspSrc = df_frstQnDetails['ResponseSource'].iloc[0]
        print('Personalising first Qn for ' + Phone)
        sQry=''
        #personalize the question with values from personalization_parameter_v2 table
        sQry = "select * from pephire_trans.personalization_parameters_v2 where Phone='" + Phone +"' and oid ='" + str(oid) + "';"
        df_personalization_parameter = db_read(sQry,pephire_db_trans,"select")
        if df_personalization_parameter.shape[0]>0:
            lstParams = list(df_personalization_parameter['Parameters'])
            
            # define string
            
            
            #parameters = re.search('<(.+?)>', frstQn)
            parameters =re.findall("\<(.*?)\>", frstQn)
            parval =[]
            #Format the text
            for i,ch in enumerate(lstParams):
                try:
                    value = df_personalization_parameter.ParameterValue[df_personalization_parameter.Parameters==ch][i]
                    frstQn = frstQn.replace('<','')
                    frstQn = frstQn.replace('>','')
                    frstQn = frstQn.replace(ch,value)                      
                except:
                    pass  
        
        
        #Send the message
        print('Sending first Qn for '+ Phone + ' Event is ' + Event)
        print('frstQn is'+frstQn)
        msg_source="whatsapp"

        valuepassed =frstQn

            
       # frstQn = GetText(frstQn,lang)
        if SendChat(valuepassed,msg_source,Phone) !='success':
            logger('Failed to sent message.' , Phone)
        else:
            #Update DB, update last conversation table with question send and its id
            df_newNextQnID = db_read("SELECT nextQnID FROM pephire_trans.qn_master_v2 where qnid = '" + frstQnID +"' and organization_id ='" + str(oid) + "'",pephire_db_trans,"select")        
            if str(df_newNextQnID['nextQnID'].iloc[0])=="0":
                sQry = "delete FROM pephire_trans.last_conversation_v2 where candidatePhone = '" +Phone + "' and stage = '" + Event + "' and organization_id ='" + str(oid) + "'"
                Flag = db_write(sQry,pephire_db_trans,"others")
                sQry = ''
                if Flag !='1':
                    logger('Delete from last conversation table failed.' , Phone)                
                #Delete the current stage entries using id
                sQry = "select usertype from pephire_trans.candidate_stages_v2 where id = '"+str(id)+"'"
                df_typeOfUser = pd.DataFrame()
                df_typeOfUser = db_read(sQry,pephire_db_trans,"select")
                sQry = ''
                typeOfUser = df_typeOfUser['usertype'].iloc[0]
                if typeOfUser =='interviewer':
                    sID = id
                else:
                    sQry = "SELECT * FROM pephire.candidates where phone='" + Phone +"' and organization_id ='" + str(oid) + "' "
                    sID = str(db_read(sQry,pephire_db_trans,"select")['id'].iloc[0])
                    
                sQry = "delete FROM pephire_trans.candidate_stages_v2 where id = '" +str(sID) + "' and event = '" + Event + "'"
                Flag = db_write(sQry,pephire_db_trans,"others")
                sQry = ''
                if Flag !='1':
                    logger('Delete from last conversation table failed.' , Phone)
                #Get the remaining uncompleted events for the candidate
                sQry = "select * from pephire_trans.candidate_stages_v2 where id = '" +str(sID) + "'"
                df_RemainingStages = db_read(sQry,pephire_db_trans,"select")
                sQry = ''
                if Flag !='1':
                    logger('Delete from last conversation table failed.', Phone)
                    
                
            else:
                sQry = "insert into pephire_trans.last_conversation_v2 values('" + Phone + "','" + str(oid) + "','" + str(uid) +"','" + frstQn + "','" + Event +"','" + frstQnID + "','" + frstRspSrc +"',now(),'" + 'WHATSAPP' +"')"
                Flag = db_write(sQry,pephire_db_trans,"others")
                if Flag !='1':
                    logger('Failed to update last_conversation_v2 table')
                #Update DB, update  conversation details table with question send and its id
                sQry = "insert into pephire_trans.conversation_details_v2 values ('"+Phone+"','"+str(oid)+"','"+str(uid)+"','"+frstQn+"','','','candidate',now(),'"+frstQnID+"',now(),'"+'WHATSAPP'+"')"
                Flag = db_write(sQry,pephire_db_trans,"others")
                if Flag !='1':
                    logger('Failed to update conversation details table',Phone)
                ##########################################################################################
                #sQry = "insert into pephire_trans.conversation_history_table values ('"+twilionumber+"','"+Phone+"','"+str(oid)+"','"+str(uid)+"','"+frstQn+"','candidate',now(),'"+'WHATSAPP'+"')"
                #Flag = db_write(sQry,pephire_db_trans,"others")
                #if Flag !='1':
                 #   logger('Failed to update conversation_history_table table',Phone)        
                ################################################################################################
                sQry=''
                print('First Qn DB update complete for ' + Phone)
                return True
    except Exception as e:
        logger("Exception while sending first Qn. " + str(e) , Phone)
        return False
     


#sentURL = "https://api.chat-api.com/instance344864/sendMessage?token=rvorflkqqph99hiv"
#getURL = "https://api.chat-api.com/instance344864/messagesHistory?token=rvorflkqqph99hiv"

sentURL = "https://api.chat-api.com/instance342155/sendMessage?token=p9dcyi030zyf0hly"
getURL = "https://api.chat-api.com/instance342155/messagesHistory?token=p9dcyi030zyf0hly"

def GetText(sText,language):
    #Function to do the translation based on the language specified.
    if language!="":
        sText = GetMalText(sText)
    return sText


def GetDeltaChats(nMinTime):

    try:
        df_Chats,df_Chats_out,df_Chats_in = pd.DataFrame(),pd.DataFrame(),pd.DataFrame()
        #get the time in required format to filter
        MinTime =datetime.utcfromtimestamp(int(nMinTime)).strftime("%Y-%m-%d %H:%M:%S")   
        FilterTime =str(MinTime)+'+00:00'
        client = Client(account_sid, auth_token) 
        #for sms in client.messages.list():
        for sms in client.messages.list(date_sent_after=FilterTime):
          data = pd.DataFrame({"Sender":[sms.to],"Contact":[sms.from_],  "Message":[sms.body],"Direction":[sms.direction],"Status":[sms.status], "Time":[str(sms.date_created)]})
          #print(sms.to + "|" + sms.body + '|' + sms.from_ +'|'  + sms.direction + '|' +sms.status+'|'  + str(sms.date_created) )
          df_Chats = df_Chats.append(data)
        df_Chats['Time'] = df_Chats['Time'].apply(lambda x:(datetime.fromisoformat(x)).timestamp())
        #timenow =max(df_Chats['Created_on'])

        #currenttime =time.mktime(datetime.now().timetuple())
        #print(currenttime)
        #change the column name and
        #df_Chats.rename(columns = {'To':'Sender', 'From':'Contact','Body':'Message','Created_on':'Time'}, inplace = True)
        #format numbers
        df_Chats['Sender']=df_Chats["Sender"].str[10:]
        df_Chats['Contact']=df_Chats["Contact"].str[10:]
        #get inbound and outbound dataframes 
        df_Chats_in=df_Chats[df_Chats['Direction']=='inbound']
        df_Chats_out=df_Chats[df_Chats['Direction']=='outbound-api']
        #interchange the columns sender and contact
        df_Chats_out.rename(columns = {'Sender':'Contact', 'Contact':'Sender'}, inplace = True)
        df_Chats= df_Chats_in.append(df_Chats_out)
        df_Chats =df_Chats[df_Chats['Sender']==twilionumber]
        df_Chats = df_Chats.reset_index()
        df_Chats =df_Chats.drop(['index'], axis=1)
        

        return df_Chats
    except Exception as e:
        print(e)
        return df_Chats  
    

def SendChat(sText,source,sRecieverNumber):
    #connnect to twilio client
    account_sid = 'AC48809ecbaf0e280c32189adb51ca1c71' 
    auth_token = '9e367d4db03be363e3cf75bc5a4c18d7' 
    client = Client(account_sid, auth_token) 
    try:    
        message = client.messages.create(
                 from_='whatsapp:+19704997600',
                 body=sText,
                 to= 'whatsapp:'+sRecieverNumber)
        return "success"
    except TwilioRestException as err:
        return "failure"
        print(err)

