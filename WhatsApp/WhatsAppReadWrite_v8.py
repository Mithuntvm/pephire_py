# -*- coding: utf-8 -*-
"""
Created on Wed Aug  4 13:30:25 2021

@author: Sentient
"""
from Lib_v1 import db_read,db_write,logger
import pandas as pd
from config import pephire_db_trans,lang,pephire,pephire_trans,pephire_static,twilionumber
from WhatsAppFunctions_v1 import SendChat,GetText
df_StagePriority = db_read("SELECT * FROM "+pephire_trans+".event_priority_v2;",pephire_db_trans,"select")
from Branching_v9 import GetNextEventQn

def GetLastQn(Phone,oid):
    try:
        #select the last entry from last conversation v2 table, to get the last question send, question id and event based on candidate phone number 
        sQry = "SELECT * FROM "+pephire_trans+".last_conversation_v2 where  organization_id ='"+str(oid)+"' and  candidatePhone = '" + Phone +"'  and message_source ='WHATSAPP' and created_at in (select max(created_at) FROM "+pephire_trans+".last_conversation_v2 where candidatePhone = '"+  Phone +"' and message_source ='WHATSAPP') "
        df_LastConv = db_read(sQry,pephire_db_trans,"select")
        QnID = df_LastConv['lastQnID'].iloc[0]
        Qn = df_LastConv['lastQn'].iloc[0]
        Stage = df_LastConv['stage'].iloc[0]
        print('Qn is'+Qn)
        return QnID,Qn,Stage
    except:
        return '','',''

