# -*- coding: utf-8 -*-
print('Loading lib')
from CompanyLib import CompanyExtraction
print('Loaded lib')
import os.path
import pyodbc 
import time
from datetime import datetime as dt
from time import gmtime, strftime
print('start of processing')
while(True):    
     #Connect using DSN
    cnxn = pyodbc.connect("DSN=Pephire")    
    cursor = cnxn.cursor()
    print('Checking for new entries with no companies on '+ str(dt.now()))
    #Execute select to get resumes with company name not checked
    cursor.execute("select name,id,resume_id,company_name_checked from pephire.candidates where (company_name_checked=0);")
    Candidates=cursor.fetchall()
    #Candidates = Candidates[:3]
    #Loop through each row with company check not done and get the company name
    for Candidate in Candidates:
        print(Candidate[0])
        sCandidateID = str(Candidate[1])
        sResumeID = str(Candidate[2])
        Qry = "select resume,name from pephire.resumes where id='" + str(sResumeID) + "'"
        cursor.execute(Qry)
        Resumes = cursor.fetchall()
        for Resume in Resumes:
            Resumepath = Resume[0].replace('/','\\\\')
            Resumepath = r'C:\\Myweb\\piphire\\public\\storage\\' + str(Resumepath) 
            #print("Function call with " + Resumepath)        
            if(os.path.exists(Resumepath)):
                LogFile = open("FileList.txt","a") 
                LogFile.writelines(Resumepath + '\n')
                LogFile.close()

                Result = str(CompanyExtraction(Resumepath))
                #print(Result)
                if(len(Result)>0):
                    #Result = 'Wipro Technologies | Toshiba | Global Engineering Service Pvt Ltd | Kameda Infologics Pvt Ltd'
                    Companies = Result.split(' | ')                
                    sTimenow = strftime("%Y-%m-%d %H:%M:%S", gmtime()) 
                    #Check whether the company exists in company master table, else add the entry
                    for Company in Companies:
                        try:
                            cursor.execute("select couid,name from pephire.companies where name = '" + Company+"';")
                            CmpnyList=cursor.fetchall()                            
                            #insert a new entry if company doesnt exist
                            if(len(CmpnyList)==0 and len(Company)>0):
                                print('Adding company '+ Company +' to Company master')
                                try:
                                    del(rt)
                                except:
                                    pass
                                cursor.execute("select max(couid) as c1 from pephire.companies;")
                                rt = cursor.fetchall()
                                for c in rt:
                                    couid = int(c[0])+1
                                    couid = str(couid)
                                del(rt)
                                sInsertQry = "insert into pephire.companies values ('" + couid + "','"+couid+"','"+Company+"','"+sTimenow+"','"+sTimenow+"','"+sTimenow+"');"
                                cursor.execute(sInsertQry)
                                cnxn.commit()
                            #If company exist get the couid e
                            else:
                                print('Company ' + Company +' already exists in DB')
                        except:
                            pass
                        #Get company id
                        cursor.execute("select couid from pephire.companies where name ='" + Company +"'")
                        res = cursor.fetchall()
                        for r in res:
                            sCompanyID = r[0]

                        #Add entry in the table that maps candiates and companies      
                        InsertCandCompQry = "insert into pephire.candidate_companies values ('"+(sCandidateID+sCompanyID)+"','"+sCandidateID+"','"+sCompanyID+"','"+sTimenow+"','"+sTimenow+"','"+sTimenow+"');"
                        try:
                            cursor.execute(InsertCandCompQry)
                            cnxn.commit()
                        except:
                            print('Entry already exists')
                        UpdateCompanyFlagQry = "UPDATE pephire.candidates SET company_name_checked= '1' WHERE resume_id = '"+str(sResumeID)+"'"
                else:
                    UpdateCompanyFlagQry = "UPDATE pephire.candidates SET company_name_checked= '1' WHERE resume_id = '"+str(sResumeID)+"'"
            else:
                    UpdateCompanyFlagQry = "UPDATE pephire.candidates SET company_name_checked= '1' WHERE resume_id = '"+str(sResumeID)+"'"
            
            LogFile = open("Log.txt","a") 
            LogFile.writelines(str(Candidate[0]) + ' processed at ' + str(dt.now()) + '\n')
            LogFile.close()
            cursor.execute(UpdateCompanyFlagQry)
            cnxn.commit()
    cursor.close()      
    cnxn.close()
    time.sleep(120)


