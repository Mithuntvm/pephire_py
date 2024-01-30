# -*- coding: utf-8 -*-
"""
Created on Thu Sep 30 10:43:07 2021

@author: mithun
"""
import time
from datetime import datetime
import os, pandas as pd

from config import pephire_db_trans,pephire,pephire_trans,pephire_static,twilionumber
currDir='C:\Pephire\Whatsapp'
os.chdir(currDir)
from WhatsAppFunctions_v1 import ConversationStart,GetDeltaChats,SendChat,GetCurrentEvent,GetText,GetCurrentInvterviewerEvent,GetFeedbackCurrentEvent
from Lib_v1 import db_read,db_write,logger,GetMalText
from WhatsAppConversation_v9 import WhatAppConversation
from WhatsAppReadWrite_v8 import GetLastQn,SendNextQuestion
from Branching_v9 import GetNextEventQn
from datetime import timedelta
import pytz
df_StagePriority = db_read("SELECT * FROM "+pephire_trans+".event_priority_v2;",pephire_db_trans,"select")



def FormatPhone(ChatId):
    #function to get the candidate phone number
   index = ChatId.find('@')
   phone = ChatId[:index]
   
   return phone
def unix_time_millis(dt):
    return time.mktime(dt.timetuple())*1e3 + dt.microsecond/1e3 
#function to create question master when a new organization id is created
def qnmaster_new_organization():
    #select organization id which are not in question master
    sQry = "SELECT distinct(organization_id) from pephire.candidates where organization_id not in(SELECT distinct(organization_id) from pephire_trans.qn_master_v2)"
    df_organizationid = db_read(sQry, pephire_db_trans, "select")
    sQry=''
    if df_organizationid.shape[0]>0:
        # insert question in the question master table for new org ids
        for i, row in df_organizationid.iterrows():
            organization_id = row['organization_id']
            print(organization_id)
            df = pd.read_csv("C:/Pephire/QNMaster.csv")
            df=df.fillna('')
            for j, rw in df.iterrows():
                sQry = """insert into pephire_trans.qn_master_v2 values ('"""+str(organization_id)+"""','"""+str(rw['event'])+"""','"""+str(rw['qnid'])+"""',\'"""+str(rw['qnText'])+"""\','"""+str(rw['validation'])+"""','"""+str(rw['validationValues'])+"""','"""+str(rw['nextQnID'])+"""','"""+str(rw['branch'])+"""','"""+str(rw['Type'])+"""','"""+str(rw['Category'])+"""','"""+str(rw['ResponseSource'])+"""')"""
                Flag = db_write(sQry,pephire_db_trans,"others")
    return df_organizationid
 
