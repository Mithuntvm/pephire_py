# -*- coding: utf-8 -*-
"""
Created on Wed Aug  4 18:08:46 2021

@author: Sentient
"""
import os
from config import pephire_db_trans,currDir,DBFlag
os.chdir(currDir)
from WhatsAppReadWrite_v8 import GetLastQn,SendNextQuestion
from Branching_v9 import GetNextEventQn
from Lib_v1 import logger,db_read,db_write
from WhatsAppFunctions_v1 import SendChat

def WhatAppConversation(Phone,oid,uid,Event,id,LastConv):
    #Get the last conversation with the candidate
    print('last conv')  
    LastConv = str(LastConv)
    string = Phone + "," + "lastconv was " + LastConv  
    LastQn,LastQnID = GetLastQn(Phone,Event)

    try:
        #The below line will fail if non alpha numeric is the response
        logger(string,Phone)       
        #Update DB
        nextQn,nextQnID = '',''
        nextQn,nextQnID = GetNextEventQn(LastConv,LastQn,Phone,id,LastQnID)
        if nextQn=='End':
             InitialInsQry = " delete from pephire_trans.last_conversation_v2 where candidatePhone = '"+Phone+"' and stage = '"+Event+"' and organization_id ='" + str(oid) + "';"
             InitialInsFlag = db_write(InitialInsQry,pephire_db_trans,"others")
             if InitialInsFlag!='1':
                 logger('Failed to delete from last conversation DB',Phone)
    except:#Handling non alpha numeric characters
        nextQn = "Please respond in correct format. Only text allowed."
        SendChat(nextQn,Phone)  
        return
    sQry = "select ResponseSource from pephire_trans.qn_master_v2 where qnid = '"+nextQnID+"' and organization_id ='" + str(oid) + "';"
    df_ResponseSource = db_read(sQry,pephire_db_trans,"select")
    try:                
        response_source = df_ResponseSource['ResponseSource'][0]
        Flag = SendNextQuestion(Phone,oid,uid,LastQn,LastQnID,LastConv,nextQn,Event,nextQnID,response_source)
        if Flag==False:
            print("error with " + Phone)
    except Exception as e:
        logger(e,Phone)
        print('No response source')
