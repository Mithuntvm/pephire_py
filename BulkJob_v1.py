# -*- coding: utf-8 -*-
"""
Created on Fri May 15 13:27:43 2020

@author: mithun

"""

"""
Service to do recommendation for a particular job id and return the best match with their fitment score 
based on the differenet job ids given by the user of an organization 
"""

import requests,json,pandas as pd, mysql.connector
from config import pephire_db,pephire,pephire_trans,pephire_static
from flask import Flask, request
from datetime import datetime
app = Flask(__name__)
app.config["DEBUG"] = True
#urls for uploading job descriptions and resumes 
urlpostjob = 'http://127.0.0.1/postjob'
urlpostresume = 'http://127.0.0.1/postresumes'
urlrecommend= 'https://recommendationdemo.azurewebsites.net/api/recommendation?code=T7np9ubbjEMb-j945tUuYpCHMVKeZJhyW7XmzfGknd0oAzFuyWpcvA=='
urlfitment= 'https://fitmentdemo.azurewebsites.net/api/fitment?code=OsF22D-8gkLuz7RwDr_0fhmuhJW7-mxd8Mfcs8xzIbX-AzFuEbgIxA=='

#Select the top three profiles for each jd. Each resume is matched to only one jd 
def BestMatchFn(FitOpDf,vacant_positions):
    FitOpDf = FitOpDf.merge(vacant_positions,on='Jd')
    MappedResumes = [] 
    MappedJD = []
    BestMatch = pd.DataFrame()
    FitOpDfSorted = FitOpDf.sort_values(by = ["NormScore"], ascending = False).reset_index(drop=True)
    for i,row in FitOpDfSorted.iterrows():
        if row['resume_id'] not in MappedResumes and row['Jd'] not in MappedJD:
            BestMatch = BestMatch.append(row)
            MappedResumes.append(row['resume_id'])
            total_positions = 3*row['vacant_positions']           
            
            # if BestMatch.shape[0]==total_positions:
            #     break
            
            if BestMatch[BestMatch['Jd']==row['Jd']].shape[0]==total_positions:
                MappedJD.append(row['Jd'])                
    #print(BestMatch.astype(int).to_dict(orient='records'))
    return json.dumps(BestMatch.astype(int).to_dict(orient='records'))
#Do recommendation for each resume, do fitment for each jd for the recommended resumes and return Fitment output with 'Score'
def RecFitJob(Jd,ResumeList,oid,user_id):
    RecOp = []
    FitOpDf = pd.DataFrame()
    print('Recommendation started'+str(datetime.now()))
    for i,row in Jd.iterrows():
        try:
            #json data to get the recommended resumes for the particular JD   
            print('Resume List')
            print(ResumeList)
            jsondata = {"description":Jd['description'][i],"job_role":Jd['job_role'][i],"MinExp":Jd['min_experience'][i],"MaxExp":Jd['max_experience'][i],"ctc":Jd['offered_ctc'][i],"location":Jd['location'][i],"joining_date":Jd['joining_date'][i].strftime("%Y-%m-%d"),"organization_id":oid,"user_id": user_id}
            r = requests.post(urlrecommend,json=jsondata)
            print(r.text)
            
            
            
            RecResumes = list(pd.DataFrame.from_dict(r.json())['candidate_id'])
            print('Recommended Resumes')
            
            print(RecResumes)
            for k in RecResumes:
                RecOp.append({'Jd':Jd['id'][i],'Recommendations':k})
        except:
            RecOp.append({'Jd':Jd['id'][i],'Recommendations':''})
    print('Recommendation End'+ str(datetime.now()))    
    RecOpDf = pd.DataFrame(RecOp)
    if RecOpDf.shape[0]>0:
        RecOpDf = RecOpDf[RecOpDf['Recommendations'] != '']
        for index,i in enumerate(list(RecOpDf.Jd.unique())):
            #Get the list of recommended resumes
            ResumesRecommended = list(RecOpDf['Recommendations'][RecOpDf['Jd']==i])
            ResumesRecommended = [str(a) for a in ResumesRecommended]            
            jsondata = {"job_id": str(index), "description": Jd[Jd['id']==i].reset_index(drop=True)['description'][0], "resume_id": '|'.join(ResumesRecommended), "organization_id": oid,"user_id": user_id }
            # print('Fitment started'+ str(datetime.now()))
            #Get fitment output with score
            r = requests.post(urlfitment,json=jsondata)
            FitList = json.loads(r.text)
            for j in FitList:
                j.update({'Jd':i})
            FitOpDf = FitOpDf.append(pd.DataFrame(FitList))
        
        print('Fitment End'+ str(datetime.now()))
        return FitOpDf
    else:
        return ''