def SendNextQuestion(Phone,oid,uid,LastQn,LastQnID,LastConv,nextQn,Event,nextQnID,response_source,id):
    print('nextQn is'+nextQn)

    # sQry = "select Template from pephire_trans.qn_master_v2 where event = '"+Event+"' and organization_id='"+str(oid)+"' and qnid = '"+str(nextQnID)+"';"
    # Template = db_read(sQry,pephire_db_trans,"select")
    # if Template.shape[0]==0:
    #     template =''
    # else:
    #     template =Template['Template'].iloc[0]
        
    #nextQn = GetText(nextQn,lang)
    source='whatsapp'
    string_wrongformat='Please respond in correct format'
    # if nextQn.startswith(string_wrongformat):
    #     template ='default_template'
        
    res = SendChat(nextQn,source,Phone)          
    try:
        if res !='success':  #replacing the old event with new for the candidate
            return 'Error'
        #If there is validation, check for valid response, log the entry to conv details with validity as NO
        #string_wrongformat=GetText('Please respond in correct format',lang)
        string_wrongformat='Please respond in correct format'

        if nextQn.startswith(string_wrongformat):
            #Updating response entry to conversation details table
            sQry = """update pephire_trans.conversation_details_v2 set response=\""""+LastConv+"""\",ValidResponse='no',Recieved=now() where candidatePhone='""" + Phone +"""'and  organization_id ='""" + str(oid) + """' and QnID = '""" + LastQnID + """'and response ="" """
            Flag = db_write(sQry,pephire_db_trans,"others")
            sQry = ''   
            if Flag !='1':
                logger('Update conversation details table failed.' , Phone)
            
            #Deleting entry for that phone number last conversation table
            sQry = "delete FROM "+pephire_trans+".last_conversation_v2 where candidatePhone = '" +Phone + "' and stage = '" + Event + "' and  organization_id ='" + str(oid) + "'"
            Flag = db_write(sQry,pephire_db_trans,"others")
            sQry = ''
            if Flag !='1':
                logger('Delete from last conversation table failed' , Phone)
            #Adding entry for that phone number last conversation table
            sQry = """insert into pephire_trans.last_conversation_v2 values('""" + Phone + """','""" + str(oid) + """','""" + str(uid) +"""',\""""+nextQn+"""\",'"""+Event+"""','"""+nextQnID+"""','"""+response_source+"""',now(),'"""+'WHATSAPP'+"""')"""
            Flag = db_write(sQry,pephire_db_trans,"others")
            sQry = ''
            if Flag !='1':
                logger('Insert to last conversation table failed.' , Phone)
            #Adding new entry to conversation details table
            sQry = """insert into pephire_trans.conversation_details_v2 values ('"""+Phone+"""','"""+str(oid)+"""','"""+str(uid)+"""',\""""+nextQn+"""\",'','','candidate',now(),'"""+nextQnID+"""',now(),'"""+'WHATSAPP'+"""')"""
            Flag = db_write(sQry,pephire_db_trans,"others")
            if Flag !='1':
                logger('Insert to conversation details table failed.' , Phone)
            #sQry = "insert into pephire_trans.conversation_history_table values ('"+twilionumber+"','"+Phone+"','"+str(oid)+"','"+str(uid)+"','"+nextQn+"','candidate',now(),'"+'WHATSAPP'+"')"
            #Flag = db_write(sQry,pephire_db_trans,"others")
            #if Flag !='1':
                #logger('Failed to update conversation_history_table table',Phone)
            sQry='' 
        #Response with no validation
        else:
            #Updating response entry to conversation details table
            sQry = """update pephire_trans.conversation_details_v2 set response=\""""+LastConv+"""\",ValidResponse='yes',Recieved=now() where candidatePhone='""" + Phone +"""' and organization_id ='""" + str(oid) + """' and QnID = '""" + LastQnID + """'and response ="" and message_source ='WHATSAPP';"""
            Flag = db_write(sQry,pephire_db_trans,"others")
            sQry = ''   
            if Flag !='1':
                logger('Update conversation details table failed .' , Phone)
           
            #Deleting entry for that phone number last conversation table
            sQry = "delete FROM "+pephire_trans+".last_conversation_v2 where candidatePhone = '" +Phone + "' and stage = '" + Event + "' and organization_id ='" + str(oid) + "' and  message_source ='WHATSAPP'"
            Flag = db_write(sQry,pephire_db_trans,"others")
            sQry = ''
            if Flag !='1':
                logger('Delete from last conversation table failed.' , Phone)
            #################################################################################################
            #sQry = "insert into pephire_trans.conversation_history_table values ('"+Phone+"','"+twilionumber+"','"+str(oid)+"','"+str(uid)+"','"+LastConv+"','candidate',now(),'"+'WHATSAPP'+"')"
            #Flag = db_write(sQry,pephire_db_trans,"others")
            #if Flag !='1':
                #logger('Failed to update conversation_history_table table',Phone) 
            ###############################################################################################
            #Adding entry for that phone number last conversation table
            sQry = """insert into pephire_trans.last_conversation_v2 values('""" + Phone + """','""" + str(oid) + """','""" + str(uid) +"""',\""""+nextQn+"""\",'"""+Event+"""','"""+nextQnID+"""','"""+response_source+"""',now(),'"""+'WHATSAPP'+"""')"""
            Flag = db_write(sQry,pephire_db_trans,"others")
            sQry = ''
            if Flag !='1':
                logger('Insert to last conversation table failed.' , Phone)
            #Adding new entry to conversation details table
            sQry = """insert into pephire_trans.conversation_details_v2 values ('"""+Phone+"""','"""+str(oid)+"""','"""+str(uid)+"""',\""""+nextQn+"""\",'','','candidate',now(),'"""+nextQnID+"""',now(),'"""+'WHATSAPP'+"""')"""
            Flag = db_write(sQry,pephire_db_trans,"others")
            if Flag !='1':
                logger('Insert to conversation details table failed.' , Phone)
            #######################################################################################################
            #sQry = "insert into pephire_trans.conversation_history_table values ('"+twilionumber+"','"+Phone+"','"+str(oid)+"','"+str(uid)+"','"+nextQn+"','candidate',now(),'"+'WHATSAPP'+"')"
            #Flag = db_write(sQry,pephire_db_trans,"others")
            #if Flag !='1':
                #logger('Failed to update conversation_history_table table',Phone) 
            #########################################################################################################
            
            sQry='' 
        #Checking whether this is the last Qn in that stage
        df_newNextQnID = db_read("SELECT nextQnID FROM "+pephire_trans+".qn_master_v2 where qnid = '" + nextQnID +"' and organization_id ='" + str(oid) + "'",pephire_db_trans,"select")        
        if str(df_newNextQnID['nextQnID'].iloc[0])=="0":
            #delete from last conversation table for that event
            sQry = "delete FROM "+pephire_trans+".last_conversation_v2 where candidatePhone = '" +Phone + "' and stage = '" + Event + "' and organization_id ='" + str(oid) + "'"
            Flag = db_write(sQry,pephire_db_trans,"others")
            sQry = ''
            if Flag !='1':
                logger('Delete from last conversation table failed.' , Phone)                
            #Delete the current stage entries using id
            sQry = "select usertype from "+pephire_trans+".candidate_stages_v2 where id = '"+str(id)+"'"
            df_typeOfUser = pd.DataFrame()
            df_typeOfUser = db_read(sQry,pephire_db_trans,"select")
            sQry = ''
            typeOfUser = df_typeOfUser['usertype'].iloc[0]
            if typeOfUser =='interviewer':
                sID = id
            else:
                sQry = "SELECT * FROM "+pephire+".candidates where phone='" + Phone +"' and organization_id ='" + str(oid) + "'and deleted_at is NULL; "
                sID = str(db_read(sQry,pephire_db_trans,"select")['id'].iloc[0])
                
            sQry = "delete FROM "+pephire_trans+".candidate_stages_v2 where id = '" +str(sID) + "' and event = '" + Event + "'"
            Flag = db_write(sQry,pephire_db_trans,"others")
            sQry = ''
            if Flag !='1':
                logger('Delete from last conversation table failed.' , Phone)
            #Get the remaining uncompleted events for the candidate
            sQry = "select * from "+pephire_trans+".candidate_stages_v2 where id = '" +str(sID) + "'"
            df_RemainingStages = db_read(sQry,pephire_db_trans,"select")
            sQry = ''
            if Flag !='1':
                logger('Delete from last conversation table failed.', Phone)
            #Continue with the other stages
            if df_RemainingStages.shape[0]>0:
                #Get candidate phone
                df_Candidates = db_read("select phone,id from "+pephire+".candidates where id ='" +str(sID) +"'",pephire_db_trans,"select")
                df_Candidates['id'] = df_Candidates['id'].astype(str)
                #Get conversation details for that candidate
                df_ConversationDetails = db_read("SELECT * FROM "+pephire_trans+".conversation_details_v2 where organization_id='"+str(oid) + "' and candidatePhone = '" + Phone +"'",pephire_db_trans,"select")
                #Load question master
                df_QnMaster = db_read("select * from "+pephire_trans+".qn_master_v2 where organization_id='"+str(oid)+"'",pephire_db_trans,"select")
                #Get all conversation for that candidate in one table
                df_CandidateMessages = pd.merge(df_Candidates,df_ConversationDetails,left_on='phone',right_on='candidatePhone')
                #Merge with qn master to get stage of each question
                df_CandidateMessages = pd.merge(df_CandidateMessages,df_QnMaster,left_on='QnID',right_on='qnid')
                #Get the latest updated time for each event
                df_LatestMessageinEvent = df_CandidateMessages.groupby(['phone','event']).agg({'Recieved':'max'})
                #Get the latest entry corresponding to last update for each event
                df_LatestMessageinEvent = pd.merge(df_LatestMessageinEvent,df_CandidateMessages,on=['phone','event','Recieved'])
                #Get incomplete conversations
                #Find the completed events and remove them
                df_CompletedEvents = df_LatestMessageinEvent[df_LatestMessageinEvent['nextQnID']=='0']
                lstCompletedEvents = df_CompletedEvents['event'].tolist()
                #Remove the completed events 
                df_IncompleteConversations = df_LatestMessageinEvent[~df_LatestMessageinEvent['event'].isin(lstCompletedEvents)]
                #Merge with stage priority to get stage with highest priority
                df_IncompleteConversations = pd.merge(df_IncompleteConversations,df_StagePriority,on='event')
                #Get max priroity event
                df_MaxPriority = df_IncompleteConversations.groupby('phone').agg({'priority':'max'})
                #Get the event to be continued based on priority
                df_NextQn = pd.merge(df_MaxPriority,df_IncompleteConversations,on=['phone','priority'])
                df_RemainingStages = pd.merge(df_RemainingStages,df_Candidates[['phone','id']],on='id')
                #Get the last qn for the incomplete event again
                df_RemainingStages = pd.merge(df_RemainingStages,df_NextQn,on=['phone','event'])
                #Get the latest entry and if not responded then resent
                df_LatestResponse = df_RemainingStages[df_RemainingStages['Sent']==max(df_RemainingStages['Sent'])]
                response=df_LatestResponse['response'].iloc[0]
                QnID=df_LatestResponse['QnID'].iloc[0]
                if response=='':#if there is no response for last question, send the question again
                    # df_LatestResponse['Qn'].iloc[0] = GetText(df_LatestResponse['Qn'].iloc[0],lang) 
                    df_LatestResponse['Qn'].iloc[0] = df_LatestResponse['Qn'].iloc[0]
                    
                    source ='whatsapp'
                    template ='none'
                    SendChat(df_LatestResponse['Qn'].iloc[0],source,Phone)
                elif df_RemainingStages.shape[0]>0: #If last qn has response sent the next qn in that event
                    LastConv=df_LatestResponse['response'].iloc[0]
                    LastQn=df_LatestResponse['qnText'].iloc[0]
                    Phone=df_LatestResponse['phone'].iloc[0]
                    id=df_LatestResponse['id_x'].iloc[0]
                    LastQnID=df_LatestResponse['qnid'].iloc[0]
                    uid=df_LatestResponse['user_id'].iloc[0]
                    oid=df_LatestResponse['oid'].iloc[0]
                    #find the next question to be send
                    sQn = GetNextEventQn(LastConv,LastQn,Phone,id,LastQnID)
                    nextQn=sQn[0]
                    nextQnID=sQn[1]
                    Event=df_LatestResponse['event'].iloc[0]
                    response_source=df_LatestResponse['ResponseSource'].iloc[0]
                    #send the next question and update the databases
                    res = SendNextQuestion(Phone,oid,uid,LastQn,LastQnID,LastConv,nextQn,Event,nextQnID,response_source,id)
                    if res !='success':  #replacing the old event with new for the candidate
                        print ('Error in continuing with incomplete events for ' + Phone)
                    return True
                else:
                     print('No question for ' + Phone)
                     return True
    except Exception as e:
        print('Error in sending next qn')
        logger(e,Phone)
        return False
        
