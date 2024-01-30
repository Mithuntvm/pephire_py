# -*- coding: utf-8 -*-
"""
Created on Tue Aug  3 12:53:49 2021

@author: Sentient
"""
########
import requests
########
from Lib_v1 import db_read,db_write,logger
import os,pandas as pd
from config import pephire_db_trans,currDir,lang,pephire,pephire_trans
os.chdir(currDir)
df_GeneratedQns = pd.read_excel('Personality.xlsx')
from WhatsAppFunctions_v1 import GetCurrentEvent,GetText,GetCurrentInvterviewerEvent
##################################
from WhatsAppFunctions_v1 import SendChat
from datetime import datetime 
import re
##################################
#create a dataframe with each intent mapped to the ans of each intent
LUIS_df =pd.DataFrame()
data_luis = [['Joining_date', 'Your joining date is '], ['worklocation', 'Your work location will be at '], ['experience', 'The experience required for this job role in years is '],['CTC','Your annual CTC is Rs. '],['job role','Your job role will be as a '],['Job Title','Your job title will be as a '],['description','The job description is '],['Company_strength','The company is a Start-up with  40 employees'],['enterprise_startup','The company is not an eterprise it is a start-up'],['Incentive_bonus','Incentive and bonus schemes are available on our website'],['leave_policy','For leave policies and holidays please refer our site'],['travel','On-site oppertunities are available'],[]]
 
# Create the pandas DataFrame
LUIS_df = pd.DataFrame(data_luis, columns = ['Intents', 'Response'])
 
#create mapping of each intent to the column names of jobs table  
df_mapped =pd.DataFrame()
data_mapping = [['Joining_date', 'joining_date'], ['experience', 'max_experience'], ['CTC', 'offered_ctc'],['description','description'],['job role','job_role'],['Job Title','name'],['worklocation','location'],['None','Thanks']]
df_mapped = pd.DataFrame(data_mapping, columns = ['Intents', 'cols'])


def LUIS(Phone,LastQn,LastQnID,LastConv,Event,oid,uid):
        try:
        #GET the candiidate from candidate table 
            df_cand,df_ShortlistedCandidatesLUIS =pd.DataFrame(),pd.DataFrame()
            candidate_id =''
            sQry = "select id,phone from "+pephire+".candidates where phone in ("+Phone +")" 
            df_cand = db_read(sQry,pephire_db_trans,"select")
            candidate_id =df_cand['id'].iloc[0]
    
            #get the job details of the candidate short-listed from shortlisted_candidates table
            sQry = "select job_id,candidate_id from "+pephire+".shortlisted_candidates where candidate_id in ("+str(candidate_id) +")" 
            df_ShortlistedCandidatesLUIS = db_read(sQry,pephire_db_trans,"select")        
            sQry =''
            if df_ShortlistedCandidatesLUIS['job_id'].shape[0]>0:
                #get all the required details for luis answers from the table
                job_id =str(df_ShortlistedCandidatesLUIS['job_id'].iloc[0])
                sQry = "select id,name, description, joining_date, max_experience ,location ,job_role ,offered_ctc from "+pephire+".jobs where id in ("+job_id +")"
                df_jobs = db_read(sQry,pephire_db_trans,"select")
                df_jobs['joining_date']= df_jobs['joining_date'].astype(str)
                df_jobs['joining_date'] = df_jobs['joining_date'].str[:-3]
                df_jobs['joining_date'] =df_jobs['joining_date'].astype(int)
                df_jobs['joining_date'] =datetime.utcfromtimestamp(df_jobs['joining_date']).strftime('%Y-%m-%d %H:%M:%S')
                sQry ='' 
                #join with shortlisted candidate table
                df_jobs =df_jobs.merge(df_ShortlistedCandidatesLUIS,left_on=['id'],right_on=['job_id'],how='inner')
                sPhoneNumber = Phone
                message = LastConv
                #hit the end point with the question ask by candidate and get the response
                url='https://westus.api.cognitive.microsoft.com/luis/v2.0/apps/c06c705a-41f9-471e-ab1d-804c86075cfd?verbose=true&timezoneOffset=0&subscription-key=763ac821934c44929fc0042ccba99a38&q='
                postingurl =url+message
                response = requests.get(postingurl)
                responsestring = response.json()
                topintent=responsestring.get("topScoringIntent")
                score =  topintent.get("score")
                print(score)
                print(topintent.get("intent"))
                #if score is greater  than 40% give response
                if score > 0.4 and topintent.get("intent")!="None":

                        
                    whatsappresponse= topintent.get("intent")
                    valuesend =LUIS_df[LUIS_df["Intents"]==whatsappresponse]['Response'].iloc[0]
                    dbheader = df_mapped[df_mapped['Intents']==whatsappresponse]['cols'].iloc[0]
                    dbheader = str(dbheader)
                    db_val =df_jobs[dbheader].iloc[0]
                    source ='whatsapp'
                    qn ='LUIS'
                    template ='default_template'
                    resp_msg = valuesend+db_val
                    sending =SendChat(resp_msg,source,sPhoneNumber)
                    if sending =='success':
                        sQry = """insert into pephire_trans.conversation_details_v2 values ('"""+Phone+"""','"""+str(oid)+"""','"""+str(uid)+"""',\""""+resp_msg+"""\",'','','candidate',now(),'"""+'LUIS'+"""',now(),'"""+'WHATSAPP'+"""')"""
                        Flag = db_write(sQry,pephire_db_trans,"others")
                        if Flag !='1':
                            logger('Insert to conversation details table failed.' , Phone) 
                        #sQry = "insert into pephire_trans.conversation_history_table values ('"+twilionumber+"','"+Phone+"','"+str(oid)+"','"+str(uid)+"','"+resp_msg+"','candidate',now(),'"+'WHATSAPP'+"')"
                        #Flag = db_write(sQry,pephire_db_trans,"others")
                        #print("conversation_history_table updated")
                        #if Flag !='1':
                            #logger('Failed to update conversation_history_table table',Phone)   
    
                    Last_question = resp_msg
                else:
                    Last_question=  LastQn
                    

        except:
                LastQn,LastQnID
                
        return LastQn,LastQnID
    
     