@app.route('/bestfit', methods=['POST'])   

def BulkFitment(): 
    Time1 = datetime.now()
    job_id =[]
    org_id =[]
    user_id=[]
    #vacant_positions = 4
    jsonf = request.data
    jsonf=jsonf.decode("utf-8")
    #Get job_id,organization_id and user_id from UI
    
    data = json.loads(jsonf)
    print('data')
    print(data)
    f = open("BulkJob.txt", "w")
    f.write(str(data))
    f.close()
    
    job_id = data['job_id']
    org_id = data['organization_id']
    user_id = data['user_id']
    job_id ="','".join(job_id)
    print('Connecting at ' + str(datetime.now()))
    mydb = mysql.connector.connect(**pephire_db)
    #Get the values for all fields for the particular job id     
    Jd = pd.read_sql("SELECT * FROM "+pephire+".jobs where id in('"+str(job_id)+"') and organization_id = '"+str(org_id)+"' ;"  ,mydb) 
    #JD = "SELECT * FROM pephire.jobs where bulk_job_id in('"+str(job_id)+"') and organization_id = '"+str(org_id)+"' ;"
    #Get the list of resumes uploaded
    ResumeList = list(pd.read_sql("select * from "+pephire+".candidates where organization_id = '"+str(org_id)+"' and deleted_at is NULL;",mydb)['resume_id'])
    #vacant_positions= pd.read_sql("SELECT vacant_positions FROM pephire.jobs where id in('"+str(job_id)+"') and organization_id = '"+str(org_id)+"' ;",mydb)
    vacant_positions = pd.read_sql("select vacant_positions,id as Jd from "+pephire+".jobs where id in('"+str(job_id)+"') and organization_id = '"+str(org_id)+"' ;",mydb)
    #vacant_positions = list(pd.read_sql("select vacant_positions from pephire.jobs where id in('"+str(job_id)+"') and organization_id = '"+str(org_id)+"' ;",mydb))
    #JD = pd.read_sql(JD,mydb)
    mydb.close()
    print('Connectioon closed  at ' + str(datetime.now()))
    #Function call to do recommendation for each resume, do fitment for each jd for the recommended resumes and return Fitment output with 'Score'
    FitOpDfOut=RecFitJob(Jd,ResumeList,org_id,user_id)
    print('Recommended at ' + str(datetime.now()))
   
    try:
        # Function call to select the top three profiles for each jd. Each resume is matched to only one jd  
        BestMatchJson = BestMatchFn(FitOpDfOut,vacant_positions)
        print(BestMatchJson)
        print('Matched at ' + str(datetime.now()))
        # print(BestMatchJson)
        Time2 = datetime.now()
        TimeDiff=Time2-Time1
        TimeDiff=TimeDiff.total_seconds()
        print('TimeDiff ' + str(TimeDiff))
        bulkRes = json.loads(BestMatchJson)
        f = open("BulkJobRes.txt", "w")
        f.write(str(bulkRes))
        f.close()
        return BestMatchJson
    except:
        return "No recommendation"
    
print('Ready to Serve')
from gevent.pywsgi import WSGIServer
http_server = WSGIServer(('127.0.0.1',6001), app)
http_server.serve_forever()
    
    