UTC = pytz.utc
stagecheck='False'
interviewerstagecheck='False'
tInt = 1650459226
t = 1666009570
while True:    
    print('Loop')    
    try:
        time.sleep(5)
        df_Chats,df_Latest,df_Responses,df_Converse = pd.DataFrame(),pd.DataFrame(),pd.DataFrame(),pd.DataFrame()
        df_ChatsInt,df_LatestInt,df_ResponsesInt = pd.DataFrame(),pd.DataFrame(),pd.DataFrame()
        oid=''
        #%%Get latest message
        #Candidate - ActiveWhatsAppConversation
        try:                         
            print(t)
            df_Chats = GetDeltaChats(str(int(t)+1))
            if df_Chats.shape[0]>0:
                print('Get Chat')
            #Save max time from df_Chats to table as max time
                df_Latest = df_Chats.groupby('Contact').agg({'Time':'max'}).reset_index()
                df_Latest = pd.merge(df_Latest,df_Chats,on=['Contact','Time'])
                #Load all candidate basic details
                sQry = "select id,organization_id,user_id,phone from "+pephire+".candidates where flag='0'  and deleted_at is null "    
                df_Candidates = db_read(sQry,pephire_db_trans,"select")
                df_Candidates['phone'] = df_Candidates['phone'].apply(lambda a: str(a).replace(' ',''))
                df_Candidates['phone'] = df_Candidates['phone'].apply(lambda a: str(a).replace('+',''))
                df_Candidates['phone'] = df_Candidates['phone'].apply(lambda a: str(a).replace('-',''))
                df_Candidates['phone'] = df_Candidates['phone'].apply(lambda a:'91'+ str(a) if len(a)==10 else a)
                
                #Process the candidates who as replied  as latest
                df_Responses = df_Latest[df_Latest['Direction']=='inbound'] 
                if df_Responses.shape[0]>0:  
                    df_Responses['Contact'] = df_Responses['Contact'].apply(lambda a: str(a).replace(' ',''))
                    df_Responses['Contact'] = df_Responses['Contact'].apply(lambda a: str(a).replace('+',''))
                    df_Responses = pd.merge(df_Responses,df_Candidates,left_on='Contact',right_on='phone')
                    if df_Responses.shape[0]>0:
                        #Get the event for the candidate 
                        df_Responses['Event'] = df_Responses.apply(lambda x: GetCurrentEvent(x['Contact'],x['organization_id']), axis=1) 
                        df_Responses = df_Responses[df_Responses['Event']!=0]
                    
                        if df_Responses.shape[0]>0:
                            print("Processing chats count = " + str(df_Responses.shape[0]))
                            for i, row in df_Responses.iterrows():
                                #Handing non textual responses                    
                                LastConv = row['Message']
                                Phone = row['Contact']
                                string = Phone + "," + "lastconv was " + LastConv 
                                CurrEvent = str(row['Event'])
                                oid = row['organization_id']
                                uid = row['user_id']
                                id= row['id']  
                                #Get the last question sent, last question id and the event
                                LastQnID,LastQn,LastEvent = GetLastQn(Phone,oid)
                                print(LastQnID)
                                if LastQnID != '': #Not able to get last qn as it is a start of conversation or restart of a completed conversation(resubmitting of resume or new interview)                 
                                    #Handling special characters and emoticons
                                    try:
                                        #The below line will fail if non alpha numeric is the response
                                        logger(string,Phone)
                                        print("Response in wrong format")
                                    except:#Handling non alpha numeric characters
                                        nextQn = "Please respond in correct format. Only text allowed."
                                        source ='whatsapp'
                                        template ='none'
                                        SendChat(nextQn,source,Phone)  
                                        break   
                                    nextQn,nextQnID = '',''
                                    print("Next Qn created for the candidate")
                                    #Get the next question and next question id to be sent
                                    nextQn,nextQnID = GetNextEventQn(LastConv,LastQn,Phone,id,LastQnID,str(oid),str(uid))
                                    print('nextQn when there is response '+nextQn)
                                    print('nextQnID when there is response '+nextQnID)
                                    #Get the expected response source of the question sent, whether it is a text through whatsApp or response through UI, that is via submitting a  link
                                    sQry = "select ResponseSource from "+pephire_trans+".qn_master_v2 where qnid = '"+nextQnID+"' and organization_id ='" + str(oid) + "';"
                                    df_ResponseSource = db_read(sQry,pephire_db_trans,"select")
                                    try:                
                                        response_source = df_ResponseSource['ResponseSource'][0]
                                        Flag = SendNextQuestion(Phone,oid,uid,LastQn,LastQnID,LastConv,nextQn,CurrEvent,nextQnID,response_source,id)
                                        if Flag==False:
                                            print("error with " + Phone)
                                    except Exception as e:
                                        logger(e,Phone)
                                        print('No response source')
                    else:
                        print('No new chats')
                t= max(df_Chats['Time'])
                print('Processed chats')
        except Exception as e1:
            logger("Exception while getting latest conversation")
            logger(e1,'')
        time.sleep(5)
        
            
        #Candidate-ConversationStart
        #%% Get all attributed candidates, filter out candidates that are already part of conversations. For the rest sent first qeustion
        try:
            oid=''
            #
            sQry = "SELECT phone,organization_id,user_id,id FROM "+pephire+".candidates where id in (select id from "+pephire_trans+".candidate_stages_v2) and flag='0';"
            df_OpenConv = pd.DataFrame()
            df_OpenConv = db_read(sQry,pephire_db_trans,"select")

            df_AlreadyConversed = pd.DataFrame()
            if df_OpenConv.shape[0]>0: 
                df_OpenConv['id'] = df_OpenConv['id'].astype(str)  
                df_Stages=db_read('SELECT event,id,oid  FROM pephire_trans.candidate_stages_v2 ;',pephire_db_trans,"select")
                if df_Stages.shape[0]>0:
                    df_Stages = pd.merge(df_Stages,df_StagePriority,on='event')
                    #return event with highest priority
                    df_StagesMaxPriority = df_Stages.groupby('id').agg({'priority':'max'}).reset_index()
                    df_Stages = pd.merge(df_Stages,df_StagesMaxPriority, on = ['id'])
                    df_Stages = df_Stages.rename(columns = {'oid':'organization_id'})
                    df_Stages['organization_id'] = df_Stages['organization_id'].astype(str)
                    #Merge the open conversations with the event based on their priority
                    df_OpenConv = pd.merge(df_OpenConv,df_Stages,on =['id'] )
                df_OpenConv['key'] = df_OpenConv['phone']+df_OpenConv['event']+df_OpenConv['organization_id_x'].astype(str)          
            lstExisting = []
            #Get the candidates who are already a part of the conversation
            df_AlreadyConversed = db_read("SELECT candidatePhone,stage,organization_id FROM "+pephire_trans+".last_conversation_v2",pephire_db_trans,"select") 
            if df_AlreadyConversed.shape[0]>0:             
                df_AlreadyConversed['key'] = df_AlreadyConversed['candidatePhone'] + df_AlreadyConversed['stage']+ df_AlreadyConversed['organization_id'].astype(str)        
                lstExisting = df_AlreadyConversed['key'].tolist()   
            if df_OpenConv.shape[0]>0:  
                #Exclude the numbers that are already part of active conversation
                if len(lstExisting)>0:                
                    df_OpenConv = df_OpenConv[~df_OpenConv.key.isin(lstExisting)] 
                    if df_OpenConv.shape[0]>0:
                        df_OpenConv['phone'] = df_OpenConv['phone'].apply(lambda a: str(a).replace(' ',''))
                        df_OpenConv['phone'] = df_OpenConv['phone'].apply(lambda a: str(a).replace('+',''))
                        df_OpenConv['phone'] = df_OpenConv['phone'].apply(lambda a: str(a).replace('-',''))
                        df_OpenConv['phone'] = df_OpenConv['phone'].apply(lambda a:'91'+ str(a) if len(a)==10 else a)
                if df_OpenConv.shape[0]>0:
                    #get event for the candidates
                    #After filtering out the active conversations, send the first question to the remaining candidates
                    for i,row in df_OpenConv.iterrows():
                        oid = row["organization_id_x"]
                        uid = row["user_id"]
                        Phone = row["phone"]
                        id = row["id"]
                        Event = row['event']
                        ConversationStart(Phone,str(oid),uid,Event,id)
        except Exception as e:
            print("Exception while sending first qn")
            logger(e,Phone)
        
        #%% Get the phone numbers that have verifed the link
        #Candidate- ActiveUIConversation
        try:
            oid=''
            df_LinkVerified = pd.DataFrame()
            #Get the candidates who have selected the interview time slot
            sQry = "SELECT * FROM "+pephire_trans+".link_verification_status where link_status='1'"
            df_LinkVerified = db_read(sQry,pephire_db_trans,"select")
            if df_LinkVerified.shape[0]>0:                        
                QnID,NextQnID,Event,NextQn,NextQnRespSource,sQry='','','','','',''    
                #Get the question master 
                df_QnMaster =  db_read("SELECT organization_id,qnid,qnText,nextQnID,event,ResponseSource,Type FROM "+pephire_trans+".qn_master_v2",pephire_db_trans,"select")
                #Merge the question master with the candidates who have selected the interview timeslot
                df_LinkVerified = pd.merge(df_LinkVerified,df_QnMaster,left_on=['QnID','oid'],right_on=['qnid','organization_id'])
                df_LinkVerified.drop_duplicates(keep='last', inplace=True)
                
                #Get the details of the candidate who have verified the link 
                for i, row in df_LinkVerified.iterrows():
                    Phone = row['Phone']
                    QnID = row['QnID'] 
                    oid = row['organization_id']
                    sQry = "SELECT phone,user_id,id FROM "+pephire+".candidates where phone = '" + Phone + "' and organization_id = '" + str(oid) + "'and  deleted_at is NULL;"
                    df_Candidate = db_read(sQry,pephire_db_trans,"select")                
                    uid = df_Candidate['user_id'].iloc[0]
                    
                    NextQnID = df_LinkVerified['nextQnID'].iloc[0]
                    Event=df_LinkVerified['event'].iloc[0]
                    #Updating respose to last qn in the conversation details table
                    sQry = "update "+pephire_trans+".conversation_details_v2 set response='Link verified',ValidResponse='yes',Recieved=now() where candidatePhone='" + Phone +"' and QnID = '" + QnID + "' and organization_id ='" + str(oid) + "'"
                    Flag = db_write(sQry,pephire_db_trans,"others")
                    sQry = ''
                    if Flag !='1':
                        logger('Failed to update conversation details with link response.', Phone)
                   
                    #Getting next qn,if there is qn following after link verification
                    print('Get the next qn to be sent for ' + Phone)
                    sQry = ''
                    if NextQnID != "0":
                        NextQn = df_QnMaster[df_QnMaster['qnid']==NextQnID]['qnText'].iloc[0]
                        NextQnRespSource = df_QnMaster[df_QnMaster['qnid']==NextQnID]['ResponseSource'].iloc[0]
                        Type = df_QnMaster[df_QnMaster['qnid']==NextQnID]['Type'].iloc[0]
                        #personalising the question
                        if  Type == 'Replace':
                            sQry = " select * from "+pephire_trans+".personalization_parameters_v2 where Phone='" + Phone +"' and oid='"+str(oid)+"';"
                            df_personalization_parameter = db_read(sQry,pephire_db_trans,"select")
                            lstParams = list(df_personalization_parameter['Parameters'])
                           
                            for i,ch in enumerate(lstParams):
                                try:
                                    value = df_personalization_parameter.ParameterValue[df_personalization_parameter.Parameters==ch][i]
                                    NextQn = NextQn.replace('<','')
                                    NextQn = NextQn.replace('>','')
                                    NextQn = NextQn.replace(ch,value)
                                except:
                                    pass
                        
                        print('NextQn after verification is'+NextQn)
                        
                        source ='whatsapp'
                        if SendChat(NextQn,source,Phone) !='success':
                            logger('Failed to sent message '+ NextQnID , Phone)
                        #Deleting from link verification table
                        sQry = "delete FROM "+pephire_trans+".link_verification_status where Phone = '" +Phone +"' and QnID ='" + QnID + "' and oid ='" + str(oid) + "'"
                        Flag = db_write(sQry,pephire_db_trans,"others")
                        sQry = ''
                        if Flag !='1':
                            logger('Failed to update conversation details with link response', Phone)            
                        #Deleting entry for that phone number last conversation table
                        sQry = "delete FROM "+pephire_trans+".last_conversation_v2 where candidatePhone = '" +Phone + "' and stage='"+Event+"' and organization_id ='" + str(oid) + "'"
                        Flag = db_write(sQry,pephire_db_trans,"others")
                        sQry = ''
                        if Flag !='1':
                            logger('delete last conversation table ', Phone)
                        #Adding entry for that phone number last conversation table
                        sQry = "insert into "+pephire_trans+".last_conversation_v2 values('" + Phone + "','" + str(oid) + "','" + str(uid) +"','"+NextQn+"','"+Event+"','"+NextQnID+"','"+NextQnRespSource+"',now(),'"+'WHATSAPP'+"')"
                        Flag = db_write(sQry,pephire_db_trans,"others")
                        sQry = ''
                        if Flag !='1':
                            logger('delete last conversation table ', Phone)  
                        #Adding new entry to conversation details table
                        sQry = "insert into "+pephire_trans+".conversation_details_v2 values ('"+Phone+"','"+str(oid)+"','"+str(uid)+"','"+NextQn+"','','','candidate',now(),'"+NextQnID+"',now(),'"+'WHATSAPP'+"')"
                        Flag = db_write(sQry,pephire_db_trans,"others")
                        if Flag !='1':
                            logger('Failed to update conversation details table',Phone)
                        sQry='' 
                        #Checking whether this is the last Qn in that stage
                        df_newNextQnID = db_read("SELECT nextQnID FROM "+pephire_trans+".qn_master_v2 where qnid = '" + NextQnID +"' and organization_id ='" + str(oid) + "'",pephire_db_trans,"select")        
                        if df_newNextQnID['nextQnID'].iloc[0]=="0":
                            #delete from last conversation table for that event
                            sQry = "delete FROM "+pephire_trans+".last_conversation_v2 where candidatePhone = '" +Phone + "' and stage = '" + Event + "' and organization_id ='" + str(oid) + "'"
                            Flag = db_write(sQry,pephire_db_trans,"others")
                            sQry = ''
                            if Flag !='1':
                                logger('Delete from last conversation table failed ' , Phone)                
                            #Delete the current stage entries using id
                            sQry = "SELECT * FROM "+pephire+".candidates where phone='" + Phone +"' and organization_id ='" + str(oid) + "'and  deleted_at is NULL;"
                            sID = str(db_read(sQry,pephire_db_trans,"select")['id'].iloc[0])
                            
                            sQry = "delete FROM "+pephire_trans+".laststage_v2 where phone = '" +Phone + "' and stage = '" + Event + "'"
                            Flag = db_write(sQry,pephire_db_trans,"others")
                            sQry = ''
                            
                            sQry = "delete FROM "+pephire_trans+".candidate_stages_v2 where id = '" +sID + "' and event = '" + Event + "'"
                            Flag = db_write(sQry,pephire_db_trans,"others")
                            sQry = ''
                            if Flag !='1':
                                logger('Delete from last conversation table failed ', Phone)
                            else:#Remove the last qn on that event if thats an link(Eg: Interview loop has last qn which is a link)
                                sQry = "delete FROM "+pephire_trans+".link_verification_status where Phone = '" +Phone +"' and QnID ='" + QnID + "' and oid ='" + str(oid) + "'"
                                Flag = db_write(sQry,pephire_db_trans,"others")
                                sQry = ''
                                if Flag !='1':
                                    logger('Failed to update conversation details with link response. ' , Phone)
                            #Send last question of the current stage, if there was no response for the previous stage        
                            if NextQnRespSource=='NoSource':
                                lastresponse=''
                                LastQnID,LastQn,LastEvent = '','',''
                                LastQnID,LastQn,LastEvent = GetLastQn(Phone,oid)
                                #Check if there is a response for the last question
                                sQry = "select response from "+pephire_trans+".conversation_details_v2 where QnID='"+LastQnID+"' and candidatePhone = '" + Phone +"' and  organization_id ='" + str(oid) + "'"
                                lastresponse = db_read(sQry,pephire_db_trans,"select")['response'].iloc[0]
                                if lastresponse=='':
                                    template ='none'
                                    source ='whatsapp'
                                     
                                    SendChat(LastQn,source,Phone) 
                    
                    
        except Exception as e:
            print('Exception while verifying link.')
            logger("Exception while verifying link." + str(e) , str(Phone))
            
               
            #%% get candidates who have attended the interview.
            #Candidate-Feedback/Reminder
        try:
            #Get the list of candidates shortlisted for interview
            sQry ="SELECT id,candidate_id,timeslot,CAST(timeslot_end as CHAR(50)) as timeslotnew_end,CAST(timeslot  as CHAR(50)) as timeslotnew_start from "+pephire+".shortlisted_candidates_trans where timeslot_end !='"'NULL'"';"
            df_ShortlistedCandidates = pd.DataFrame()
            df_ShortlistedCandidates = db_read(sQry,pephire_db_trans,"select")
           
            #if its not empty, get the candidate id and interview details
            if df_ShortlistedCandidates.shape[0]>0:
                for i, row in df_ShortlistedCandidates.iterrows():
                    id = row['id']
                    candidate_id = row['candidate_id']
                    InterviewEndTime=row['timeslotnew_end']
                    InterviewEndTimeNew=datetime.fromisoformat(InterviewEndTime)
                    InterviewStartTime=row['timeslotnew_start']
                    InterviewStartTimeNew=datetime.fromisoformat(InterviewStartTime)
                    sQry = "SELECT organization_id from "+pephire+".candidates where id = '" +str(candidate_id)+ "' ;"
                    df_oid = pd.DataFrame()
                    df_oid = db_read(sQry,pephire_db_trans,"select")
                    if df_oid.shape[0]>0:
                        oid = df_oid['organization_id'].iloc[0]
                        #check if present time is greater than the scheduled interview time,if it is, insert stage "feedback" to candidate stages table
                        if (datetime.now()>InterviewEndTimeNew):
                            feedback='candidatefeedback'
                            user='candidate'
                            state='incomplete'
                            #Insert candidateFeedback stage for the given candidate 
                            sQry = "insert into "+pephire_trans+".candidate_stages_v2 values ('"+str(candidate_id)+"','"+feedback+"','"+str(oid)+"','"+user+"','"+state+"',now())"
                            Flag = db_write(sQry,pephire_db_trans,"others")
                            if Flag !='1':
                                logger('Failed to insert into candidate stages table',Phone)
                            else:
                                #delete from shortlisted candidates table once feedback stage has been triggered.
                                Flag=''
                                sQry = "delete FROM "+pephire+".shortlisted_candidates_trans where  id ='" + str(id) + "' "
                                Flag = db_write(sQry,pephire_db_trans,"others")
                                sQry = ''
                                if Flag !='1':
                                    print('Failed to delete from shortlisted candidates')
                        
                        #Insert candidate reminder stage if the interview is in 1hr or less
                        elif (datetime.now()>=(InterviewStartTimeNew-timedelta(hours=1))):
                            remainder='candidateremainder'
                            user='candidate'
                            state='incomplete'
                            sQry = "select * from "+pephire_trans+".candidate_stages_v2 where id = '" +str(candidate_id)+ "' and event = '" +str(remainder)+ "' ;"
                            df_candRem = db_read(sQry,pephire_db_trans,"select")
                            sQry=''
                            if df_candRem.shape[0] == 0:
                                sQry = "select status from "+pephire+".shortlisted_candidates_trans where candidate_id = '" +str(candidate_id)+ "'"
                                df_remainnderstatus = db_read(sQry,pephire_db_trans,"select")
                                remainnderstatus = df_remainnderstatus['status'].iloc[0]
                                #Check if the reminder has already been sent to the candidate, if not insert the stage in the candidate_stages_v2 table
                                if remainnderstatus!='1':
                                    sQry = "insert into "+pephire_trans+".candidate_stages_v2 values ('"+str(candidate_id)+"','"+remainder+"','"+str(oid)+"','"+user+"','"+state+"',now())"
                                    Flag = db_write(sQry,pephire_db_trans,"others")
                                    if Flag !='1':
                                        logger('Failed to insert into candidate stages table','')
                                    else:
                                        stagecheck = 'True'
                                        sQry = "update "+pephire+".shortlisted_candidates_trans set status = '1' where  id ='" + str(id) + "'"
                                        Flag = db_write(sQry,pephire_db_trans,"others")
                                        sQry = ''
                                        if Flag !='1':
                                            print('Failed to update candidateremainder status')
                                else:
                                    print('remainder question already sent')
                            else:
                                print('remainder stage already in candidate stages')
                                
                        else:
                            print('Waiting for interview')                 
        except Exception as e1:
            print("Insert failed for feedback event" + e1)            
            
            
        #%%Get interviewer list
            #Interviewer - List
        try:
            print('Get the interviewer list')
            #Get the list of interviewers who has atleast one allocated candidate
            sQry ="SELECT contact_number,id,oid,CAST(interview_end_time as CHAR(50)) as interview_end_timenew,CAST(interview_start_time as CHAR(50)) as interview_start_timenew from "+pephire+".interview_timeslots_trans where allotted_candidate_id !='"'null'"' ;"
            df_Interviewer = pd.DataFrame()
            df_Interviewer = db_read(sQry,pephire_db_trans,"select")
            sQry=""
            if df_Interviewer.shape[0]>0:
                print('Interviewer list not empty')
                #Get the interview details
                for i, row in df_Interviewer.iterrows():
                    InterviewerNumber = row['contact_number']
                    identifier= row['id'] 
                    interview_end_time=row['interview_end_timenew']
                    Interviewer_EndTimeNew=datetime.fromisoformat(interview_end_time)
                    interview_start_time=row['interview_start_timenew']
                    Interviewer_StartTimeNew=datetime.fromisoformat(interview_start_time)
                    oid = row['oid']
                    #check if interview time is less than the current time, if yes, trigger interviewerfeedback stage.
                    
                    if (datetime.now()>Interviewer_EndTimeNew):
                            print('Interviewer entered feebdack stage')
                            try:
                                #Check if the interviewer is already a part of the active conversation
                                #Get the interviewer id
                                sQry = "select reference_id from "+pephire+".interview_timeslots where contact_number='"+InterviewerNumber+"';"
                                df_intervwrid = pd.DataFrame()
                                df_intervwrid = db_read(sQry,pephire_db_trans,"select")
                                lstOfintervwrid = "','".join(df_intervwrid['reference_id'].astype(str))
                                sQry=''
                                #Check if the id is candidate_stages_v2 table
                                sQry = "select * from "+pephire_trans+".candidate_stages_v2 where id in ('"+str(lstOfintervwrid)+"') and event = 'interviewerfeedback';"
                                df_candidateinterviewer = pd.DataFrame()
                                df_candidateinterviewer = db_read(sQry,pephire_db_trans,"select")
                                print('Check for interviewers in the feedback stage')
                            except Exception as e:
                                print(e)
                                print('Error in getting interviewer details in feedback stage')
                                #If the id is present in candidate_stages_v2 table, then the interviewer is part of the active conversation
                            if df_candidateinterviewer.shape[0] >0:
                                
                                print('Interviewer already in feedback conversation')
                            
                            else:
                                intrvwfeedback='interviewerfeedback'
                                userInt='interviewer'
                                state='incomplete'
                                #insert into candidate stages table interviewer feedback stage.
                                print('insert interviewer details to candidate_stages_v2 table')
                                sQry = "insert into "+pephire_trans+".candidate_stages_v2 values ('"+str(identifier)+"','"+intrvwfeedback+"','"+str(oid)+"','"+userInt+"','"+state+"',now())"
                                Flag = db_write(sQry,pephire_db_trans,"others")
                                #Procedure call to get the interviewer details
                                sQry = "call "+pephire_trans+".proc_interviewer_feedback('"+str(identifier)+"','"+intrvwfeedback+"')"
                                Flag = db_write(sQry,pephire_db_trans,"others")
                                print('db status')
                                if Flag !='1':
                                    print('Failed to insert interviewer details into candidate stages table')
                                    
                                else :
                                    Flag=''
                                    #if the insert is successful, delete it from interview time slots table to avoid taking the value again
                                    print('Delete interviewer from interview time slot table if the insert to candidate_stages_v2 was successfull')
                                    sQry = "delete FROM "+pephire+".interview_timeslots_trans where  id ='" + str(identifier) + "'"
                                    Flag = db_write(sQry,pephire_db_trans,"others")
                                    sQry = ''
                                    if Flag !='1':
                                        print('Failed to delete from interview_timeslots ')
                                    
                        
                    #Check if the interview starts in 1 hr or less                        
                    elif (datetime.now()>=(Interviewer_StartTimeNew-timedelta(hours=1))):
                        print('Entered Interviewer Reminder Stage')
                        userInt='interviewer'
                        state='incomplete'
                        intrvwremainder='interviewerremainder'
                        sQry = ''
                        sQry = "select * from "+pephire_trans+".candidate_stages_v2 where id = '" +str(identifier)+ "' and event = '" +str(intrvwremainder)+ "';"
                        df_InterviewerRem = db_read(sQry,pephire_db_trans,"select")
                        if df_InterviewerRem.shape[0]==0:
                            try:
                                #Get the interviewer status to check if the interviewer has been in the reminder stage for the same candidate before 
                                sQry = "select InterviewerStatus from "+pephire+".interview_timeslots_trans where id = '" +str(identifier)+ "'"
                                df_remainnderstatusInt = db_read(sQry,pephire_db_trans,"select")
                                remainnderstatusInt = df_remainnderstatusInt['InterviewerStatus'].iloc[0]
                            except:
                                print('Error in finding the reminder status of the interviewer')
                            if remainnderstatusInt!='1':
                                #Add  Interviewer Reminder
                                print('Insert Interviewer Reminder Stage')
                                sQry = "insert into "+pephire_trans+".candidate_stages_v2 values ('"+str(identifier)+"','"+intrvwremainder+"','"+str(oid)+"','"+userInt+"','"+state+"',now())"
                                Flag = db_write(sQry,pephire_db_trans,"others")
                                sQry=''
                                #Procedure call
                                sQry = "call "+pephire_trans+".proc_interviewer_feedback('"+str(identifier)+"','"+intrvwremainder+"')"
                                Flag = db_write(sQry,pephire_db_trans,"others")
                                if Flag !='1':
                                    logger('Failed to insert into candidate stages table','')
                                else:
                                    #update the interviewer status to avoid adding the interviewer in the reminder stage for the same candidate again.
                                    interviewerstagecheck = 'True'
                                    sQry = "update "+pephire+".interview_timeslots_trans set InterviewerStatus = '1' where  id ='" + str(identifier) + "'"
                                    Flag = db_write(sQry,pephire_db_trans,"others")
                                    sQry = ''
                                    if Flag !='1':
                                        print('Failed to update interviewerremainder status')
                            else:
                                print('Interviewer Reminder Question already sent')
                        else:
                            print('interviewerreminder stage already in candidate stages')
                            
                            
                    else:
                        print('Empty Interviewer List')
                                        
        except Exception as e:
            print("Error while finding the interviewer list. " + e)
            
            
        #%%Trigger interviewer feedback stage
            #Interviewer – ConversationStart
        try:
            print('Send Interviewer feedback questions')
            oid=''
            #get interviewer details from interviewer details table
            sQry = "SELECT contact_number,oid,user_id,id,interview_trans_id FROM "+pephire+".interviewer_details where interview_trans_id in (select id from pephire_trans.candidate_stages_v2);"
            df_OpenConvInt = pd.DataFrame()
            df_OpenConvInt = db_read(sQry,pephire_db_trans,"select")
            df_AlreadyConversedInt = pd.DataFrame()
            print('Check if interviewer is already a part of the conversation')
            if df_OpenConvInt.shape[0]>0: 
                df_OpenConvInt['id'] = df_OpenConvInt['id'].astype(str)  
                df_OpenConvInt['Event'] = df_OpenConvInt.apply(lambda x: GetFeedbackCurrentEvent(x['interview_trans_id'],x['oid']), axis=1)  
                df_OpenConvInt['key'] = df_OpenConvInt['contact_number']+df_OpenConvInt['Event']+df_OpenConvInt['oid'].astype(str)          
            lstExistingInt = []
            df_AlreadyConversedInt = db_read("SELECT candidatePhone,stage,organization_id FROM "+pephire_trans+".last_conversation_v2",pephire_db_trans,"select") 
            if df_AlreadyConversedInt.shape[0]>0:             
                df_AlreadyConversedInt['key'] = df_AlreadyConversedInt['candidatePhone'] + df_AlreadyConversedInt['stage']+ df_AlreadyConversedInt['organization_id'].astype(str)        
                lstExistingInt = df_AlreadyConversedInt['key'].tolist()   
            if df_OpenConvInt.shape[0]>0:  
                #Exclude the numbers that are already part of active conversation
                if len(lstExistingInt)>0:                
                    df_OpenConvInt = df_OpenConvInt[~df_OpenConvInt.key.isin(lstExistingInt)] 
                if df_OpenConvInt.shape[0]>0:
                    df_OpenConvInt=df_OpenConvInt.groupby(['contact_number','oid','user_id','Event','interview_trans_id']).agg({'id':'min'}).reset_index()
                    #get event for the interviewer
                    for i,row in df_OpenConvInt.iterrows():
                        oid = row["oid"]
                        uid = row["user_id"]
                        Phone = row["contact_number"]
                        id = row["id"]
                        Event = row['Event']
                        trans_id=row['interview_trans_id']
                        print('State change oid ' + str(oid))
                        ConversationStart(Phone,str(oid),uid,Event,trans_id)
        except Exception as e:
            print("Issue while starting conversation with interviewer")
            logger(e,Phone)
        
        #%%Get latest message for interviewer  
           #Interviewer – Feedback/Reminder
            #Handles the interviewers in active conversation
        try:                         
            print('Get the latest message for the interviewer')
            df_ChatsInt = GetDeltaChats(str(int(tInt)+1))
            if df_ChatsInt.shape[0]>0:
            #Save max time from df_Chats to table as max time
                df_LatestInt = df_ChatsInt.groupby('Contact').agg({'Time':'max'}).reset_index()
                df_LatestInt = pd.merge(df_LatestInt,df_ChatsInt,on=['Contact','Time'])
                
                #Load all interviewer basic details
                df_Interviewers=pd.DataFrame()
                sQry = "select interview_trans_id,oid,user_id,contact_number,id from "+pephire+".interviewer_details where interview_trans_id in (select id from pephire_trans.candidate_stages_v2);"
                df_Interviewers = db_read(sQry,pephire_db_trans,"select")
                #Process the interviewer who as replied back as latest
                df_ResponsesInt = df_LatestInt[df_LatestInt['Direction']=='inbound'] 
                  
                if df_ResponsesInt.shape[0]>0:                 
                    df_ResponsesInt['Contact'] = df_ResponsesInt['Contact'].str.replace('+','')
                    df_Interviewers['contact_number'] = df_Interviewers['contact_number'].str.replace('+','')
                    df_ResponsesInt = pd.merge(df_ResponsesInt,df_Interviewers,left_on='Contact',right_on='contact_number')
                    if df_ResponsesInt.shape[0]>0:
                        df_ResponsesInt['Event'] = df_ResponsesInt.apply(lambda x: GetCurrentInvterviewerEvent(x['Contact'],x['oid']), axis=1)                 
                        for i, row in df_ResponsesInt.iterrows():
                            #Handing non textual responses                    
                            LastConv = row['Message']
                            Phone = row['Contact']
                            string = Phone + "," + "lastconv was " + LastConv 
                            CurrEvent = str(row['Event'])
                            oid = row['oid']
                            uid = row['user_id']
                            id= row['id']
                            int_trans_id =row['interview_trans_id']
                            print('df_ResponsesInt oid = ' + str(oid))
                            LastQnID,LastQn,LastEvent = GetLastQn(Phone,oid)  
                            if LastQnID != '': #Not able to get last qn as it is a start of conversation or restart of a completed conversation                 
                                #Handling special characters and emoticons
                                try:
                                    #The below line will fail if non alpha numeric is the response
                                    logger(string,Phone)                     
                                except:#Handling non alpha numeric characters
                                    nextQn = "Please respond in correct format. Only text allowed."
                                    source ='whatsapp'
                                    template ='none'
                                    SendChat(nextQn,source,Phone) 

                                    break   
                                nextQn,nextQnID = '',''                        
                                nextQn,nextQnID = GetNextEventQn(LastConv,LastQn,Phone,int_trans_id,LastQnID,str(oid),str(uid))
                                print('nextQn when there is response'+nextQn)
                                print('nextQnID when there is response'+nextQnID)
                                #Get the expected response source for the sent question
                                sQry = "select ResponseSource from "+pephire_trans+".qn_master_v2 where qnid = '"+nextQnID+"' and organization_id ='" + str(oid) + "';"
                                df_ResponseSource = db_read(sQry,pephire_db_trans,"select")
                                try:                
                                    response_source = df_ResponseSource['ResponseSource'][0]
                                    Flag = SendNextQuestion(Phone,oid,uid,LastQn,LastQnID,LastConv,nextQn,CurrEvent,nextQnID,response_source,int_trans_id)
                                    if Flag==False:
                                        print("error with " + Phone)
                                except Exception as e:
                                    logger(e,Phone)
                                    print('No response source')
                tInt= max(df_ChatsInt['Time'])
            else:
                print('No response from interviewer')            
        except Exception as e1:
            print("Issue while processing chats")
            logger("Issue while processing chats",Phone)
            logger(e1,'')
        
            
    except Exception as e:
        print('Exception in outer loop')
        print(e)
        