def GetNextEventQn(LastConv,LastQn,Phone,id,LastQnID,oid,uid):
    #Function to get the next question based on the event and response received for last question
    try:
        sQry = "select usertype from "+pephire_trans+".candidate_stages_v2 where id = '"+str(id)+"';"
        df_usertype = pd.DataFrame()
        df_usertype =db_read(sQry,pephire_db_trans,"select")  
        usertype = df_usertype['usertype'].iloc[0]
        if usertype == 'candidate':
            Event = GetCurrentEvent(Phone,oid)
        else:
            Event = GetCurrentInvterviewerEvent(Phone,oid)
        sQry = "select * from "+pephire_trans+".qn_master_v2 where  organization_id='"+str(oid)+"';"
        #Get the question master
        df_qnmaster = db_read(sQry,pephire_db_trans,"select")
        if LastQn==''  :
            print('No last question')     
        else:        
            sQry = "select validation,validationValues,nextQnID from "+pephire_trans+".qn_master_v2 where QnID = '"+LastQnID+"' and organization_id='"+str(oid)+"';"
            df_validation = db_read(sQry,pephire_db_trans,"select")
            #Checking for correct response for qns that has failed validation check
            if df_validation['validation'].iloc[0]=='yes'and any(item not in list(df_validation['validationValues'].iloc[0].split(',')) for item in LastConv.lower().split(',')) :
                #send the previous question, if the response is in wrong format
                
                
                
                Last_question,LastQnID = LUIS(Phone,LastQn,LastQnID,LastConv,Event,oid,uid)
                substring ='Please respond in correct format.Your last question was '
                
                if substring in Last_question:
                    Last_question =Last_question.replace(substring, '')
                    #print("---------------"+Last_question)
                else:
                    print("not repeated")
                    #print("++++++++"+Last_question)
                Last_question = GetText('Please respond in correct format.Your last question was ',lang)+ Last_question
                #print("******************"+Last_question)
                #Last_question =  GetText(Last_question,lang)
                return  Last_question,LastQnID 
            #Sending next question if no validation check
            elif df_validation['validation'].iloc[0]=='no':
                Next_QuestionId = df_validation['nextQnID'].iloc[0]            
                #Closing the conversation on the last qn in that event
                if Next_QuestionId=='0':                
                    InitialInsQry = " delete from "+pephire_trans+".candidate_stages_v2 where id = '"+str(id)+"' and event = '"+Event+"';"
                    InitialInsFlag = db_write(InitialInsQry,pephire_db_trans,"others")
                    if InitialInsFlag!='1':
                        logger('Failed to delete from candidate stages DB',Phone) 
                    return 'End',''
                else:#send next question for qns with no validation
                    sQry = "select Type,Category from "+pephire_trans+".qn_master_v2 where qnid = '"+Next_QuestionId+"' and organization_id='"+str(oid)+"';"
                    df_Type = db_read(sQry,pephire_db_trans,"select")
                    Type = df_Type['Type'].iloc[0]
                    Category =''
                    Category =  df_Type['Category'].iloc[0]
                    if  Type == 'Replace':
                        sQry = " select * from "+pephire_trans+".personalization_parameters_v2 where Phone='" + Phone +"' and oid='"+str(oid)+"';"
                        df_personalization_parameter = db_read(sQry,pephire_db_trans,"select")
                        sQry = " select qnText from "+pephire_trans+".qn_master_v2 where qnid = '"+Next_QuestionId+"' and organization_id='"+str(oid)+"';"
                        next_question = db_read(sQry,pephire_db_trans,"select")
                        nextQn = next_question['qnText'].iloc[0]
                        #lstParams = ['Name','Job','Link']
                        lstParams = list(df_personalization_parameter['Parameters'])
                        #for ch in lstParams:
                        for i,ch in enumerate(lstParams):
                            try:
                                value = df_personalization_parameter.ParameterValue[df_personalization_parameter.Parameters==ch][i]
                                nextQn = nextQn.replace('<','')
                                nextQn = nextQn.replace('>','')
                                nextQn = nextQn.replace(ch,value)
                            except:
                                pass                        
                        return nextQn,Next_QuestionId                    
                    elif Type == 'lookup':
                        sQry = "select * from "+pephire_trans+".qn_master_v2 where qnid = '"+Next_QuestionId+"' and organization_id='"+str(oid)+"';"
                        df_category = db_read(sQry,pephire_db_trans,"select")
                        Category = df_category['Category'][0]
                        Sub_Category = df_category['qnText'][0]
                        df_PersonalityQns = pd.DataFrame()
                        
                        #if df_GeneratedQns[df_GeneratedQns['Category']=='Personality']:
                        Temp = df_GeneratedQns[df_GeneratedQns['SubCategory']==Sub_Category]
                        df_Positive = Temp[Temp['Weightage']==1].sample(n=2)
                        df_Negative = Temp[Temp['Weightage']==-1].sample(n=2)
                        #Combine to a single table
                        df_QnPersonalityCategory = (df_Positive).append(df_Negative)
                        df_QnPersonalityCategory = df_QnPersonalityCategory.reset_index().reset_index()
                        df_QnPersonalityCategory['Question'] = (df_QnPersonalityCategory['level_0']+1).astype(str)+". "+df_QnPersonalityCategory['Question']
                        df_PersonalityQns = df_PersonalityQns.append(df_QnPersonalityCategory)
                        #df_PersonalityQns_Grped = df_PersonalityQns.groupby('Category')['Question'].apply('<br>'.join)
                        df_PersonalityQns_Grped = df_PersonalityQns.groupby('Category')['Question'].apply('\n'.join)                        
                        df_PersonalityQns_Grped = df_PersonalityQns_Grped.reset_index()
                        # df_PersonalityQns_Grped['Question']="Select one of the four statements given below (Type 1 if you most agree with statement 1)<br>"+df_PersonalityQns_Grped['Question'].astype(str)
                        df_PersonalityQns_Grped['Question']="Select one of the four statements given below (Type 1 if you most agree with statement 1)\n"+df_PersonalityQns_Grped['Question'].astype(str)
                        
                        nextQn = df_PersonalityQns_Grped['Question']
                        nextQn=nextQn[0]
                        return nextQn,Next_QuestionId                        
                    else:                        
                        sQry = " select qnText from "+pephire_trans+".qn_master_v2 where qnid = '"+Next_QuestionId+"' and organization_id='"+str(oid)+"';"
                        next_question = db_read(sQry,pephire_db_trans,"select")
                        nextQn = next_question['qnText'].iloc[0]
                        return nextQn,Next_QuestionId
            else:#Checking for correct response for qns that has successful validations
                sQry = "select * from "+pephire_trans+".qn_master_v2 where QnID = '" +LastQnID+"' and organization_id='"+str(oid)+"';"
                df_Options = db_read(sQry,pephire_db_trans,"select")
                Temp = df_Options["branch"].str.split(',').apply(pd.Series,1).stack()
                Temp.index = Temp.index.droplevel(-1)
                Temp.name = "branch"
                Temp.reset_index(drop=True)
                del df_Options["branch"]
                df_Options=df_Options.join(Temp)
                df_Options= df_Options.reset_index(drop=True)
                df_Options.branch = df_Options.branch.astype(str).str.lower()
                df_Options = df_Options[df_Options['branch'].isin(LastConv.lower().split(','))]
                nextQnNo = df_Options['nextQnID'].drop_duplicates().iloc[0]
                if nextQnNo == '0':#Closing conversation in that event                   
                    InitialInsQry = " delete from "+pephire_trans+".candidate_stages_v2 where id = '"+str(id)+"' and event = '"+Event+"';"
                    InitialInsFlag = db_write(InitialInsQry,pephire_db_trans,"others")
                    if InitialInsFlag!='1':
                        logger('Failed to delete from candidate stages DB',Phone) 
                    return "End",''
                else:#Sending next qn after validation
                  sQry = "select Type,Category from "+pephire_trans+".qn_master_v2 where qnid = '"+nextQnNo+"' and organization_id='"+str(oid)+"';"
                  df_Type = db_read(sQry,pephire_db_trans,"select")
                  if df_Type.shape[0]>0:
                      Type = df_Type['Type'].iloc[0]
                      Category =  df_Type['Category'].iloc[0]
                  else:
                      Type = ' '
                      Category = ' '
                  if  Type == 'Replace':
                      sQry = " select * from "+pephire_trans+".personalization_parameters_v2 where Phone='" + Phone +"' and oid='"+str(oid)+"';"
                      df_personalization_parameter = db_read(sQry,pephire_db_trans,"select")
                       
                      sQry = " select qnText from "+pephire_trans+".qn_master_v2 where qnid = '"+nextQnNo+"' and organization_id='"+str(oid)+"';"
                      next_question = db_read(sQry,pephire_db_trans,"select")
                      nextQn = next_question['qnText'].iloc[0]
                      if df_personalization_parameter.shape[0]>0:
                      #lstParams = ['Name','Job','Link']
                          lstParams = list(df_personalization_parameter['Parameters'])
                          parval =[]
                          parameters =re.findall("\<(.*?)\>", nextQn)
                          #for ch in lstParams:
                          for i,ch in enumerate(lstParams):
                              try:
                                  value = df_personalization_parameter.ParameterValue[df_personalization_parameter.Parameters==ch][i]
                                  nextQn = nextQn.replace('<','')
                                  nextQn = nextQn.replace('>','')
                                  nextQn = nextQn.replace(ch,value)
                                  # if ch in parameters:
                        
                                  #     b = [{"type": "text", "text": value}]
                                  #     parval =parval +b
                                      
                              except:
                                  pass
                              

                          
                      return nextQn,nextQnNo
                  elif Type == 'lookup':
                      sQry = "select * from "+pephire_trans+".qn_master_v2 where qnid = '"+nextQnNo+"' and organization_id='"+str(oid)+"';"
                      df_category = db_read(sQry,pephire_db_trans,"select")
                      Category = df_category['Category'][0]
                      Sub_Category = df_category['qnText'][0]
                      df_PersonalityQns = pd.DataFrame()
                      #if df_GeneratedQns[df_GeneratedQns['Category']=='Personality']:
                      Temp = df_GeneratedQns[df_GeneratedQns['SubCategory']==Sub_Category]
                      df_Positive = Temp[Temp['Weightage']==1].sample(n=2)
                      df_Negative = Temp[Temp['Weightage']==-1].sample(n=2)
                        #Combine to a single table
                      df_QnPersonalityCategory = (df_Positive).append(df_Negative)
                      df_QnPersonalityCategory = df_QnPersonalityCategory.reset_index().reset_index()
                      df_QnPersonalityCategory['Question'] = (df_QnPersonalityCategory['level_0']+1).astype(str)+". "+df_QnPersonalityCategory['Question']
                      df_PersonalityQns = df_PersonalityQns.append(df_QnPersonalityCategory)
                      df_PersonalityQns_Grped = df_PersonalityQns.groupby('Category')['Question'].apply('\n'.join)
                      df_PersonalityQns_Grped = df_PersonalityQns_Grped.reset_index()
                      df_PersonalityQns_Grped['Question']="Select one of the four statements given below (Type 1 if you most agree with statement 1)\n"+df_PersonalityQns_Grped['Question'].astype(str)
                      nextQn = df_PersonalityQns_Grped['Question']
                      nextQn=nextQn[0]
                      return nextQn,nextQnNo
                  else:
                      df = df_qnmaster[df_qnmaster['qnid']==nextQnNo]
                      nextQn = df['qnText'].iloc[0]
                      return nextQn,nextQnNo
    except Exception as e:
        print("fail")
        logger(e,Phone)
        