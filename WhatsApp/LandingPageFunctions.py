
from Lib_v1 import db_read,db_write,logger
import os,pandas as pd
from config import pephire_db_trans,currDir,lang,pephire,pephire_trans
os.chdir(currDir)
from WhatsAppFunctions_v1 import SendChat,ConversationStart
from datetime import datetime 
import re


def WhatsAppAlertRemove(job_id,req_id,org_id):
    if req_id != "":
        #The flow is autonomous, the mapped candidates are taken from autonomous_fits_logs table
        #And update the stage to removedJD in configurable_candidatestages
        
        sQry = "delete FROM "+pephire_auto+".autonomous_fits_logs where ReqID = '" +req_id+ "'orgID ='" + str(org_id) + "'"
        Flag = db_write(sQry,pephire_db_trans,"others")
        sQry = ''
        if Flag !='1':
            logger('Delete from autonomous_fits_logs table failed' , Phone)
            
        sQry = """update pephire.configurable_candidatestages set stage=\""""+RemovedJD+"""\" where job_id='""" +job_id+"""'and  org_id ='""" + str(org_id)+"""'  """
        Flag = db_write(sQry,pephire_db_trans,"others")
        sQry = ''   
        if Flag !='1':
            logger('Update configurable_candidatestages table failed.')
            
        #The list of candidate is taken from configurable_candidatestages table 
        sQry = "select candidate_id from "+pephire+".configurable_candidatestages where job_id = "+job_id+" " 
        df_removedCandidates = db_read(sQry,pephire_db_trans,"select")
        listcandidate_id =df_removedCandidates['candidate_id'].to_list()
        listcandidateIDs = "({})".format(", ".join(map(repr,listcandidate_id))) 
        sQry = "SELECT phone,organization_id,user_id,id FROM "+pephire+".candidates where id in "+listcandidateIDs+";"
        df_RemCandidateDetails = pd.DataFrame()
        df_RemCandidateDetails = db_read(sQry,pephire_db_trans,"select")
        for i, row in df_RemCandidateDetails.iterrows():
            Phone = row['phone']
            CurrEvent = 'RemovedJD'
            oid = row['organization_id']
            uid = row['user_id']
            id= row['id']
            ConversationStart(Phone,oid,uid,CurrEvent,id)
        
    else:
        #The list of candidate is taken from candidate_jobs table 
        sQry = "select candidate_id from "+pephire+".candidate__jobs where job_id = "+job_id+" " 
        df_removedCandidates = db_read(sQry,pephire_db_trans,"select")
        listcandidate_id =df_removedCandidates['candidate_id'].to_list()
        listcandidateIDs = "({})".format(", ".join(map(repr,listcandidate_id))) 
        sQry = "SELECT phone,organization_id,user_id,id FROM "+pephire+".candidates where id in "+listcandidateIDs+";"
        df_RemCandidateDetails = pd.DataFrame()
        df_RemCandidateDetails = db_read(sQry,pephire_db_trans,"select")
        for i, row in df_RemCandidateDetails.iterrows():
            Phone = row['phone']
            CurrEvent = 'RemovedJD'
            oid = row['organization_id']
            uid = row['user_id']
            id= row['id']
            ConversationStart(Phone,oid,uid,CurrEvent,id)
    

